<?php
/* HeqfQualificationSite Fixture generated on: 2011-02-28 12:58:03 : 1298890683 */
class HeqfQualificationSiteFixture extends CakeTestFixture {
	var $name = 'HeqfQualificationSite';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'heqf_qualification_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'site_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => '4d6b7fbb-35d4-45be-90e7-694cc0a80305',
			'heqf_qualification_id' => 'Lorem ipsum dolor sit amet',
			'site_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>