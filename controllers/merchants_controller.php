<?php
class MerchantsController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Merchants';

/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html','Time');

    /**
     * Controller beforeFilter callback.
     * Called before the controller action. 
     * 
     * @return void
     */
    function beforeFilter() {
        $this->initLanguage();

        //Don't fire beforefilter which inits sessions for these 2 actions.
        if( 'login' != $this->action && 'logout' != $this->action) {
            parent::beforeFilter();
        }
    }

    /**
     * Cancel a recurring charge
     *
     * @return void
     **/
    function cancel($charge_id = false) {
        
        //Validate the Charge ID they are cancelling is their own:
        if($charge_id && $charge_id != $this->Session->read('Merchant.charge_id')) {
            $this->Session->setFlash(__('Sorry, but it looks like you are trying to cancel a charge which does not belong to you.'));
            $charge_id = false;
        }
        
        if($charge_id) {
            
            $results = $this->Shopify->recurring_application_charge->cancel($charge_id);

            //Error comes in as an HTML page :/
            $error = trim($results['error']);
            
            if(empty($error)) {
                $this->Session->setFlash(__('Thanks. Your account has been Cancelled.'));
            }
            else {
                $this->Session->setFlash(__('There has been a problem cancelling. Please contact support.'));
            }
            $this->logout();
        }
    }

    /**
     * Handle a recurring charge yo.
     *
     * @return void
     **/
    function charge_recurring() {
        $this->charge('recurring_application_charge', 1.00);
    }

    /**
     * Handle the flat charge
     *
     * @return void
     */
    function charge_flat() {
        $this->charge('application_charge', 1.00);
    }


    /**
     * Handle the form charge
     *
     * @return void
     */
    function charge_variable() {
        
        if(!empty($this->data) && isset($this->data['amount'])) {
            $amount = (float)$this->data['amount'];
            if( 1 > $amount) { $amount = 1.00; }
            $this->charge('application_charge', 1.00);
        }
        
        $this->redirect('/');
    }


    /**
     * Send the user through to the charge page, process the charge
     *
     * @param string $type Which type of charge. application_charge or recurring_application_charge
     * @param float $amount amount to charge
     * @return void
     **/
    function charge($charge_type='application_charge', $amount = false) {
        //If they have paid, no access
        if(!is_null($this->Session->read('Merchant.paid'))) {
            $this->Session->setFlash('You have already registered');
            $this->redirect('/');
        }
        
        $charge_id = (isset($this->params['url']['charge_id'])) ? $this->params['url']['charge_id'] : false ;
        //No charge ID, so they are asking to be charged, so forward them along.
        if(!$charge_id) {
            $this->_doChargeRequest($charge_type, $amount);
        } 
        else {
            $response = $this->Shopify->$charge_type->get($charge_id);
            //Some possible Statuses
            // accepted/active/declined/pending
            $accepted = ('accepted' == $response['status']);
            //Activate it...
            if($accepted) {
                //@We should prolly store the accepted charge id at some point
                $activate_response = $this->Shopify->$charge_type->activate($charge_id);
                
                $error = trim($activate_response['error']);
                if(!empty($error)) {
                    $this->Session->setFlash('There was an error activating your account. Please contact support, and include the below error message.<br>Error: '.$error);
                    $this->redirect('/');
                } else {
                    //Success! So update the record, flush the session, and relog in the user
                    $this->Merchant->read(null, $this->Session->read('Merchant.id'));
                    $this->Merchant->set(array(
                        'charge_id'=>$charge_id,
                        'paid' => date('Y-m-d H:i:s'),
                        'recurring' => (int)($charge_type == 'recurring_application_charge')
                    ));
                    $this->Merchant->save();
                    $shop = $this->Session->read('Shopify.shop');
                    $this->Session->delete('Shopify');
                    $this->Session->delete('Merchant');
                    // $this->Session->destroy();
                    $this->Session->setFlash('Thanks for registering!');
                    $this->redirect(array('controller'=>'pages', 'action'=> 'display', 'home', '?'=>'shop='.$shop));
                }
            }
        }
        //Since we call $this->charge from charge_recurring
        $this->render('charge');
    }
    
    
    /**
     * First part of activating an account. 
     * Redirect user to the Shopify Approve Charge page.
     *
     * @param string $charge_type Which type of charge. application_charge or recurring_application_charge
     * @param float $charge the cost of the charge
     * @return void
     **/
    function _doChargeRequest($charge_type, $charge) {

        $charge = number_format($charge, 2);

        if('application_charge' == $charge_type) {
            $returnUrl = Router::url(array('controller'=>'merchants', 'action'=>'charge'), true);
            $charge = array(
                'price' => $charge,
                'name' => htmlentities(Configure::read('Shopify.app_name')).': Registered Account',
                'return-url' => $returnUrl,
                'test' => $this->Session->read('Shop.test')
            );
        }
        else { //Recurring
            $returnUrl = Router::url(array('controller'=>'merchants', 'action'=>'charge_recurring'), true);
            $charge = array(
                'price' => $charge,
                'name' => htmlentities(Configure::read('Shopify.app_name')).': Monthly Account',
                'return-url' => $returnUrl,
                'test' => $this->Session->read('Shop.test')
            );
        }

        //@failure. 
        //@note: request better error instead of html error page. give back response.
        $response = $this->Shopify->$charge_type->create($charge);
        //Send them along.            
        if(isset($response['confirmation-url'])) {
            $this->redirect($response['confirmation-url']);
        } else {
            $this->Session->setFlash('Error trying to charge you. If it persists, please contact support.');
            $this->redirect(array('controller'=>'pages', 'action'=> 'display', 'home'));
        }
    }


    /**
     * Convienience method to all user to submit their storename and pass them to the welcome action.
     *
     * @return void
     **/
    function login() {
        if(empty($this->data) || empty($this->data['shop_id'])) {
            $this->Session->setFlash('Your shop name is missing.', 'default', array(), 'login');
            $this->redirect('/');
        }

        //In case someone submits their full url, strip out the suffix.
        $suffix = '.myshopify.com';
        $shop = str_replace($suffix, '', $this->data['shop_id']). $suffix;
        $this->redirect(array('controller'=> 'pages', 'action'=>'display', 'home', '?'=>"shop={$shop}"));
    }
    
    /**
     * Remove sessions with info. 
     *
     * @return void
     **/
    function logout() {
        //destroy doesn't work? 
        $this->Session->delete('Shopify');
        $this->Session->delete('Merchant');
        $this->Session->delete('Shop');
        $this->redirect('/');
    }

    /**
     * Reset the merchants account - remove the fact that they paid.
     *
     * @return void
     **/
    function reset() {
        $this->Merchant->read(null, $this->Session->read('Merchant.id'));
        $this->Merchant->save(array('charge_id'=> null, 'paid'=>null, 'valid_till'=>null, 'recurring'=> 0));
        $this->logout();
    }

}
