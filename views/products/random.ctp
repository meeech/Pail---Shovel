<div class="yui3-u-1 center-column">

    <h2 class="center">Product Attributes</h2>
<?php echo $this->Form->create('Product'); ?>
    
    <div class="center">
        <?php echo $this->Form->input('Product.title', array('tabindex'=>1,'class'=>'small','label'=>false, 'div'=>false)); ?><span class="large">Title</span>
        <br><small>Leave blank for random</small>        
    </div>
    <div class="center pad-top">
        <?php echo $this->Form->input('Product.inventory-quantity', array('tabindex'=>2,'class'=>'tiny','label'=>false, 'div'=>false)); ?><span class="large">Amount in stock</span>
        <br><small>Leave blank for random</small>
    </div>

    <hr>
    <div class="center pad-top">
        <div class="large">How many products?</div>
        <input tabindex="3" class="tiny" type="text" name="iterations" value="1">
    </div>

    <div class="center pad-top"><button tabindex="9" type="submit" class="awesome xxx-large green">Create!</button></div>
    
<?php echo $this->Form->end(); ?>


</div>