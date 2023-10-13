<?php
class HeqfHelper extends AppHelper {
	var $helpers = array('Html');
	public $section1Fields = array(
		's1_institution_name' => 'Institution name',
		's1_institution_code' => 'HEQC institution number',
		's1_lkp_provider_type_id' => 'Provider type',
		's1_qualification_reference_no' => 'Qualification reference number',
		's1_heqc_reference_no' => 'HEQC reference number',
		's1_qualification_title' => 'Qualification title',
		's1_qualification_title_short' => 'Qualification title abbreviation',
		//'s1_institution_qualification_title' => 'Institution qualification title',
		's1_saqa_qualification_id' => 'SAQA qualification ID', 'type' => 'text',
		's1_lkp_delivery_mode_id' => 'Mode of delivery',
		's1_lkp_nqf_level_id' => 'NQF Exit Level',
		's1_credits_total' => 'Total credits',
		/*'s1_credits_nqf5' => 'Total credits NQF 5',
		's1_credits_nqf6' => 'Total credits NQF 6',
		's1_credits_nqf7' => 'Total credits NQF 7',
		's1_credits_nqf8' => 'Total credits NQF 8',
		's1_credits_nqf9' => 'Total credits NQF 9',
		's1_credits_nqf10' => 'Total credits NQF 10',*/
		's1_minimum_years_full' => 'Minimum duration full',
		's1_minimum_years_part' => 'Minimum duration part',
		's1_lkp_heqf_align_id' => 'Proposed HEQSF Category',
		's1_teachout_date' => 'Teach-out date',
		's1_lkp_hemis_qualifier_id' => 'Major field of study',
		's1_lkp_hemis_qualification_type_id' => 'HEMIS qualification type',
		's1_hemis_minimum_exp_time' => 'HEMIS minimum experiential time',
		's1_hemis_total_subsidy_units' => 'Total subsidy units',
		's1_lkp_hemis_funding_level_id' => 'Funding level',
		's1_minimum_admission_requirements' => 'Min Admission Req',
		's1_site_1' => 'Site of delivery 1',
		's1_site_2' => 'Site of delivery 2',
		's1_site_3' => 'Site of delivery 3',
		's1_site_4' => 'Site of delivery 4',
		's1_site_5' => 'Site of delivery 5',
		's1_site_6' => 'Site of delivery 6',
		's1_site_7' => 'Site of delivery 7',
		's1_site_8' => 'Site of delivery 8',
		's1_site_9' => 'Site of delivery 9',
		's1_site_10' => 'Site of delivery 10',
		's1_site_11' => 'Site of delivery 11',
		's1_site_12' => 'Site of delivery 12',
		's1_site_13' => 'Site of delivery 13',
		's1_site_14' => 'Site of delivery 14',
		's1_site_15' => 'Site of delivery 15',
		's1_site_16' => 'Site of delivery 16',
		's1_site_17' => 'Site of delivery 17',
		's1_site_18' => 'Site of delivery 18',
		's1_site_19' => 'Site of delivery 19',
		's1_site_20' => 'Site of delivery 20',
		's1_site_21' => 'Site of delivery 21',
		's1_site_22' => 'Site of delivery 22',
		's1_site_23' => 'Site of delivery 23',
		's1_site_24' => 'Site of delivery 24',
		's1_site_25' => 'Site of delivery 25',
		's1_site_26' => 'Site of delivery 26',
		's1_site_27' => 'Site of delivery 27',
		's1_site_28' => 'Site of delivery 28',
		's1_site_29' => 'Site of delivery 29',
		's1_site_30' => 'Site of delivery 30'
	);

	public $section2Fields = array(
		'qualification_reference_no' => 'Qualification reference number',
		'heqc_reference_no' => 'HEQC reference number',
		'qualification_title' => 'Qualification title',
		'qualification_title_short' => 'Qualification title abbr',
		//'institution_qualification_title' => 'Institution qualification title',
		'lkp_qualification_type_id' => 'Qualification type',
		'lkp_designator_id' => 'Qualification designator',
		'other_designator' => 'Other designator',
		'motivation_other_designator' => 'Motivation for other designator',
		'lkp_cesm1_code_id' => 'CESM',
		'lkp_delivery_mode_id' => 'Mode of delivery',
		'lkp_professional_class_id' => 'Professional class',
		'professional_body' => 'Professional body',
		'lkp_nqf_level_id' => 'NQF Exit Level',
		'credits_total' => 'Total credits',
		/*'credits_nqf5' => 'Total credits NQF 5',
		'credits_nqf6' => 'Total credits NQF 6',
		'credits_nqf7' => 'Total credits NQF 7',
		'credits_nqf8' => 'Total credits NQF 8',
		'credits_nqf9' => 'Total credits NQF 9',
		'credits_nqf10' => 'Total credits NQF 10',
		'first_qualifier' => 'First qualifier FQ',
		'lkp_cesm2_code_id' => 'FQ CESM',
		'first_qualifier_credits' => 'FQ credits',
		'first_qualifier_credits_final' => 'FQ final year credits',
		'second_qualifier' => 'Second qualifier SQ',
		'lkp_cesm3_code_id' => 'SQ CESM',
		'second_qualifier_credits' => 'SQ credits',
		'second_qualifier_credits_final' => 'SQ final year credits',*/
		'wil_el_credits' => 'WIL EL credits',
		'research_credits' => 'Research credits',
		'minimum_admission_requirements' => 'Minimum admission requirements',
		'minimum_years_full' => 'Minimum duration full',
		'minimum_years_part' => 'Minimum duration part',
		'qualification_purpose' => 'Qualification purpose',
		'exit_level_outcome' => 'Grad Attributes / Exit level outcomes',
		'articulation_progression' => 'Articulation progression',
		'rpl' => 'RPL',
		'international_comparability' => 'International comparability',
		'hemis_lkp_cesm3_code_id' => 'Major field of study',
		'lkp_hemis_heqf_qualification_type_id' => 'HEMIS amended qualification type',
		'hemis_minimum_exp_time' => 'HEMIS minimum experiential time',
		'hemis_total_subsidy_units' => 'Total subsidy units',
		'lkp_hemis_funding_level_id' => 'Funding level',
		'saqa_qualification_id' => 'SAQA qualification ID',
		'qualification_rationale' => 'Qualification rationale',
		'struct_elect' => 'Structured or with electives',
		'int_assess' => 'Integrated Assessment',
		'moderation' => 'Moderation',
		'replace_qual' => 'Replacing which qualifications',
		'motivation_duplicate' => 'Motivation for duplicate',
		'site_1' => 'Site of delivery 1',
		'site_2' => 'Site of delivery 2',
		'site_3' => 'Site of delivery 3',
		'site_4' => 'Site of delivery 4',
		'site_5' => 'Site of delivery 5',
		'site_6' => 'Site of delivery 6',
		'site_7' => 'Site of delivery 7',
		'site_8' => 'Site of delivery 8',
		'site_9' => 'Site of delivery 9',
		'site_10' => 'Site of delivery 10',
		'site_11' => 'Site of delivery 11',
		'site_12' => 'Site of delivery 12',
		'site_13' => 'Site of delivery 13',
		'site_14' => 'Site of delivery 14',
		'site_15' => 'Site of delivery 15',
		'site_16' => 'Site of delivery 16',
		'site_17' => 'Site of delivery 17',
		'site_18' => 'Site of delivery 18',
		'site_19' => 'Site of delivery 19',
		'site_20' => 'Site of delivery 20',
		'site_21' => 'Site of delivery 21',
		'site_22' => 'Site of delivery 22',
		'site_23' => 'Site of delivery 23',
		'site_24' => 'Site of delivery 24',
		'site_25' => 'Site of delivery 25',
		'site_26' => 'Site of delivery 26',
		'site_27' => 'Site of delivery 27',
		'site_28' => 'Site of delivery 28',
		'site_29' => 'Site of delivery 29',
		'site_30' => 'Site of delivery 30'
	);

