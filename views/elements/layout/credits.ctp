<ul id="credits">
    <li>
        <?= $this->Html->link('©'.date('Y').' mitchell amihod', 'mailto:mitchell.amihod@gmail.com?subject=re: Pail and Shovel'); ?>
    </li>
    
    <li>
        <?= $this->Html->link('FamFamFam Silk Icons', 'http://www.famfamfam.com/lab/icons/silk/',array('target' => '_blank')); ?>
    </li>
    <li>
        <?= $this->Html->link(
                $this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
                'http://www.cakephp.org/',
                array('target' => '_blank', 'escape' => false)
            );
        ?>
    </li>
</ul>