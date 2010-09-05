<?php
class ProductsController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
    var $name = 'Products';

    var $uses = array();

    /**
     * Delete a product from shopify - meant called js
     *
     * @param string $id 
     */
    function delete($id = false) {
        $output = array();
        if(false == $id) {
            $output['error'] = 'Product ID is missings.';
        } else {
            $this->Shopify->product->remove($id);
        }

        $this->set(compact('output'));
    }

    /**
     * Fetch products, meant to be called via js
     * Creates simple id, title, stock 
     *
     * @param int $page Page number
     * @param int $limit How many records. Max is 250.
     *
     * @return void
     **/
    function get($page = 1, $limit = 20) {

        $products = $this->Shopify->product->get(0, 0, array('page' => $page, 'limit' => $limit));
        
        $output = array('Results'=>array());
        
        foreach ($products as $product) {
            //Get the stock level - if there's an [variant][0], then there's more than one
            if( isset($product['variants']['variant'][0]) ) {
                //Extract it
                $stockLevels = Set::classicExtract($product['variants']['variant'],'{n}.inventory-quantity');
                $stock = array_sum($stockLevels);
            } else {
                $stock = $product['variants']['variant']['inventory-quantity'];
            }

            $p = array(
                'id' => $product['id'],
                'title' => $product['title'],
                'stock' => $stock
            );
            $output['Results'][] = $p;
        }

        $output['Total'] = count($output['Results']);
        $output['Page'] = $page;
        $output['Limit'] = $limit;
        
        $this->set('output',$output);
    }


    /**
     * Create a product.
     * @param array options for the product. Can take any of the top level options for now
     *              options[title] *required
     *              options[inventory-quantity] - will get mapped out to the proper spot before merge of options
     *              
     * @return void
     **/
    function create($options) {

        $inventoryQuantity = rand(0,100);
        if(isset($options['inventory-quantity'])){
            $inventoryQuantity = $options['inventory-quantity'];
            unset($options['inventory-quantity']);
        }
        
        $productFields = array(
            'product-type' => 'Books',
            'body-html' => 'This is some HTML for the Product',
            'title' => '',
            'variants' => array(
                array(
                    'inventory-management' => 'shopify',
                    'inventory-quantity' => $inventoryQuantity,
                    'price'=>'10.00',
                    'option1' =>'first'
                )
            ),
            'vendor' => 'None'
        );

        $productFields = $options + $productFields;

        return $this->Shopify->product->create($productFields);
    }


    /**
     * Generate random products
     *
     * @return void
     **/
    function random() {
        
        if(!empty($this->data) && $this->RequestHandler->isAjax()) {
                
            $output = array();

            //Random title
            if('' == trim($this->data['Product']['title'])) {
                $this->data['Product']['title'] = $this->_randomWord();
            }
            
            //Random inventory level
            if('' == trim($this->data['Product']['inventory-quantity'])) {
                unset($this->data['Product']['inventory-quantity']);
            }
            
            $response = $this->create($this->data['Product']);

            if(is_array($response) && isset($response['error'])) {
                $output['error'] = array('message' => $response['error']);
            } 
            else {
                $output['success'] = array('message'=> 'Created ' . $this->data['Product']['title'] );
            }
            $this->set(compact('output'));
        }

    }


    /**
     * Create random word for title
     * Uses /usr/share/dict/web2a but swap in whatever you want.
     *
     * @return string
     **/
    function _randomWord() {
        $words = file(APP.'vendors/random_words.txt');
        return str_replace("\n", '', $words[rand(0, count($words))]);
    }

}
