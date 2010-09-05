<!-- Template for page simple centered column -->
<div class="yui3-u-1 center-column">
    <h3 class="icon information">About Page</h3>
    <p class="icon fun">
        In this case, we're looking at a simple centered column.
    </p>

    <?php if ($this->Session->read('Shop.test')): ?>
        <p>In Test Mode. You are using a development shop.</p>
        <p>Registration options will function in test shop mode, so go ahead, have fun.</p>
    <?php endif ?>
    <p>
        You can see a series of 
    <a href="<?= $this->Html->url(array('controller'=>'pages', 'action'=>'display', 'pricing')) ?>">registration options</a> as an example. 
    </p>
    <p class="icon information">
        This project itself is on github, and is what I
        use for random little dev tools. 
        I also  base new shopify apps off of. 
        You can install a copy on your server to use, or use this one.
    </p>
    <p class="icon information">
        Feel free to contact <a href="mailto:mitchell.amihod@gmail.com?subject=re:PailShovel">me</a> if you have any questions.
    </p>
</div>

