<?php
/* HeqfQualification Fixture generated on: 2011-02-11 08:56:49 : 1297407409 */
class HeqfQualificationFixture extends CakeTestFixture {
	var $name = 'HeqfQualification';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'qualification_reference_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'heqc_reference_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'qualification_title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'qualification_title_short' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'institution_qualification_title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'heqc_application_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'saqa_qualification_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_qualification_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_designator_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'other_designator' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'motivation_other_designator' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lkp_cesm1_code_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_delivery_mode_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_professional_class_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'professional_body' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lkp_nqf_level_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_total' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf5' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf6' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf7' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf8' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf9' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'credits_nqf10' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'minimum_admission_requirements' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'minimum_years_full' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'minimum_years_part' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'first_qualifier' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lkp_cesm2_code_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'first_qualifier_credits' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'first_qualifier_credits_final' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'second_qualifier' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lkp_cesm3_code_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'second_qualifier_credits' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'second_qualifier_credits_final' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'wil_el_credits' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'qualification_purpose' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'exit_level_outcome' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'articulation_progression' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'rpl' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'international_comparability' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hemis_lkp_cesm3_code_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lkp_hemis_heqf_qualification_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'hemis_minimum_exp_time' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'hemis_total_subsidy_units' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'lkp_hemis_funding_level_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'heqf_reference_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => '4d54ddb1-1efc-4a52-bc54-3a22c0a80305',
			'qualification_reference_no' => 'Lorem ipsum dolor sit amet',
			'heqc_reference_no' => 'Lorem ipsum d',
			'qualification_title' => 'Lorem ipsum dolor sit amet',
			'qualification_title_short' => 'Lorem ipsum dolor sit amet',
			'institution_qualification_title' => 'Lorem ipsum dolor sit amet',
			'heqc_application_id' => 1,
			'saqa_qualification_id' => 1,
			'lkp_qualification_type_id' => 1,
			'lkp_designator_id' => 'L',
			'other_designator' => 'Lorem ipsum dolor sit amet',
			'motivation_other_designator' => 'Lorem ipsum dolor sit amet',
			'lkp_cesm1_code_id' => 1,
			'lkp_delivery_mode_id' => 1,
			'lkp_professional_class_id' => 1,
			'professional_body' => 'Lorem ipsum dolor sit amet',
			'lkp_nqf_level_id' => 1,
			'credits_total' => 1,
			'credits_nqf5' => 1,
			'credits_nqf6' => 1,
			'credits_nqf7' => 1,
			'credits_nqf8' => 1,
			'credits_nqf9' => 1,
			'credits_nqf10' => 1,
			'minimum_admission_requirements' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'minimum_years_full' => 1,
			'minimum_years_part' => 1,
			'first_qualifier' => 'Lorem ipsum dolor sit amet',
			'lkp_cesm2_code_id' => 1,
			'first_qualifier_credits' => 1,
			'first_qualifier_credits_final' => 1,
			'second_qualifier' => 'Lorem ipsum dolor sit amet',
			'lkp_cesm3_code_id' => 1,
			'second_qualifier_credits' => 1,
			'second_qualifier_credits_final' => 1,
			'wil_el_credits' => 1,
			'qualification_purpose' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'exit_level_outcome' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'articulation_progression' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'rpl' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'international_comparability' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'hemis_lkp_cesm3_code_id' => 'Lore',
			'lkp_hemis_heqf_qualification_type_id' => 1,
			'hemis_minimum_exp_time' => 1,
			'hemis_total_subsidy_units' => 1,
			'lkp_hemis_funding_level_id' => 1,
			'heqf_reference_no' => 'Lorem ipsum d'
		),
	);
}
?>