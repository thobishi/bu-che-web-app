<?php
/* LkpHemisQualificationType Fixture generated on: 2011-02-16 13:01:37 : 1297854097 */
class LkpHemisQualificationTypeFixture extends CakeTestFixture {
	var $name = 'LkpHemisQualificationType';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hemis_qualification_type_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'hemis_qualification_type_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>