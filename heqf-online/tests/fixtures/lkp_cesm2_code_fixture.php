<?php
/* LkpCesm2Code Fixture generated on: 2011-02-16 17:39:34 : 1297870774 */
class LkpCesm2CodeFixture extends CakeTestFixture {
	var $name = 'LkpCesm2Code';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'DOE_CESM_code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'DOE_CESM_code' => 'Lore',
			'Description' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>