	public $saqaFields = array(
		'exit_level_outcome' => 'Grad Attributes / Exit level outcomes',
		'int_assess' => 'Integrated Assessment',
		'articulation_progression' => 'Articulation progression',
		'moderation' => 'Moderation',
		'rpl' => 'RPL',
		'international_comparability' => 'International comparability',
		'qualification_purpose' => 'Qualification purpose',
		'qualification_rationale' => 'Qualification rationale'
	);

	public $dhetFields = array(
		'HEMIS qualification type' => array(
			's1_lkp_hemis_qualification_type_id',
			'lkp_hemis_heqf_qualification_type_id'
		),
		'HEMIS minimum experiential time' => array(
			's1_hemis_minimum_exp_time',
			'hemis_minimum_exp_time'
		),
		'Total subsidy units' => array(
			's1_hemis_total_subsidy_units',
			'hemis_total_subsidy_units'
		),
		'Funding level' => array(
			's1_lkp_hemis_funding_level_id',
			'lkp_hemis_funding_level_id'
		),

	);

	public $section3Fields = array(
		's3_curriculum' => 'Describe how the curriculum of this programme has been redesigned so that it aligns with the HEQSF, specifically in relation to the programme title (including the use of designators and / or qualifiers), intended purpose, exit level outcomes and assessment criteria for this programme (Criterion 1 iii, iv, 6 i, 13 i).',
		's3_modules' => 'Complete the table below indicating the specific amendments to the design of the learning programme. Indicate whether a module of the programme has been added, removed, modified or remains unchanged. The amendments indicated should clearly illustrate that the proposed curriculum changes do not differ from the original programme design by more than 50% (Criteria 1 vi, 5 ii).',
		's3_assessment' => 'Discuss the overall assessment strategy and indicate the <abbr data-type="assessment" class="popup">constructive alignment</abbr>  of the programme design, teaching and learning strategy, and assessment procedures to the learning outcomes (Criteria 6 i, 13 i).',
		's3_learning_activities' => 'In the table below, indicate the types of learning activities of the amended programme design, and number of hours a student is expected to devote to each type. (This should refer to the table above relating to Programme details) (Criterion 1 vi)',
		's3_direct_contact_time' => 'Direct contact time (Lectures, face to face, limited interaction or technology-assisted, tutorials, Syndicate groups)',
		's3_wil_time' => '<abbr class="popup" data-type="wil">WIL</abbr> (Practical experiential learning, simulated learning, laboratory work , practicals etc excluding workplace-based learning)',
		's3_workplace_learning_time' => 'WIL (<abbr data-type="workplace" class="popup" >Workplace-based learning only</abbr>) *',
		's3_self_study_time' => 'Independent <abbr data-type="study" class="popup" >self-study</abbr> of standard texts and references and specially prepared materials (study guides, books, journal articles, case studies, multi-media)',
		's3_learning_assessment_time' => 'Assessment',
		's3_learning_other_time' => 'Other (specify)',
		's3_learning_other_text' => 'If you selected "Other" as a type of learning activity please give a detailed explanation below',
		's3_guideline_explained' => 'Explain how the guidelines for the workplace-based learning component of the programme provide clarity on the roles and responsibilities of all involved parties and incorporate ethical and educational considerations. How is the information in the guidelines communicated to students? ',
		's3_placement_explained' => 'Who takes responsibility for placement of students in appropriate work-based learning sites, and how does the responsible person organize the placements? Are the required formal agreements in place? (Provide appropriate detail.)',
		's3_workplace_explained' => 'How is workplace-based learning monitored, supervised and assessed?',
		's3_has_wil' => 'Is <abbr data-type="workplace" class="popup">workplace-based learning</abbr> required as part of the programme design?'
	);

	public $catBEvaluationFields = array(
		's3_curriculum_lkp_outcome_id' => array('heading' => 'A. The design maintains an appropriate balance of theoretical, practical and experiential knowledge and skills. It has sufficient disciplinary content and theoretical depth at the appropriate level, to serve its educational purposes. This design includes aspects of: learning outcomes, assessment criteria, degree of curriculum choice, modes of delivery, and ccompetencies expected of students who successfully complete the programme.', 'commentField' => 's3_curriculum_comment'),
		's3_modules_lkp_outcome_id' => array('heading' => 'A. Modules and/or courses in the programme are coherently planned with regard to content, level, credits, purpose, outcomes, rules of combination, relative weight and delivery.', 'commentField' => 's3_module_comment'),
		's3_assessment_lkp_outcome_id' => array('heading' => 'A. Assessment is an integral part of the teaching and learning process and is systematically and purposefully used to generate data for grading, ranking, selecting and predicting, as well as for providing timely feedback to inform teaching and learning and to improve the curriculum. B. The teaching and learning strategy is appropriate for the institutional type as reflected in its mission (programme types, research: teaching), mode(s) of delivery (contact / distance / e-learning), and its student composition (age, full-time / part-time, advantaged / disadvantaged), etc. ', 'commentField' => 's3_assessment_comment'),
		's3_learning_activities_lkp_outcome_id' => array('heading' => 'A. Modules and/or courses in the programme are coherently planned with regard to content, level, credits, purpose, outcomes, rules of combination, relative weight and delivery. Outsourcing of delivery is not permitted.', 'commentField' => 's3_learning_activities_comment'),
		's3_workplace_explained_lkp_outcome_id' => array('heading' => 'A.	The coordination of workplace-based learning is done effectively in all components of applicable programmes. This includes an adequate infrastructure, effective communication, recording of progress made, monitoring, mentoring and assessment.', 'commentField' => 's3_workplace_comment'),
		'eval_lkp_outcome_id' => array('heading' => 'Recommended Evaluation Outcome:', 'commentField' => 'eval_outcome_comment')

	);

	public $reviewFields = array(
		'review' => array(
			'review_outcome_id' => array('commentField' => 'review_comments'),
			),
		'proceeding' => array(
			'proc_lkp_outcome_id' => array('commentField' => 'proc_comments'),
		)
	);

