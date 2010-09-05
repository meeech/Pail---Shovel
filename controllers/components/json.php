<?php
/**
 * JsonComponent for CakePHP
 *
 * Used to centralize some JSON output. 
 *
 * @usage Create an elements/json.ctp for your output - expects a var $output which it will output as a json object
 * @settings: fakeAjax (false) Set to true to make cake think any incoming req is a ajax req. Useful to load the page in your browser. 
 *            debug (false) Set to true to allow app core debug setting to remain. 
 *            Otherwise, we set debug to 0 to suppress other output.
 *
 * @author Mitchell Amihod
 */
class JsonComponent extends Object {
    
    var $controller;
    var $components = array('RequestHandler');

    /**
     * Will make json component think any incoming req is ajax.
     * Useful to test the url in your browser
     *
     * @var bool
     */
    var $fakeAjax = false;
    
    /**
     * Use application level debug setting
     *
     * @var bool
     */
    var $debug = false;

    public function initialize(&$controller, $settings=array()) {
        $this->controller =& $controller;
        $this->_set($settings);

        if($this->fakeAjax) {
            //Trick ReqHandler to think its an ajax request
            $_ENV['HTTP_X_REQUESTED_WITH'] = "XMLHttpRequest";
            $_SERVER['HTTP_X_REQUESTED_WITH'] = "XMLHttpRequest";
        }
    }
    
    public function startup(&$controller) {
        if($this->RequestHandler->isAjax()) {
            //If we aren't in debug mode, turn off error messaging
            if(!$this->debug) {
                Configure::write('debug', 0);
            }

            //For use of default cake ajax layout. Else reqHandler tries to find json/default.ctp
            $controller->layoutPath = '';
            $controller->layout = 'ajax';
            //Need to turn off autoRender.
            $controller->autoRender = false;
        }
    }
    
    public function shutdown(&$controller) {
        if($this->RequestHandler->isAjax()) {
            $controller->output = $controller->render('../elements/json');
        }
    }
}
