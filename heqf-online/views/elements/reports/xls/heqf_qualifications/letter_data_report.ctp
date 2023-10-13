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
		'categorisation_user_id' => 'User',
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
	
	$highlight_outcome = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'FFE8E8'
			)
		)
	);
	
	$highlight_type = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'E3D8B3'
			)
		)
	);
	
	$headings = array(
		'Institution',
		//qual
		'S1 Qual Ref No',
		'S2 Qual Ref No',
		'S2 Qual Title Abbr',
		'S1 Qual Title',
		'S2 Qual Title',
		'S2 SAQA Qual ID',
		'S2 Qual Type',
		'S2 CESM',
		'S2 Major Field Of Study',
		'S2 Mode of delivery',
		//app
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
		'App modified',
		'Application ID',
		'Qualification ID',
		'Inst ID',
		'Institution alignment category',
		'App proposed HEQSF category',
		'App outcome ID',
		'AppxA',
		'AppxB',
		'let_hei_id',
		'let_hei_code',
		'let_hei_name',
		'let_qual_ref_no',
		'let_qual_title_abbr',
		'let_qual_title',
		'let_dupl_ind',
		'let_saqa_qual_id',
		'let_qual_designator',
		'let_motivation_other_designator',
		'let_cesm',
		'let_cesm_ind',
		'let_mode_of_delivery',
		'let_prof_class',
		'let_nqf_exit_level',
		'let_total_credits',
		'let_wil_el_credits',
		'let_research_credits',
		'let_rc_ind',
		'let_major_field_of_study',
		'let_mfos_ind'
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
			$column = 0;
			$category = '';
			$outcomeText = '';
			$outcomeLkp = '';
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['institution_id']}[$qualification['HeqfQualification']['institution_id']]) ? ${$lookups['institution_id']}[$qualification['HeqfQualification']['institution_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_qualification_reference_no']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_reference_no']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_title_short']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_qualification_title']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['qualification_title']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['saqa_qualification_id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_qualification_type_id']}[$qualification['HeqfQualification']['lkp_qualification_type_id']]) ? ${$lookups['lkp_qualification_type_id']}[$qualification['HeqfQualification']['lkp_qualification_type_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $this->Heqf->reportMultiple(';', ';', $qualification['HeqfQualification'], 'lkp_cesm1_code_id', $cesm1_codes));
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $this->Heqf->reportMultiple(';', ',', $qualification['HeqfQualification'], 'hemis_lkp_cesm3_code_id', $hemis_qualifiers));

			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_delivery_mode_id']}[$qualification['HeqfQualification']['lkp_delivery_mode_id']]) ? ${$lookups['lkp_delivery_mode_id']}[$qualification['HeqfQualification']['lkp_delivery_mode_id']] : '');

			foreach($qualification['Application'] as $application){
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['user_id']}[$application['user_id']]) ? ${$lookups['user_id']}[$application['user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['submission_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['submission_user_id']}[$application['submission_user_id']]) ? ${$lookups['submission_user_id']}[$application['submission_user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['evaluation_user_id']}[$application['evaluation_user_id']]) ? ${$lookups['evaluation_user_id']}[$application['evaluation_user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_status_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['checklisting_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['checklisting_status_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['checklisting_user_id']}[$application['checklisting_user_id']]) ? ${$lookups['checklisting_user_id']}[$application['checklisting_user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['checklisting_comments']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q1']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q2']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q3']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q4']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_q5']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['evaluation_comments']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['edited_evaluation_comments']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['review_user_id']}[$application['review_user_id']]) ? ${$lookups['review_user_id']}[$application['review_user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_status_id']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['heqc_meeting_id']);
				$category = $application['lkp_heqf_align_id'];
				$outcomeText = isset($Outcome[$application['lkp_outcome_id']]) ? $Outcome[$application['lkp_outcome_id']] : '';
				$outcomeLkp = $application['lkp_outcome_id'];
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['application_status']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['archived']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['archive_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['returnedto_user_id']}[$application['returnedto_user_id']]) ? ${$lookups['returnedto_user_id']}[$application['returnedto_user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['inactive']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['categorisation_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['categorisation_user_id']}[$application['categorisation_user_id']]) ? ${$lookups['categorisation_user_id']}[$application['categorisation_user_id']] : '');
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['outcome_accepted']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['notified']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_error']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['resubmission_date']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['review_history']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['created']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['modified']);
				$worksheetOne->setCellValueByColumnAndRow($column++, $row, $application['id']);
			}
			
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['institution_id']);
			
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['s1_lkp_heqf_align_id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $category);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $outcomeText);
			
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['apx_A']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['apx_B']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_hei_id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_hei_code']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_hei_name']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_qual_ref_no']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_qual_title_abbr']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_qual_title']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_dupl_ind']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_saqa_qual_id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_qual_designator']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_motivation_other_designator']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_cesm']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_cesm_ind']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_mode_of_delivery']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_prof_class']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_nqf_exit_level']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_total_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_wil_el_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_research_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_rc_ind']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_major_field_of_study']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $qualification['HeqfQualification']['let_mfos_ind']);
			
			
			if(in_array($qualification['HeqfQualification']['lkp_qualification_type_id'], array('3', '4', '12'))){
				$worksheetOne->getStyle('A' . $row . ':BV' . $row)->applyFromArray($highlight_type);
			}
			
			if($outcomeLkp != 'a'){
				$worksheetOne->getStyle('A' . $row . ':BV' . $row)->applyFromArray($highlight_outcome);
			}
			
			$row++;
		}
	
	
	
	/*
		if(isset($commaSeperated[$field])){
			$stringFind = ($field == 'lkp_cesm1_code_id') ? ';' : ',';
			if(strlen(strstr($displayValue, $stringFind)) > 0){
				$fieldArray = explode($stringFind, $displayValue);
				$fieldLookupsArray = array();
				if(!empty($fieldArray)){
					foreach($fieldArray as $displayOption){
						$displayOption = trim($displayOption);
						if(isset(${$commaSeperated[$field]}[$displayOption])){
							array_push($fieldLookupsArray, ${$commaSeperated[$field]}[$displayOption]);
						}
						else{
							array_push($fieldLookupsArray, $displayOption);
						}
					}
					if(!empty($fieldLookupsArray)){
						$displayOption = implode('; ', $fieldLookupsArray);
						$displayValue = $displayOption;
					}
				}
			}
			else{
				$displayValue = (isset(${$commaSeperated[$field]}[$displayValue])) ? ${$commaSeperated[$field]}[$displayValue] : $displayValue;
			}
		}
		*/
	}