	public $evaluationLkpFields = array(
		's3_curriculum_lkp_outcome_id',
		's3_modules_lkp_outcome_id',
		's3_assessment_lkp_outcome_id',
		's3_learning_activities_lkp_outcome_id',
		's3_workplace_explained_lkp_outcome_id',
		'eval_lkp_outcome_id'
	);

	public $catBCommentFields = array(
		'Question 1 comment:' => 's3_curriculum_comment',
		'Question 2 comment:' => 's3_module_comment',
		'Question 3 comment:' => 's3_assessment_comment',
		'Question 4 comment:' => 's3_learning_activities_comment',
		'Question 5 comment:' => 's3_workplace_comment',
		'Recommended Evaluation Outcome comment:' => 'eval_outcome_comment',
		'Request Second Evaluation comment' => 'request_second_evaluation_comment'
	);

	/*
			's3_q6' => '6. Indicate the name of the statutory and non-statutory Professional Body that has a role in this programme and indicate whether the amendments to the programme design comply with the requirements of this statutory and non-statutory Professional Body (Criterion 1 viii). ',
			's3_q7' => '7. Provide details of how Recognition of Prior Learning (RPL) will be applied to this programme (Criteria 6 i, 13 v).',
			's3_q8' => '8. *Where a workplace-based learning component is included, provide details as to how students will be placed into WIL programmes, how the WIL programme is appropriately structured, and how the WIL programme will be supervised and assessed. (Criteria 1 ix, 15 i-iv)',
	*/
	public $section3FieldsExceptions = array(
		's3_modules' => 'generateModules',
		's3_assessment' => 'generateAssessment',
		's3_learning_activities' => 'generateTimeGrid',
		's3_direct_contact_time' => 'ignore',
		's3_wil_time' => 'ignore',
		's3_workplace_learning_time' => 'ignore',
		's3_self_study_time' => 'ignore',
		's3_learning_assessment_time' => 'ignore',
		's3_learning_other_time' => 'ignore',
		's3_learning_other_text' => 'ignore',
		's3_has_wil' => 'ignore'
	);

	public $q5Displayed = false;

	public $section1OnlyFields = array(
		's1_lkp_heqf_align_id' => 'Proposed HEQSF Category',
		's1_teachout_date' => 'Teach-out date',
	);

	public $section2OnlyFields = array(
		'lkp_qualification_type_id' => 'Qualification type',
		'lkp_designator_id' => 'Qualification designator',
		'other_designator' => 'Other designator',
		'motivation_other_designator' => 'Motivation for other designator',
		'lkp_cesm1_code_id' => 'CESM',
		'lkp_professional_class_id' => 'Professional class',
		'professional_body' => 'Professional body',
		'wil_el_credits' => 'WIL EL credits',
		'research_credits' => 'Research credits',
		'struct_elect' => 'Structured or with electives',
		'replace_qual' => 'Replacing which qualifications',
	);

	public $publicAB = array(
		'Proposed HEQSF Category' => array(
			'section 1' => 's1_lkp_heqf_align_id',
		),
		'Qualification title' => array(
			'section 1' => 's1_qualification_title',
			'section 2' => 'qualification_title'
		),
		'Qualification title abbreviation' => array(
			'section 1' => 's1_qualification_title_short',
			'section 2' => 'qualification_title_short'
		),
		'Mode of delivery' => array(
			'section 1' => 's1_lkp_delivery_mode_id',
			'section 2' => 'lkp_delivery_mode_id'
		),
		'NQF Exit Level' => array(
			'section 1' => 's1_lkp_nqf_level_id',
			'section 2' => 'lkp_nqf_level_id'
		),
		'Total credits' => array(
			'section 1' => 's1_credits_total',
			'section 2' => 'credits_total'
		),
		'Minimum duration full' => array(
			'section 1' => 's1_minimum_years_full',
			'section 2' => 'minimum_years_full'
		),
		'Minimum duration part' => array(
			'section 1' => 's1_minimum_years_part',
			'section 2' => 'minimum_years_part'
		),
		'Qualification type' => array(
			'section 2' => 'lkp_qualification_type_id',
		),
		'Qualification designator' => array(
			'section 2' => 'lkp_designator_id',
		),
		'Other designator' => array(
			'section 2' => 'other_designator',
		),
		'Motivation for other designator' => array(
			'section 2' => 'motivation_other_designator',
		),
		'CESM' => array(
			'section 2' => 'lkp_cesm1_code_id',
		),
		'Professional class' => array(
			'section 2' => 'lkp_professional_class_id',
		),
		'Professional body' => array(
			'section 2' => 'professional_body',
		),
		'WIL EL credits' => array(
			'section 2' => 'wil_el_credits',
		),
		'Research credits' => array(
			'section 2' => 'research_credits',
		),
		'Structured or with electives' => array(
			'section 2' => 'struct_elect',
		),
		'Major field of study' => array(
			'section 1' => 's1_lkp_hemis_qualifier_id',
			'section 2' => 'hemis_lkp_cesm3_code_id'
		),
		'Minimum admission requirements' => array(
			'section 1' => 's1_minimum_admission_requirements',
			'section 2' => 'minimum_admission_requirements'
		),
		'Qualification reference number' => array(
			'section 1' => 's1_qualification_reference_no',
			'section 2' => 'qualification_reference_no'
		),
		'HEQC reference number' => array(
			'section 1' => 's1_heqc_reference_no',
			'section 2' => 'heqc_reference_no'
		),
		'SAQA qualification ID' => array(
			'section 1' => 's1_saqa_qualification_id',
			'section 2' => 'saqa_qualification_id'
		),
		'Replacing which qualifications' => array(
			'section 2' => 'replace_qual',
		),
	);

	public $publicFields = array(
		's1_lkp_hemis_qualifier_id',
		's1_lkp_hemis_qualification_type_id',
		's1_hemis_minimum_exp_time',
		's1_hemis_total_subsidy_units',
		's1_lkp_hemis_funding_level_id',
		'hemis_lkp_cesm3_code_id',
		'lkp_hemis_heqf_qualification_type_id',
		'hemis_minimum_exp_time',
		'hemis_total_subsidy_units',
		'lkp_hemis_funding_level_id'
	);

	public $privateC = array(
		'Proposed HEQSF Category' => 's1_lkp_heqf_align_id',
		'Teach-out date' => 's1_teachout_date',
		'Qualification title' => 's1_qualification_title',
		'Qualification title abbreviation' => 's1_qualification_title_short',
		'Mode of delivery' => 's1_lkp_delivery_mode_id',
		'NQF Exit Level' => 's1_lkp_nqf_level_id',
		'Total credits' => 's1_credits_total',
		'Minimum duration full' => 's1_minimum_years_full',
		'Minimum duration part' => 's1_minimum_years_part',
		'Minimum admission requirements' => 's1_minimum_admission_requirements',
		'Qualification reference number' => 's1_qualification_reference_no',
		'HEQC reference number' => 's1_heqc_reference_no',
		'SAQA qualification ID' => 's1_saqa_qualification_id'
	);

