<?php
/* Qualification Fixture generated on: 2011-02-11 09:35:28 : 1297409728 */
class QualificationFixture extends CakeTestFixture {
	var $name = 'Qualification';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'qualification_reference_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'heqc_reference_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'qualification_title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'qualification_title_short' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'institution_qualification_title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'heqc_application_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'saqa_qualification_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_delivery_mode_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_nqf_level_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_total' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf5' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf6' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf7' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf8' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'minimum_admission_requirements' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'minimum_years_full' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'minimum_years_part' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_heqf_align_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'teachout_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'lkp_hemis_qualifier_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lkp_hemis_qualification_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'hemis_minimum_exp_time' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'hemis_total_subsidy_units' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_hemis_funding_level_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => '4d54e6c0-ba70-4635-87ea-3b1dc0a80305',
			'qualification_reference_no' => 'Lorem ipsum dolor sit amet',
			'heqc_reference_no' => 'Lorem ipsum d',
			'qualification_title' => 'Lorem ipsum dolor sit amet',
			'qualification_title_short' => 'Lorem ipsum dolor sit amet',
			'institution_qualification_title' => 'Lorem ipsum dolor sit amet',
			'heqc_application_id' => 1,
			'saqa_qualification_id' => 1,
			'lkp_delivery_mode_id' => 1,
			'lkp_nqf_level_id' => 1,
			'credits_total' => 1,
			'credits_nqf5' => 1,
			'credits_nqf6' => 1,
			'credits_nqf7' => 1,
			'credits_nqf8' => 1,
			'minimum_admission_requirements' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'minimum_years_full' => 1,
			'minimum_years_part' => 1,
			'lkp_heqf_align_id' => 'Lorem ipsum dolor sit ame',
			'teachout_date' => '2011-02-11',
			'lkp_hemis_qualifier_id' => 'Lore',
			'lkp_hemis_qualification_type_id' => 1,
			'hemis_minimum_exp_time' => 1,
			'hemis_total_subsidy_units' => 1,
			'lkp_hemis_funding_level_id' => 1
		),
	);
}
?>