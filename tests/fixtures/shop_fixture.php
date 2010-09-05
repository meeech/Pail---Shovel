<?php
/* Shop Fixture generated on: 2010-07-20 22:07:02 : 1279680242 */
class ShopFixture extends CakeTestFixture {
	var $name = 'Shop';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'token' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4c465ef2-d498-448d-bb05-21ba67704fc0',
			'title' => 'Lorem ipsum dolor sit amet',
			'token' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>