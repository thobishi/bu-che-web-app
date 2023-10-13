<?php
/* Institution Fixture generated on: 2011-02-25 10:54:09 : 1298624049 */
class InstitutionFixture extends CakeTestFixture {
	var $name = 'Institution';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary'),
		'hei_code' => array('type' => 'string', 'null' => false, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hei_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'priv_publ' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'hei_code' => 'Lor',
			'hei_name' => 'Lorem ipsum dolor sit amet',
			'priv_publ' => 1
		),
	);
}
?>