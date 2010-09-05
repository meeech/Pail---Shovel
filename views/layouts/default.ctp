<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php __('Pail & Shovel:'); ?>
        <?php echo $title_for_layout; ?>
    </title>

    <base href="<?= $this->Html->url('/',true); ?>" />
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?3.2.0pr1/build/cssfonts/fonts-min.css&3.1.1/build/cssreset/reset-min.css&3.1.1/build/cssbase/base-min.css&3.2.0pr1/build/cssgrids/grids-min.css">

    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('main', 
        'header',
        'footer', 'forms', 'buttons'));
        // echo $scripts_for_layout;
    ?>
    <script type="text/javascript">
       WebFontConfig = {
         google: { families: [ 'Crimson Text', 'Reenie Beanie'] }
       };
     </script>
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
     <script type="text/javascript" src="http://yui.yahooapis.com/combo?3.2.0pr1/build/yui/yui-min.js"></script>
</head>
<body>
    <div id="container">
        <?= $this->element('header'); ?>
        <div id="content">

            <?php echo $this->Session->flash(); ?>
            <div class="yui3-g">
                <?php echo $content_for_layout; ?>
            </div>
        </div>
        <div id="footer" class="yui3-g">
            <div class="yui3-u-1">
                <?php echo $this->element('layout/credits'); ?>                            
            </div>
        </div>
        <div id="ajax-indicator" class="inline-hide"><?= $this->Html->image('ajax-loader.gif'); ?></div>
        <div id="status-message" class="inline-hide">Status Message</div>
    </div>
    <?= $this->Html->script('main') ?>

<?php 
//Used to flag site to make sure I'm aware that I'm on test app. 
//You could remove it. But I've found it handy, when developing locally, its good to have a visual cue.
//You could put anything there really.
if ('localhost' == env('HTTP_HOST')): ?>
<style type="text/css" media="screen">
div#localhost-bar {
    background: green;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    opacity: .5;
}
</style>
<div id="localhost-bar">localhost</div>
<?php endif ?>
</body>
</html>