YUI().use("node", "event","event-custom","io-form", "substitute", "transition", "json-parse",
function(Y) {
//Begin Closure

//Selectors / IDs, Classes
var selectors = {
    AJAX_INDICATOR: '#ajax-indicator',
    STATUS: '#status-message'
};

// Hold message strings for later easy multilingualizations
var msg = {
    ABORT: 'Cancelled.',
    DONE: 'Done!',
    LEAVE_PAGE_WARNING: 'Are you sure you want to leave?'
};

var navigateAwayProtect = function() {
    window.onbeforeunload = function (e) {
      e = e || window.event;

      // For IE and Firefox
      if (e) {
        e.returnValue = msg.LEAVE_PAGE_WARNING;
      }

      // For Safari
      return msg.LEAVE_PAGE_WARNING;
    };
};

var navigateAwayCancel = function() {
    window.onbeforeunload = null;
};


//Hold a ref to the current timer for hiding the flash msg, so we can cancel if another message comes in
var flashHideTimer = false;
//Cache the node for flash messaging
var statusNode = Y.one(selectors.STATUS);
var statusMessage = function(msg) {
    statusNode.removeClass('inline-hide').setStyle('opacity', 1).setContent(msg);
    if(flashHideTimer) {
        flashHideTimer.cancel();
    }
    flashHideTimer = Y.later(3000, {}, function() {
        statusNode.transition({
            easing: 'ease-none',
            duration: 1, 
            opacity: 0
        });
    });
};

/**
 * Deal with the Random Product creation
 *
 */

if(Y.one('form#ProductRandomForm')) {
//ProductRandomForm wrapper
var productRandomForm  = Y.one('form#ProductRandomForm');

var createRandomProduct = function(o) {

    productRandomForm.one('button[type=submit]').addClass('disabled').set('disabled',true);

    var cfg = {
        method: 'POST', 
        form: { id: productRandomForm },
        on: {
            success:  function(id, o) {
                var resp = Y.JSON.parse(o.responseText);
                statusMessage(resp.success.message);
                var iterations = productRandomForm.one('input[name=iterations]');
                if( parseInt(iterations.get('value'),10) > 1) {
                    iterations.set('value', iterations.get('value')-1);
                    //THrottle things a bit
                    Y.later(500, {}, function() {
                        Y.fire('productrandom:submit');
                    });
                } else {
                    productRandomForm.one('button[type=submit]').removeClass('disabled').set('disabled',false);
                }
            }
        }
    };

    var request = Y.io(productRandomForm.get('action'), cfg);
    
};

Y.on('productrandom:submit', createRandomProduct);

productRandomForm.on('submit', function(e) {
    e.preventDefault();
    Y.fire('productrandom:submit');
});
// ProductRandomForm end
}

//Set Inputfield focus:
if(Y.one('input#shop_id')) {
    Y.one('input#shop_id').focus();
}


//End closure
});
