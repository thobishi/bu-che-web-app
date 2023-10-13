<?php
/* LkpHemisFundingLevel Fixture generated on: 2011-02-16 13:25:10 : 1297855510 */
class LkpHemisFundingLevelFixture extends CakeTestFixture {
	var $name = 'LkpHemisFundingLevel';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'funding_level_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'funding_level_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>