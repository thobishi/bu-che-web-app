<?php
/* LkpDeliveryMode Fixture generated on: 2011-02-16 11:31:19 : 1297848679 */
class LkpDeliveryModeFixture extends CakeTestFixture {
	var $name = 'LkpDeliveryMode';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_mode_desc' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'delivery_mode_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>