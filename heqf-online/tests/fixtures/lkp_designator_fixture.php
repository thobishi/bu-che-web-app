<?php
/* LkpDesignator Fixture generated on: 2011-02-16 17:01:47 : 1297868507 */
class LkpDesignatorFixture extends CakeTestFixture {
	var $name = 'LkpDesignator';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'designator_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 'L',
			'designator_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>