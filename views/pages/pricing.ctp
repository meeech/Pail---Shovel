<div class="yui3-g">
    <div class="yui3-u-1 center-column">
        <p class="icon information">All these work, so if you are here with a real store, charges will go through (if you accept them).</p>
        <p class="icon fun">These all serve as example of charging people to use you app.</p>
    </div>
</div>
<div class="yui3-g">
    <div class="yui3-u-1-3">
        <div class="content">
            <h3>Option A</h3>
            <p>Can charge a flat rate - good for lifetime access.</p>
            <p class="center"><a class="awesome xxx-large orange" href="<?= $this->Html->url(array('controller'=>'merchants', 'action'=>'charge_flat')) ?>">Register</a></p>
            <p class="center">for 1$</p>
            <small><a target="_blank" href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'terms')) ?>">Check out the Terms. Not legalese, quick read.</a></small>
        </div>
    </div>
    <div class="yui3-u-1-3">
        <div class="content">
            <h3>Option B</h3>
            <p>Recurring payment of 1$ a month.</p>
            <p>Pay for the month, cancel when you are done.</p>
            <p class="center"><a class="awesome xxx-large orange" href="<?= $this->Html->url(array('controller'=>'merchants', 'action'=>'charge_recurring')) ?>">Signup</a></p>
            <p class="center">for a recurring month charge of 1$/month<br>cancel whenever you like.</p>
            <small><a target="_blank" href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'terms')) ?>">Check out the Terms. Not legalese, quick read.</a></small>
        </div>
    </div>
    <div class="yui3-u-1-3">
        <div class="content">
            <h3>Option C</h3>
            <p>You could even offer a pay what you want model</p>
            <?= $this->Form->create(false, array( 'class'=> 'center','url'=>array('controller'=>'merchants', 'action'=>'charge_variable'))); ?>
                <?= $this->Form->input('amount', array('value'=> '1.00', 'label'=>false, 'div'=>false, 'class'=>'small')); ?><span class="large">$</span>
                <div><small>Minimum 1$</small></div>
                <p class="center"><button type="submit" class="awesome xxx-large orange">Donate</button></p>
            <?= $this->Form->end(); ?>

            <small><a target="_blank" href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'terms')) ?>">Check out the Terms. Not legalese, quick read.</a></small>
        </div>
    </div>
