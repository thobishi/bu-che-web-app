<?php
/* S1QualificationSite Fixture generated on: 2011-02-28 12:58:15 : 1298890695 */
class S1QualificationSiteFixture extends CakeTestFixture {
	var $name = 'S1QualificationSite';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'qualification_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'site_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => '4d6b7fc7-0910-4920-9099-694cc0a80305',
			'qualification_id' => 'Lorem ipsum dolor sit amet',
			'site_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>