	public $puplicC = array(
		'Proposed HEQSF Category' => 's1_lkp_heqf_align_id',
		'Teach-out date' => 's1_teachout_date',
		'Qualification title' => 's1_qualification_title',
		'Qualification title abbreviation' => 's1_qualification_title_short',
		'Mode of delivery' => 's1_lkp_delivery_mode_id',
		'NQF Exit Level' => 's1_lkp_nqf_level_id',
		'Total credits' => 's1_credits_total',
		'Minimum duration full' => 's1_minimum_years_full',
		'Minimum duration part' => 's1_minimum_years_part',
		'Minimum admission requirements' => 's1_minimum_admission_requirements',
		'Qualification reference number' => 's1_qualification_reference_no',
		'HEQC reference number' => 's1_heqc_reference_no',
		'Major field of study' => 's1_lkp_hemis_qualifier_id',
		'HEMIS qualification type' => 's1_lkp_hemis_qualification_type_id',
		'HEMIS minimum experiential time' => 's1_hemis_minimum_exp_time',
		'Total subsidy units' => 's1_hemis_total_subsidy_units',
		'Funding level' => 's1_lkp_hemis_funding_level_id',
		'SAQA qualification ID' => 's1_saqa_qualification_id'
	);

	public $privateAB = array(
		'Proposed HEQSF Category' => array(
			'section 1' => 's1_lkp_heqf_align_id',
		),
		'Qualification title' => array(
			'section 1' => 's1_qualification_title',
			'section 2' => 'qualification_title'
		),
		'Qualification title abbreviation' => array(
			'section 1' => 's1_qualification_title_short',
			'section 2' => 'qualification_title_short'
		),
		'Mode of delivery' => array(
			'section 1' => 's1_lkp_delivery_mode_id',
			'section 2' => 'lkp_delivery_mode_id'
		),
		'NQF Exit Level' => array(
			'section 1' => 's1_lkp_nqf_level_id',
			'section 2' => 'lkp_nqf_level_id'
		),
		'Total credits' => array(
			'section 1' => 's1_credits_total',
			'section 2' => 'credits_total'
		),
		'Minimum duration full' => array(
			'section 1' => 's1_minimum_years_full',
			'section 2' => 'minimum_years_full'
		),
		'Minimum duration part' => array(
			'section 1' => 's1_minimum_years_part',
			'section 2' => 'minimum_years_part'
		),
		'Qualification type' => array(
			'section 2' => 'lkp_qualification_type_id',
		),
		'Qualification designator' => array(
			'section 2' => 'lkp_designator_id',
		),
		'Other designator' => array(
			'section 2' => 'other_designator',
		),
		'Motivation for other designator' => array(
			'section 2' => 'motivation_other_designator',
		),
		'CESM' => array(
			'section 2' => 'lkp_cesm1_code_id',
		),
		'Professional class' => array(
			'section 2' => 'lkp_professional_class_id',
		),
		'Professional body' => array(
			'section 2' => 'professional_body',
		),
		'WIL EL credits' => array(
			'section 2' => 'wil_el_credits',
		),
		'Research credits' => array(
			'section 2' => 'research_credits',
		),
		'Structured or with electives' => array(
			'section 2' => 'struct_elect',
		),
		'Minimum admission requirements' => array(
			'section 1' => 's1_minimum_admission_requirements',
			'section 2' => 'minimum_admission_requirements'
		),
		'Qualification reference number' => array(
			'section 1' => 's1_qualification_reference_no',
			'section 2' => 'qualification_reference_no'
		),
		'HEQC reference number' => array(
			'section 1' => 's1_heqc_reference_no',
			'section 2' => 'heqc_reference_no'
		),
		'SAQA qualification ID' => array(
			'section 1' => 's1_saqa_qualification_id',
			'section 2' => 'saqa_qualification_id'
		),
		'Replacing which qualifications' => array(
			'section 2' => 'replace_qual',
		),
	);

	public $sites = array(
		'Site of delivery 1' => array(
			's1_site_1',
			'site_1'
		),
		'Site of delivery 2' => array(
			's1_site_2',
			'site_2'
		),
		'Site of delivery 3' => array(
			's1_site_3',
			'site_3'
		),
		'Site of delivery 4' => array(
			's1_site_4',
			'site_4'
		),
		'Site of delivery 5' => array(
			's1_site_5',
			'site_5'
		),
		'Site of delivery 6' => array(
			's1_site_6',
			'site_6'
		),
		'Site of delivery 7' => array(
			's1_site_7',
			'site_7'
		),
		'Site of delivery 8' => array(
			's1_site_8',
			'site_8'
		),
		'Site of delivery 9' => array(
			's1_site_9',
			'site_9'
		),
		'Site of delivery 10' => array(
			's1_site_10',
			'site_10'
		),
		'Site of delivery 11' => array(
			's1_site_11',
			'site_11'
		),
		'Site of delivery 12' => array(
			's1_site_12',
			'site_12'
		),
		'Site of delivery 13' => array(
			's1_site_13',
			'site_13'
		),
		'Site of delivery 14' => array(
			's1_site_14',
			'site_14'
		),
		'Site of delivery 15' => array(
			's1_site_15',
			'site_15'
		),
		'Site of delivery 16' => array(
			's1_site_16',
			'site_16'
		),
		'Site of delivery 17' => array(
			's1_site_17',
			'site_17'
		),
		'Site of delivery 18' => array(
			's1_site_18',
			'site_18'
		),
		'Site of delivery 19' => array(
			's1_site_19',
			'site_19'
		),
		'Site of delivery 20' => array(
			's1_site_20',
			'site_20'
		),
		'Site of delivery 21' => array(
			's1_site_21',
			'site_21'
		),
		'Site of delivery 22' => array(
			's1_site_22',
			'site_22'
		),
		'Site of delivery 23' => array(
			's1_site_23',
			'site_23'
		),
		'Site of delivery 24' => array(
			's1_site_24',
			'site_24'
		),
		'Site of delivery 25' => array(
			's1_site_25',
			'site_25'
		),
		'Site of delivery 26' => array(
			'.s1_site_26',
			'site_26'
		),
		'Site of delivery 27' => array(
			's1_site_27',
			'site_27'
		),
		'Site of delivery 28' => array(
			's1_site_28',
			'site_28'
		),
		'Site of delivery 29' => array(
			's1_site_29',
			'site_29'
		),
		'Site of delivery 30' => array(
			's1_site_30',
			'site_30'
		)
	);

