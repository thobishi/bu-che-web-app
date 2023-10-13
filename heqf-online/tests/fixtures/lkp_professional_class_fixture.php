<?php
/* LkpProfessionalClass Fixture generated on: 2011-02-16 17:21:00 : 1297869660 */
class LkpProfessionalClassFixture extends CakeTestFixture {
	var $name = 'LkpProfessionalClass';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'professional_class_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'professional_class_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>