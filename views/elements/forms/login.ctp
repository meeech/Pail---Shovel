<p>You can login via your store admin, or use the form below:</p>
<div style="margin-bottom: 35px">
    <?= $this->Form->create(false, array('id'=>'shopLogin', 'url'=>array('controller'=>'merchants', 'action'=>'login'))); ?>
        <?= $this->Form->input('shop_id', array('label'=>false, 'div'=>false)); ?><span class="large">.myshopify.com</span>
        <button class="large green awesome">Login</button>
    <?= $this->Form->end(); ?>
    <?php echo $this->Session->flash('login'); ?>
</div>