	public $reminderFields = array(
		'In evaluation' => array(
          'first_reminder' => 'evaluation_reminder1_sent_date',
          'second_reminder' => 'evaluation_reminder2_sent_date',
          'third_reminder' => 'evaluation_reminder3_sent_date',
          'fourth_reminder' => 'evaluation_reminder4_sent_date',
          ),
		'In review' => array(
          'first_reminder' => 'review_reminder1_sent_date',
          'second_reminder' => 'review_reminder2_sent_date',
          'third_reminder' => 'review_reminder3_sent_date',
          'fourth_reminder' => 'review_reminder4_sent_date'
         ),
         'Representation (Reviewer)' => array(
          'first_reminder' => 'proc_reminder1_sent_date',
          'second_reminder' => 'proc_reminder2_sent_date',
          'third_reminder' => 'proc_reminder3_sent_date',
          'fourth_reminder' => 'proc_reminder4_sent_date'
         )         
     );
	public $reminderPeriods = array(
		'evaluation_reminder1_sent_date' => 'evaluation_reminder1_period',
		'evaluation_reminder2_sent_date' => 'evaluation_reminder2_period',
		'evaluation_reminder3_sent_date' => 'evaluation_overdue1_period',
		'evaluation_reminder4_sent_date' => 'evaluation_overdue2_period',
		'review_reminder1_sent_date' => 'review_reminder1_period',
		'review_reminder2_sent_date' => 'review_reminder2_period',
		'review_reminder3_sent_date' => 'review_overdue1_period',
		'review_reminder4_sent_date' => 'review_overdue2_period',
		'proc_reminder1_sent_date' => 'review_reminder1_period',
		'proc_reminder2_sent_date' => 'review_reminder2_period',
		'proc_reminder3_sent_date' => 'review_overdue1_period',
		'proc_reminder4_sent_date' => 'review_overdue2_period'     
     );

	public function getReminders($application, $applicationStatus, $reminderField) {
		switch ($applicationStatus) {
			case 'In evaluation':
				$model = 'Evaluation';
				break;
			case 'Representation (Reviewer)':
				$model = 'ReviewProceeding';
				break;
			default:
				$model = 'Application';
				break;
		}

		$field = $this->reminderFields[$applicationStatus][$reminderField];

		$fieldValue = $application[$model][$field];

		if($fieldValue == '1970-01-01'){
			$reminderPeriod = $this->getReminderPeriod($this->reminderPeriods[$field]);
			$dueDate = $this->getDueDate($application, $applicationStatus);

			if ($dueDate != '1970-01-01') {
				$reminderDue = $this->checkReminderDue($dueDate, $reminderPeriod);
				if ($reminderDue) {
					$fieldValue = '<span style= "color:#ff0000;">Due</span>';
				} else {
					$fieldValue = '-';
				}
			} else {
				$fieldValue = '-';
			}
			
		}
		
		return $fieldValue;
	}

	public function getDaysOutstanding($application, $applicationStatus) {
		$dueDate = $this->getDueDate($application, $applicationStatus);
		$outstanding = "";
		$now = strtotime('now');

		if($dueDate != '1970-01-01') {
			$seconds_diff =  $now - strtotime($dueDate);
			$days_outstanding = $seconds_diff/(60 * 60 * 24);
			$weeks = floor($days_outstanding / 7);
			$days = $days_outstanding % 7;
			
			if ($weeks > 0) {
				$outstanding .= $weeks . " week(s) ";
			}
			if ($days > 0) {
				$outstanding .= $days . " day(s)";
			}			
		}
		
		return $outstanding;
	}

	public function getAssignedDate($application, $applicationStatus) {
		switch ($applicationStatus) {
			case 'In evaluation':
				$model = 'Evaluation';
				$field = 'evaluation_assign_date';
				break;
			case 'Representation (Reviewer)':
				$model = 'ReviewProceeding';
				$field = 'proc_assign_date';
				break;
			default:
				$model = 'Application';
				$field = 'review_assign_date';
				break;
		}
		 
		$assignedDate = $application[$model][$field];
		return $assignedDate;
	}

	public function getDueDate($application, $applicationStatus) {
		switch ($applicationStatus) {
			case 'In evaluation':
				$model = 'Evaluation';
				$field = 'evaluation_due_date';
				break;
			case 'Representation (Reviewer)':
				$model = 'ReviewProceeding';
				$field = 'proc_due_date';
				break;
			default:
				$model = 'Application';
				$field = 'review_due_date';
				break;
		}
		 
		$dueDate = $application[$model][$field];
		return $dueDate;
	}

	public function getReminderPeriod($reminderType) {
          $Setting = ClassRegistry::init('Setting');
          $reminderSetting = $Setting->find('first', array('conditions' => array('id' => $reminderType)));
          $reminderPeriod = $reminderSetting['Setting']['value']; 

          return $reminderPeriod;
     }

	public function checkReminderDue($dueDate, $reminderPeriod) {
          $reminderDue = false;
          $now = strtotime('now');

          $daysToDueDate = round((strtotime($dueDate) - $now) /3600/24);
          if ($daysToDueDate == $reminderPeriod) {
               $reminderDue = true;
          }

          return $reminderDue;
     }

	public function displayField($fieldName, $dataArray, $instType) {
		$lookups = array(
			'lkp_qualification_type_id' => 'QualificationType',
			'lkp_designator_id' => 'Designator',
			'lkp_cesm1_code_id' => 'CesmCode',
			'lkp_delivery_mode_id' => 'DeliveryMode',
			'lkp_professional_class_id' => 'ProfessionalClass',
			'lkp_nqf_level_id' => 'NqfLevel',
			's1_lkp_delivery_mode_id' => 'DeliveryMode',
			's1_lkp_nqf_level_id' => 'NqfLevel',
			's1_lkp_hemis_qualifier_id' => 'HemisQualifier',
			'hemis_lkp_cesm3_code_id' => 'HemisQualifier',
			'lkp_hemis_heqf_qualification_type_id' => 'HemisHeqfQualificationType',
			's1_lkp_hemis_qualification_type_id' => 'S1HemisQualificationType',
			'lkp_hemis_funding_level_id' => 'HemisFundingLevel',
			's1_lkp_hemis_funding_level_id' => 'HemisFundingLevel',
			'replace_qual' => 'InstitutionQualification'
		);

		$commaSeperated = array(
			'hemis_lkp_cesm3_code_id',
			's1_lkp_hemis_qualifier_id',
			'lkp_cesm1_code_id',
			'replace_qual'
		);

		$return = '';

		$viewVars = ClassRegistry::getObject('View')->viewVars;
		$fieldValue = isset($dataArray['HeqfQualification'][$fieldName]) ? $dataArray['HeqfQualification'][$fieldName] : '';

		if ($instType == 1 && in_array($fieldName, $this->publicFields)) {
			$return = 'This field does not apply to private institutions.';
		} else {
			if (array_key_exists($fieldName, $lookups)) {
				$plural = Inflector::underscore(Inflector::pluralize($lookups[$fieldName]));
				$viewVar = ClassRegistry::getObject('View')->getVar($lookups[$fieldName]);

				if (!empty($viewVar) && !is_array($fieldValue)) {
					$return = isset($viewVar[$fieldValue]) ? ($viewVar[$fieldValue]) : $fieldValue;
				}

				$pluralViewVar = ClassRegistry::getObject('View')->getVar($plural);
				if (!empty($pluralViewVar)) {
					$viewVar = $pluralViewVar;
				}
				if (!empty($viewVar)) {
					if (in_array($fieldName, $commaSeperated)) {
						$return = $this->reportMultiple($dataArray['HeqfQualification'][$fieldName], $viewVar);
					} else {
						$return = isset($viewVar[$fieldValue]) ? ($viewVar[$fieldValue]) : $fieldValue;
					}
				}
			} else {
				$return = $fieldValue;
			}
		}
		return nl2br($return);
	}

