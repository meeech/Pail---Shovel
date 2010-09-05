<?php
/* Shop Test cases generated on: 2010-07-20 22:07:02 : 1279680242*/
App::import('Model', 'Shop');

class ShopTestCase extends CakeTestCase {
	var $fixtures = array('app.shop');

	function startTest() {
		$this->Shop =& ClassRegistry::init('Shop');
	}

	function endTest() {
		unset($this->Shop);
		ClassRegistry::flush();
	}

}
?>