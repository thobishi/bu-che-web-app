<?php
/* LkpQualificationType Fixture generated on: 2011-02-16 17:13:38 : 1297869218 */
class LkpQualificationTypeFixture extends CakeTestFixture {
	var $name = 'LkpQualificationType';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'qualification_type_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nqf_exit_level' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'min_credit_range' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'max_credit_range' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'min_years_full_time' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'min_years_part_time' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'qualification_type_desc' => 'Lorem ipsum dolor sit amet',
			'nqf_exit_level' => 1,
			'min_credit_range' => 1,
			'max_credit_range' => 1,
			'min_years_full_time' => 1,
			'min_years_part_time' => 1
		),
	);
}
?>