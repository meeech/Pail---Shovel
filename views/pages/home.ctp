<!-- YUI Single Unit -->
<div class="yui3-u-1" >
    <h2 class="margin-top icon fun">Welcome to the Homepage.</h2>
    
    <?php 
    //Check if we have a logged in user this way:
    if (!$this->Session->read('Shopify.shop')): 
        echo $this->element('forms/login');
    endif ?>
    
</div>
<div class="yui3-u-1-2">
    <p>You can find the code on <a href="http://github.com/meeech/Pail---Shovel">github</a>.</p>
    <p>A CakePHP App which I use as my framework when making a Shopify App.</p>
    <p>This site also contains some tools developers & designers working with Test Stores might find useful.</p>
    <p>Features will be added regularly, as it's also my lab. </p>
    <p>Thought it might be useful for other people - as an example, or to build off of.</p>
    <p>You can use it on your shop, though best for Test Shops.</p>
    <p>Feedback welcome. </p>

    <?php if ($this->Session->read('Shopify.shop')):  ?>
        <?php //Demo Mode
        if (is_null($this->Session->read('Merchant.paid'))): 
        ?>
            <h3 class="icon information">You are Demo mode.</h3>
            <p>Tell me more about <a class="awesome xxx-large orange" href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'pricing')) ?>">How to Register!</a></p>
        <?php
        else:
        ?>
            <p>You registered on <?= $this->Time->nice($this->Session->read('Merchant.paid')); ?>.

            <?php if (1 == $this->Session->read('Merchant.recurring')): ?>
                <p>You are signed up to pay Monthly. You can 
                    <a class="awesome large orange" href="<?= $this->Html->url(array('controller'=>'merchants', 'action'=>'cancel')) ?>">Cancel</a> anytime.</p>
            <?php endif ?>
        <?php 
        endif; 
        ?>
    <?php endif ?>    
</div>
<div class="yui3-u-1-2" >
    <h3 class="icon information">Examples so far</h3>
        <div class="content center">
            <h4>Logging in a Store.</h4>
        </div>
        <div class="content">
            <h4>Random Product Loader</h4>
             <a class="float-right awesome xxx-large green" href="<?= $this->Html->url(array('controller'=>'products', 'action'=>'random')) ?>">Show Me!</a>
             <p>Add random products to your shop.</p>

        </div>
        <div class="content">
            <h4>Charging options</h4>
            <a class="float-right awesome xxx-large ocean"  href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'pricing')) ?>">Demo it</a>
            <p>Shows recurring, one-time, as well as name-your-price form.</p>

        </div>

        <div class="content center">
            <a class="awesome xxx-large red" href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'about')) ?>">Big Buttons!</a>
        </div>
</div>
