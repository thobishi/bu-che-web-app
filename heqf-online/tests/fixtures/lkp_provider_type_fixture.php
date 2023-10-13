<?php
/* LkpProviderType Fixture generated on: 2011-02-16 11:10:09 : 1297847409 */
class LkpProviderTypeFixture extends CakeTestFixture {
	var $name = 'LkpProviderType';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'uni_tech' => array('type' => 'string', 'null' => false, 'length' => 25, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'uni_tech' => 'Lorem ipsum dolor sit a'
		),
	);
}
?>