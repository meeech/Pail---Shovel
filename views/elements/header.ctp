<!-- We create a 50/50 grid for the header.-->
<div id="header" class="yui3-g">
    <div class="yui3-u-1-2">
        <h1><a class="logo" href="<?=$this->Html->url('/')?>"><?= Configure::read('Shopify.app_name')?></a></h1>
    </div>
    <div class="yui3-u-1-2">
        <div class="info">
            <ul>
            <?php 
            //Check the session to see if we have a logged in shop
            if ($this->Session->read('Shopify.shop')): 
            ?>
                <li>Shop: <a target="_blank" href="http://<?=$this->Session->read('Shopify.shop')?>/admin"><?= $this->Session->read('Shopify.shop');?></a></li>
                <?php 
                // Check if they have paid, otherwise, give some info. ie: how many days left in demo mode.
                if (is_null($this->Session->read('Merchant.paid'))): ?>
                    <li>Demo Mode.</li>
                <?php 
                endif;
                ?>
            <?php else: ?>
                <li>Not logged in.</li>
            <?php endif ?>

                <li>
                    <?php if ($this->Session->read('Shopify.shop')): ?>
                        <a class="large orange awesome logout" href="<?= $this->Html->url(array('controller'=>'merchants', 'action'=>'logout')) ?>">Logout</a>
                    <?php endif; ?>

                    <a class="large ocean awesome support" href="<?= $this->Html->url('/') ?>">Home</a> 
                    <a class="large ocean awesome about" href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'about')) ?>">About</a> 
                </li>
            </ul>
        </div>    
    </div>
</div>

