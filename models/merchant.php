<?php
/**
 * Shopify Merchant Class.
 *
 * Rather than using uuid for Primary Key, we are using the subdomain prefix from 
 * foo.myshopify.com, since technically, that should be unique per client.
 *
 * @author Mitchell Amihod
 */
class Merchant extends AppModel {
    var $name = 'Merchant';
    var $displayField = 'title';
    
    var $validate = array(
        'id' => 'notEmpty',
        'title' => 'notEmpty'
    );

    /**
     * How many requests a demo user has left. Example, if you needed it. You set the limit in the shopify config file, 
     * or whereever you want really. 
     *
     * @return int
     **/
    function requestsRemaining() {
        return Configure::read('Shopify.demo_limit') - $this->data['Merchant']['requests'];
    }
    
}
?>