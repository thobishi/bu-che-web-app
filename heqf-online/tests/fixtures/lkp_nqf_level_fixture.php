<?php
/* LkpNqfLevel Fixture generated on: 2011-02-16 11:33:13 : 1297848793 */
class LkpNqfLevelFixture extends CakeTestFixture {
	var $name = 'LkpNqfLevel';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nqf_level_desc' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'nqf_level_desc' => 'Lorem ipsum dolor '
		),
	);
}
?>