	public function getSites($fieldName, $dataArray, $instType) {
		$return = '';

		$sectionOneSiteFound = false;
		if (strlen(strstr($fieldName, 's1_site_')) > 0) {
			$sectionOneSiteFound = true;
			$pos = strrpos($fieldName, '_');
			$siteNum = substr($fieldName, $pos + 1, strlen($fieldName) - 1);
			$arrNum = $siteNum - 1;
			$fieldValue = (!empty($dataArray['HeqfQualification']['S1QualificationSite']) && isset($dataArray['HeqfQualification']['S1QualificationSite'][$arrNum]['site_name'])) ? $dataArray['HeqfQualification']['S1QualificationSite'][$arrNum]['site_name'] : '';
		} elseif (strlen(strstr($fieldName, 'site_')) > 0 && !$sectionOneSiteFound) {
			$pos = strrpos($fieldName, '_');
			$siteNum = substr($fieldName, $pos + 1, strlen($fieldName) - 1);
			$arrNum = $siteNum - 1;
			$fieldValue = (!empty($dataArray['HeqfQualification']['HeqfQualificationSite']) && isset($dataArray['HeqfQualification']['HeqfQualificationSite'][$arrNum]['site_name'])) ? $dataArray['HeqfQualification']['HeqfQualificationSite'][$arrNum]['site_name'] : '';
		}

		$return = $fieldValue;

		return nl2br($return);
	}

	public function reportMultiple($fieldValue, $lookup) {
		$output = '';

		if (!empty($fieldValue)) {
			if (!is_array($fieldValue)) {
				$fieldValue = explode(',', $fieldValue);
			}

			foreach ($fieldValue as $value) {
				$output .= (isset($lookup[$value])) ? $lookup[$value] . ',' : $value . ',';
			}
		}

		$output = trim($output, ',');

		return $output;
	}

