<div class="yui3-u-1 center-column">
    <h3 class="icon important">Cancel <?= Configure::read('Shopify.app_name')?> Recurring Charge</h3>
    <p class="icon error">
        Hey. Looks like you opted for the Recurring Monthly Charge for <?= Configure::read('Shopify.app_name')?>. You can cancel that charge here.
    </p>
    <p class="icon information">
        Note: There's no going back. Once cancelled, you will be back in Demo mode. 
    </p>
    <p class="center">
        <a class="awesome xxx-large orange" href="<?= $this->Html->url(array('controller'=>'merchants', 'action'=>'cancel', $this->Session->read('Merchant.charge_id'))) ?>">Cancel</a>
    </p>
</div>
