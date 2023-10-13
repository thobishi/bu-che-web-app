<?php
/* LkpHemisQualifier Fixture generated on: 2011-02-16 12:57:09 : 1297853829 */
class LkpHemisQualifierFixture extends CakeTestFixture {
	var $name = 'LkpHemisQualifier';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hemis_qualifier_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 'Lore',
			'hemis_qualifier_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>