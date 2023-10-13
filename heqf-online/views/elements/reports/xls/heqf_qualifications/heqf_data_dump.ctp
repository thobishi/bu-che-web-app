<?php

	$this->PhpExcel->getSheet(0)->setTitle('HEQSF data dump');
	
	$worksheetOne = $this->PhpExcel->getSheet(0);
	
	$title = 'HEQSF data dump  - ' . date('Y-m-d H:i');
	$fileName = 'HEQSF data dump';
	$this->set('title_for_layout', $title);
	$this->set('filename', $fileName);

	/*
		Put the sheet data into one array so as to be able to access it from one location and therefore no need to repeat stuff.
	*/
	
	$lookups = array(
		'institution_id' => 'Institution',
		's1_lkp_hemis_qualification_type_id' => 's1_hemis_qualification_types',
		's1_lkp_delivery_mode_id' => 'delivery_modes',
		's1_lkp_nqf_level_id' => 'nqf_levels',
		//'s1_lkp_hemis_qualifier_id' => 'hemis_qualifiers',
		's1_lkp_hemis_funding_level_id' => 'hemis_funding_levels',
		'lkp_qualification_type_id' => 'qualification_types',
		'lkp_delivery_mode_id' => 'delivery_modes',
		'lkp_professional_class_id' => 'professional_classes',
		'lkp_nqf_level_id' => 'nqf_levels',
		//'hemis_lkp_cesm3_code_id' => 'cesm3_codes',
		'lkp_hemis_heqf_qualification_type_id' => 's1_hemis_qualification_types',
		'lkp_hemis_funding_level_id' => 'hemis_funding_levels',
		'user_id' => 'User',
		'submission_user_id' => 'User',
		'evaluation_user_id' => 'User',
		'checklisting_user_id' => 'User',
		'review_user_id' => 'User',
		'returnedto_user_id' => 'User',
		'lkp_designator_id' => 'designators',
		'lkp_cesm1_code_id' => 'cesm1_codes'
	);
	
	$commaSeperated = array(
		'hemis_lkp_cesm3_code_id' => 'hemis_qualifiers',
		's1_lkp_hemis_qualifier_id' => 'hemis_qualifiers'
	);
	
	$headerArray = array(
		'font' => array(
			'bold' => true
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'E0E0E0'
			)
		)
	);
	
	$headings = array(
		'Institution ID',
		'Institution Name',
		//qual
		'Qualification ID',
		'S1 Qual Ref No',
		'S1 Qual Title Abbr',
		'S1 HEQC Ref',
		'S1 Qual Title',
		'S1 SAQA Qual ID',
		'S1 Mode of Delivery',
		'S1 NQF Exit Level',
		'S1 Min Duration Full',
		'S1 Min Duration Part',
		'S1 Total Credits',
		'S1 Min Admission Req',
		'S1 Proposed HEQSF Catg',
		'S1 Teach-out Date',
		'S1 Major Field Of Study',
		'S1 HEMIS Qual Type',
		'S1 HEMIS Min Exp Time',
		'S1 Total Subsidy Units',
		'S1 Funding Level',
		'S2 Qual Ref No',
		'S2 Qual Title Abbr',
		'S2 HEQC Ref',
		'S2 Qual Title',
		'S2 SAQA Qual ID',
		'S2 Replace Qual',
		'S2 Qual Type',
		'S2 Qual Designator',
		'S2 Motivation Other Designator',
		'S2 CESM',
		'S2 Mode of Delivery',
		'S2 Prof Class',
		'S2 Prof Body',
		'S2 NQF Exit Level',
		'S2 Total Credits',
		'S2 WIL EL Credits',
		'S2 Research Credits',
		'S2 Min Admission Req',
		'S2 Min Duration Full',
		'S2 Min Duration Part',
		'S2 Qual Purpose',
		'S2 Qual Rationale',
		'S2 Struct/ Elect',
		'S2 Grad Attributes',
		'S2 Int Assess',
		'S2 Articulation Progression',
		'S2 Moderation',
		'S2 RPL',
		'S2 International Comparability',
		'S2 Major Field Of Study',
		'S2 HEMIS Amended Qual Type',
		'S2 HEMIS Min Exp Time',
		'S2 Total Subsidy Units',
		'S2 Funding Level',
		//app
		'Application ID',
		'App user ID',
		'App submission date',
		'App submission user ID',
		'App evaluation date',
		'App evaluation user ID',
		'App evaluation status ID',
		'App checklisting date',
		'App checklisting user ID',
		'App checklisting status ID',
		'App checklisting comments',
		'App evaluation question 1',
		'App evaluation question 2',
		'App evaluation question 3',
		'App evaluation question 4',
		'App evaluation question 5',
		'App evaluation comments',
		'App edited evaluation comments',
		'App review date',
		'App review user ID',
		'App review status ID',
		'App HEQC meeting ID',
		'App proposed HEQSF category',
		'App outcome ID',
		'App application status',
		'App archived',
		'App archive date',
		'App returned to user ID',
		'App inactive',
		'App categorisation date',
		'App categorisation user ID',
		'App outcome accepted',
		'App notified',
		'App review error',
		'App resubmission date',
		'App review history',
		'App created',
		'App modified'
	);
	
	$row = 1;
	$column = 0;
	$maxColumn = count($headings) - 1;
	$style = $worksheetOne->getStyle('A1:'.(PHPExcel_Cell::stringFromColumnIndex($maxColumn)).($row))->applyFromArray($headerArray);
	$worksheetOne->freezePane('A2');
	
	foreach($headings as $heading) {
		$worksheetOne->setCellValueByColumnAndRow(($column++),$row, $heading);
	}
	
	$row = 2;
	if(!empty($reportData)){
		foreach($reportData as $qualification){
			if(!empty($qualification['Application'])){
				$column = 0;
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['institution_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['institution_id']}[$qualification['HeqfQualification']['institution_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_qualification_reference_no']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_qualification_title_short']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_heqc_reference_no']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_qualification_title']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_saqa_qualification_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['s1_lkp_delivery_mode_id']}[$qualification['HeqfQualification']['s1_lkp_delivery_mode_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['s1_lkp_nqf_level_id']}[$qualification['HeqfQualification']['s1_lkp_nqf_level_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_minimum_years_full']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_minimum_years_part']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_credits_total']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_minimum_admission_requirements']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_lkp_heqf_align_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_teachout_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_lkp_hemis_qualifier_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['s1_lkp_hemis_qualification_type_id']}[$qualification['HeqfQualification']['s1_lkp_hemis_qualification_type_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_hemis_minimum_exp_time']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_hemis_total_subsidy_units']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['s1_lkp_hemis_funding_level_id']}[$qualification['HeqfQualification']['s1_lkp_hemis_funding_level_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_reference_no']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_title_short']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['heqc_reference_no']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_title']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['saqa_qualification_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['replace_qual']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_qualification_type_id']}[$qualification['HeqfQualification']['lkp_qualification_type_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_designator_id']}[$qualification['HeqfQualification']['lkp_designator_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['motivation_other_designator']);
				
				$cesms = $this->Heqf->reportMultiple($qualification['HeqfQualification'], 'lkp_cesm1_code_id', $Cesm2Code, $Cesm1Code);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cesms);
				
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_delivery_mode_id']}[$qualification['HeqfQualification']['lkp_delivery_mode_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_professional_class_id']}[$qualification['HeqfQualification']['lkp_professional_class_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['professional_body']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_nqf_level_id']}[$qualification['HeqfQualification']['lkp_nqf_level_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['credits_total']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['wil_el_credits']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['research_credits']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['minimum_admission_requirements']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['minimum_years_full']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['minimum_years_part']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_purpose']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_rationale']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['struct_elect']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['exit_level_outcome']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['int_assess']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['articulation_progression']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['moderation']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['rpl']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['international_comparability']);
				
				$majors = (!empty($qualification['HeqfQualification']['hemis_lkp_cesm3_code_id'])) ? $this->Heqf->reportMultiple('; ', ',', $qualification['HeqfQualification'], 'hemis_lkp_cesm3_code_id', $hemis_qualifiers) : '';
				
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $majors);
				
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_hemis_heqf_qualification_type_id']}[$qualification['HeqfQualification']['lkp_hemis_heqf_qualification_type_id']]);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['hemis_minimum_exp_time']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['hemis_total_subsidy_units']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['lkp_hemis_funding_level_id']}[$qualification['HeqfQualification']['lkp_hemis_funding_level_id']]);
				
				foreach($qualification['Application'] as $application){
					$column = 55;
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['id']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['user_id']}[$application['user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['submission_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['submission_user_id']}[$application['submission_user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['evaluation_user_id']}[$application['evaluation_user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_status_id']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['checklisting_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['checklisting_status_id']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['checklisting_user_id']}[$application['checklisting_user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['checklisting_comments']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q1']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q2']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q3']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q4']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q5']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_comments']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['edited_evaluation_comments']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['review_user_id']}[$application['review_user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_status_id']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['heqc_meeting_id']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['lkp_heqf_align_id']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $Outcome[$application['lkp_outcome_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['application_status']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['archived']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['archive_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['returnedto_user_id']}[$application['returnedto_user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['inactive']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['categorisation_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, ${$lookups['categorisation_user_id']}[$application['categorisation_user_id']]);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['outcome_accepted']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['notified']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_error']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['resubmission_date']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_history']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['created']);
					$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['modified']);
				}
				$row++;
			}
		}
	}