	public function editSlugSelect($application) {
		$slug = 'application';

		if (!empty($application)) {
			if ($application['Application']['review_error']) {
				$slug = 'application-requirements';
			}
			if ($application['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B') {
				$slug = 'application-cat-b';
			}
		}

		return $slug;
	}

	public function generateModules($value, $fieldName) {
		$generatedValue = '';
		$view = ClassRegistry::getObject('View');
		$moduleActions = $view->getVar('module_actions');
		$nqfLevels = $view->getVar('nqf_levels');
		$deliveryModes = $view->getVar('delivery_modes');
		$decision = $view->getVar('yes_no_decisions');
		$creditsTotal = 0;
		$studyHoursTotal = 0;
		$totalElective = 0;
		$totalCompulsory = 0;

		if (!empty($value['HeqfQualificationModule'])) {
			$generatedValue = $view->element('grids/section_3/modules', array('modules' => $value['HeqfQualificationModule']));
		}

		return $generatedValue;
	}

	public function generateAssessment($value, $fieldName) {
		$generatedValue = '';

		if (!empty($value['ProgrammeAssessmentApproach'])) {
			$generatedValue .= '<table class="offerings question_4">';
			$generatedValue .= '<tr><th colspan="4">Programme assessment approach (e.g. case-based assessment approach)</th></tr>';
			$generatedValue .= '<tr><td colspan="4">' . nl2br(h($value['s3_assessment'])) . '</td></tr>';
			$generatedValue .= '<tr><th colspan="4">Exit level outcomes</th></tr>';
			$generatedValue .= '<tr><th>Year level</th><th>Assessment purpose</th><th>Assessment methods</th></tr>';

			foreach ($value['ProgrammeAssessmentApproach'] as $programme) {
				$generatedValue .= '<tr>';
				$generatedValue .= '<td>' . $programme['year'] . '</td>';
				$generatedValue .= '<td>' . $programme['purpose'] . '</td>';
				$generatedValue .= '<td>' . $programme['methods'] . '</td>';
				$generatedValue .= '</tr>';
			}
			$generatedValue .= '</table>';
		}

		return $generatedValue;
	}

	public function generateTimeGrid($value, $fieldName) {
		$generatedValue = '';

		$totalHours = $value['s3_direct_contact_time'] + $value['s3_wil_time'] + $value['s3_workplace_learning_time'] + $value['s3_self_study_time'] + $value['s3_learning_assessment_time'] + $value['s3_learning_other_time'];

		$percent = array(
			's3_direct_contact_time' => ($totalHours != 0) ? round((($value['s3_direct_contact_time'] / $totalHours) * 100), 2) : 0,
			's3_wil_time' => ($totalHours != 0) ? round((($value['s3_wil_time'] / $totalHours) * 100), 2) : 0,
			's3_workplace_learning_time' => ($totalHours != 0) ? round((($value['s3_workplace_learning_time'] / $totalHours) * 100), 2) : 0,
			's3_self_study_time' => ($totalHours != 0) ? round((($value['s3_self_study_time'] / $totalHours) * 100), 2) : 0,
			's3_learning_assessment_time' => ($totalHours != 0) ? round((($value['s3_learning_assessment_time'] / $totalHours) * 100), 2) : 0,
			's3_learning_other_time' => ($totalHours != 0) ? round((($value['s3_learning_other_time'] / $totalHours) * 100), 2) : 0,
		);

		$generatedValue .= '<table class="offerings">';
		$generatedValue .= '<tr><th>Type of learning activity</th>';
		$generatedValue .= '<th>Hours</th>';
		$generatedValue .= '<th>% of learning time</th></tr>';
		$generatedValue .= '<tr><td> ' . $this->section3Fields['s3_direct_contact_time'] . '</td>';
		$generatedValue .= '<td>' . $value['s3_direct_contact_time'] . '</td>';
		$generatedValue .= '<td>' . $percent['s3_direct_contact_time'] . '</td></tr>';
		$generatedValue .= '<tr><td>' . $this->section3Fields['s3_wil_time'] . '</td>';
		$generatedValue .= '<td>' . $value['s3_wil_time'] . '</td>';
		$generatedValue .= '<td>' . $percent['s3_wil_time'] . '</td></tr>';
		$generatedValue .= '<tr><td>' . $this->section3Fields['s3_workplace_learning_time'] . '</td>';
		$generatedValue .= '<td>' . $value['s3_workplace_learning_time'] . '</td>';
		$generatedValue .= '<td>' . $percent['s3_workplace_learning_time'] . '</td></tr>';
		$generatedValue .= '<tr><td>' . $this->section3Fields['s3_self_study_time'] . '</td>';
		$generatedValue .= '<td>' . $value['s3_self_study_time'] . '</td>';
		$generatedValue .= '<td>' . $percent['s3_self_study_time'] . '</td></tr>';
		$generatedValue .= '<tr><td>' . $this->section3Fields['s3_learning_assessment_time'] . '</td>';
		$generatedValue .= '<td>' . $value['s3_learning_assessment_time'] . '</td>';
		$generatedValue .= '<td>' . $percent['s3_learning_assessment_time'] . '</td></tr>';
		$generatedValue .= '<tr><td>' . $this->section3Fields['s3_learning_other_time'] . '</td>';
		$generatedValue .= '<td>' . $value['s3_learning_other_time'] . '</td>';
		$generatedValue .= '<td>' . $percent['s3_learning_other_time'] . '</td></tr>';
		$generatedValue .= '<tr><td><strong>Total</strong></td>';
		$generatedValue .= '<td>' . $totalHours . '</td>';
		$generatedValue .= '<td>100%</td></tr>';
		if ($value['s3_learning_other_time'] > 0) {
			$generatedValue .= '<tr><td colspan="3"><strong>' . $this->section3Fields['s3_learning_other_text'] . '</strong></td></tr>';
			$generatedValue .= '<tr><td colspan="3">' . $value['s3_learning_other_text'] . '</td></tr>';
		}
		$generatedValue .= '</table>';

		return $generatedValue;
	}

	public function displaySectionThree($fieldName, $information) {
		$display = '<h3 class="questionsHeading">' . $this->section3Fields[$fieldName] . '</h3>';
		$display .= '<div class="questionsAnswer">';

		if (isset($this->section3FieldsExceptions[$fieldName])) {
			if ($this->section3FieldsExceptions[$fieldName] == 'ignore') {
				return '';
			}
			$return = $this->{$this->section3FieldsExceptions[$fieldName]}($information['HeqfQualification'], $fieldName);
			$display .= !empty($return) ? $return : '<em>No information entered</em>';
		} else {
			$display .= !empty($information['HeqfQualification'][$fieldName]) ? $information['HeqfQualification'][$fieldName] : '<em>No information entered</em>';
		}

		$display .= '</div>';

		return $display;
	}

	public function displayCatBEvaluation($fieldName, $information, $question) {
		$display = '<h3 class="questionsHeading">' . $this->catBEvaluationFields[$fieldName]['heading'] . '</h3>';
		$display .= '<div class="questionsAnswer">';
		$question = '<strong>'. $question . ': ' . '</strong>';
			if(in_array($fieldName, $this->evaluationLkpFields)){
				$outcomes = $this->getOutcomes();
				$display .= !empty($information[$fieldName]) ? '<p>' .$question . ' '.  $outcomes[$information[$fieldName]] . '</p>' : '<em>No information entered</em>';
				if(!empty($information[$this->catBEvaluationFields[$fieldName]['commentField']])){
					$display .= '<p class="eval-comment">';
						$display .= '<strong>Comment: </strong>'. $information[$this->catBEvaluationFields[$fieldName]['commentField']];
					$display .= '</p>';
				}

			}
		$display .= '</div>';

		return $display;
	}

	public function getOutcomes(){
		$outcomeModel = ClassRegistry::init('LkpOutcome');
		$outcomes = $outcomeModel->find('list', array(
			'fields' => array('LkpOutcome.id', 'LkpOutcome.outcome_desc')
		));
		return $outcomes;
	}
	
	public function isCatB($app) {
		$return = false;

		if (!empty($app)) {						
			$return = ($app['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B') ? true : false;			
		}

		return $return;
	}

	public function evaluationHistory($applicationIdArr) {
		App::import("Model", "Evaluation");  
		$evaluation = new Evaluation(); 

		$evaluationArr = $evaluation->find("all", array(
			'fields' => array(
				'Evaluation.application_correctly_categorised',
				'Evaluation.qualification_type_aligned',
				'Evaluation.nqf_level_aligned',
				'Evaluation.total_credits_aligned',
				'Evaluation.programme_correctly_titled',
				'Evaluation.application_id',
				'Evaluation.eval_comments',
				'Evaluation.eval_lkp_outcome_id',
				'Evaluation.eval_date',
				'Evaluation.s3_curriculum_comment',
				'Evaluation.s3_module_comment',
				'Evaluation.s3_assessment_comment',
				'Evaluation.s3_learning_activities_comment',
				'Evaluation.s3_workplace_comment',
				'Evaluation.request_second_evaluation_comment',
				'Evaluation.eval_outcome_comment',
				'Evaluation.s3_curriculum_lkp_outcome_id',
				'Evaluation.s3_modules_lkp_outcome_id',
				'Evaluation.s3_assessment_lkp_outcome_id',
				'Evaluation.s3_learning_activities_lkp_outcome_id',
				'Evaluation.s3_workplace_explained_lkp_outcome_id'
				) ,
			'conditions' => array(
				'Evaluation.application_id' => $applicationIdArr,
				'Evaluation.eval_status_id' => array('Complete', 'Request'),
				'Evaluation.eval_date !='=> '1970-01-01'
				),
			'order' => array(
				'FIELD(Evaluation.s3_curriculum_lkp_outcome_id, "ni", "n")',
				'FIELD(Evaluation.s3_modules_lkp_outcome_id, "ni", "n")',
				'FIELD(Evaluation.s3_assessment_lkp_outcome_id, "ni", "n")',
				'FIELD(Evaluation.s3_learning_activities_lkp_outcome_id, "ni", "n")',
				'FIELD(Evaluation.s3_workplace_explained_lkp_outcome_id, "ni", "n")'
			),
			'contain' => array('EvalUser')
			)
		);	
		return 	$evaluationArr;
	}
	// The output will be best if $catBCommentArr is sent in order of the questions asked to the Evaluator
	public function buildCatBHistory($catBCommentArr){
		$catBCommentStr = '';
		$count = count($catBCommentArr) - 1;
		foreach ($catBCommentArr as $key => $catBComment) {
			if(!empty($catBComment)){
				$catBCommentStr .= "Q". ($key+1) . '. ' .$catBComment;
				$catBCommentStr .= ($key < $count && $catBCommentArr[$key+1] > '') ? ' | ' : '';		
			}
		}
		$returnVar = ($catBCommentStr == '') ? " None. " : $catBCommentStr;
		return $returnVar;
	}

/**
 * Function to prevent submission of category B application
 * Read Fromdate and a list of institutions ids from the settings table
 * The $fromdate should have the sql datetime format
 * The $institutionids should be a string separated by a comma with no spaces
 * 
 * @param  array $application Application array
 * 
 * @return bool
 */
	public function preventCatBSubmission($application){
		$return = false;
		$Setting = ClassRegistry::init('Setting');
		$fromDateSetting = $Setting->find('first', array('conditions' => array('id' => 'prevent-catb-submission-from-date')));
		$instSetting = $Setting->find('first', array('conditions' => array('id' => 'prevent-catb-submission-institutions-id')));
		$instIdExceptionArr = explode(",", $instSetting['Setting']['value']);
		$fromDate = $fromDateSetting['Setting']['value'];
		$now = date('Y-m-d H:i:s');
		
		if($now > $fromDate) {
			if (!empty($application) && !in_array($application['Application']['institution_id'], $instIdExceptionArr)  && $application['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B') {
					$return = true;
			}
		}

		if ($application['Application']['returned_from_checklisting'] == '1' && $application['Application']['user_id'] != '' && $application['Application']['submission_date'] == '1970-01-01') {
			$return = false;
		}
		
		return $return;
	}

	public function combineApplicationData($applicationArr) {

		$applicationIdArr = Set::extract('/Application/id', $applicationArr);
		App::import("Model", "Evaluation");  
		$evaluation = new Evaluation(); 

		$proceedingObj = ClassRegistry::init('Proceeding');
		$proceedingArr = $proceedingObj->find('all', array(
			'conditions' => array(
				'Proceeding.application_id' => $applicationIdArr,
				'Proceeding.proc_status_id' => 'ReviewerComplete',
				'Proceeding.proc_user_id !=' => '',
				'Proceeding.proc_lkp_outcome_id !=' => '',
				'Proceeding.proc_inactive' => 1
			),
			'contain' => array(
				'ProcUser',
				'ProcHeqcMeeting'
			)
		));

		$proceedingDocs = $proceedingObj->find('all', array(
			'fields' => array(
				'Proceeding.proc_document',
				'Proceeding.application_id',
				'Proceeding.proceeding_type_id',
				'Proceeding.proc_submission_date'
			),
			'conditions' => array(
				'Proceeding.application_id' => $applicationIdArr,
				'Proceeding.proc_status_id' => array('ReviewerComplete', 'ReviewerNew', 'InstComplete'),
			)
		));

		$evaluationArr = $evaluation->find("all", array(
			'fields' => array(				
				'Evaluation.application_id',
				'Evaluation.eval_comments',
				'Evaluation.eval_outcome_comment',
				'Evaluation.request_second_evaluation_comment',
				'Evaluation.eval_lkp_outcome_id',
				'Evaluation.eval_date',
				'Evaluation.s3_curriculum_comment',
				'Evaluation.s3_module_comment',
				'Evaluation.s3_assessment_comment',
				'Evaluation.s3_learning_activities_comment',
				'Evaluation.s3_workplace_comment'   
				) ,
			'conditions' => array(
				'Evaluation.application_id' => $applicationIdArr,
				'Evaluation.eval_status_id' => array('Complete', 'Request'),
				'Evaluation.eval_date !='=> '1970-01-01'
				),
			'contain' => array('EvalUser')
			)
		);

		
		
		foreach ($applicationArr as $list_key => $application) {
			if(!empty($evaluationArr)){			
				foreach ($evaluationArr  as $eval_key => $evaluationData) {
					if($application['Application']['id'] == $evaluationData['Evaluation']['application_id']){
						$combineData = array_merge($evaluationData['Evaluation'],$evaluationData['EvalUser']);
						$applicationArr[$list_key]['evaluationHistory'][] = $combineData;
					}
				}
			}

			if (!empty($proceedingArr)) {
				foreach ($proceedingArr  as $proc_key => $proceeding) {
					if($application['Application']['id'] == $proceeding['Proceeding']['application_id']){
						$combineProc = array_merge($proceeding['Proceeding'],$proceeding['ProcUser'], $proceeding['ProcHeqcMeeting']);
						$applicationArr[$list_key]['proceedingHistory'][] = $combineProc;
					}
				}
			}
			if (!empty($proceedingDocs)) {
				foreach ($proceedingDocs  as $proceedingDoc) {
					if($application['Application']['id'] == $proceedingDoc['Proceeding']['application_id']){
						$applicationArr[$list_key]['submittedProceedingDocs'][] = $proceedingDoc['Proceeding'];
					}
				}
			}
		}

		return 	$applicationArr;
	}

	public function getProceedingTypeDesc($proceedingTypeId) {
		$proceedingTypeDesc = '';
		if ($proceedingTypeId == 'r') {
			$proceedingTypeDesc = 'Representation';
		} else {
			$proceedingTypeDesc = 'Deferral';
		}

		return $proceedingTypeDesc;
	}

	public function showProceedingFile($proc_document, $linkTitle, $hei_code) {
		$uploadedFile = WWW_ROOT . 'Documents/' . $hei_code . '/Applications/' . $proc_document;

		if($proc_document > '' && is_file($uploadedFile)) {
			echo $this->Html->link($linkTitle, '/Documents/' . $hei_code . '/Applications/' . $proc_document, array('target' => '_blank'));  
		}
	}

	public function getInstitutionCode($institutionId) {
		$hei_code = '';
		$institutionObj = ClassRegistry::init('Institution');
		$institution = $institutionObj->findbyId($institutionId);
		if(isset($institution['Institution']['hei_code'])) {
			$hei_code = $institution['Institution']['hei_code'];
		}
		return $hei_code;
	}

	public function buildReviewHistory($data){
		$reviewArr = array();
		$reviewArr[] = array(
			'type' => 'Review',
			'outcome' => $data['Application'] ['review_outcome_id'],
			'comment' => $data['Application'] ['review_comments']
		);
		if (!empty($data['CompletedReviews'])){
			foreach ($data['CompletedReviews'] as $key => $review) {
				$reviewArr[] = array(
					'type' => $this->getProceedingTypeDesc($review['proceeding_type_id']),
					'outcome' => $review['proc_lkp_outcome_id'],
					'comment' => $review['proc_comments']
				);
			}
		}
		return $reviewArr;
	}

	public function displayReviewHistory($review) {
		$display = '';
		$display .= '<div class="questionsAnswer">';
		$question = '<strong>'. $review['type'] . ' outcome: ' . '</strong>';
			
				$outcomes = $this->getOutcomes();
				$display .= !empty($review['outcome']) ? '<p>'. $question . ' '. $outcomes[$review['outcome']] . '</p>' : '<em>No information entered</em>';
				if(!empty($review['comment'])){
					$display .= '<p class="eval-comment">';
						$display .= '<strong>Comment: </strong>'. $review['comment'];
					$display .= '</p>';
				}

		$display .= '</div>';

		return $display;

	}

	public function getProceedingHistory($applicationId) {
		$proceedingObj = ClassRegistry::init('Proceeding');
		$proceeding = $proceedingObj->find('all', array(
			'conditions' => array(
				'Proceeding.application_id' => $applicationId,
				'Proceeding.proc_status_id' => 'ReviewerComplete',
				'Proceeding.proc_user_id !=' => '',
				'Proceeding.proc_lkp_outcome_id !=' => '',
				'Proceeding.proc_inactive' => 1
			),
			'contain' => array(
				'ProcUser'
			)
		));

		return $proceeding;
	}

	public function getSubmittedProceedingDocs($applicationId) {
		$proceedingObj = ClassRegistry::init('Proceeding');
		$proceedingDocs = $proceedingObj->find('all', array(
			'fields' => array(
				'Proceeding.proc_document',
				'Proceeding.application_id',
				'Proceeding.proceeding_type_id',
				'Proceeding.proc_submission_date'
			),
			'conditions' => array(
				'Proceeding.application_id' => $applicationId,
				'Proceeding.proc_status_id' => array('ReviewerComplete', 'ReviewerNew', 'InstComplete'),
			)
		));

		return $proceedingDocs;
	}

}