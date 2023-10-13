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
	
	$highlightAppendix = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'F0EBFF'
			)
		)
	);
	
	$headings = array(
		'Institution',
		'Qual Ref No',
		'Qual Title Abbr',
		'Qual Title',
		'SAQA Qual ID',
		'Qual Designator',
		'Motivation Other Designator',
		'CESM',
		'Mode of Delivery',
		'Prof Class',
		'NQF Exit Level',
		'Total Credits',
		'WIL EL Credits',
		'Research Credits',
		'Major Field Of Study',
	);
	
	$category_a = array();
	$category_b = array();
	
	//use set::extract with conditions if can
	
	$category_a = Set::extract('/HeqfQualification[apx_A=1]', $reportData);
	$category_b = Set::extract('/HeqfQualification[apx_B=1]', $reportData);
	
	$row = 1;
	$column = 0;
	$maxColumn = count($headings) - 1;
	$style = $worksheetOne->getStyle('A1:'.(PHPExcel_Cell::stringFromColumnIndex($maxColumn)).($row))->applyFromArray($headerArray);
	$worksheetOne->freezePane('A2');
	
	foreach($headings as $heading) {
		$worksheetOne->setCellValueByColumnAndRow(($column++),$row, $heading);
	}
	
	if(!empty($category_a)){
		$row = 2;
		$column = 0;
		$style = $worksheetOne->getStyle('A2:O2')->applyFromArray($highlightAppendix);
		$worksheetOne->setCellValueByColumnAndRow(($column++), $row, 'Appendix A');
		$row++;
		foreach($category_a as $cat_a){
			$column = 0;
			$cesms = $this->Heqf->reportMultiple($cat_a['HeqfQualification']['lkp_cesm1_code_id'], $cesm_codes);
			$majors = $this->Heqf->reportMultiple($cat_a['HeqfQualification']['hemis_lkp_cesm3_code_id'], $hemis_qualifiers);
			// $cesms = $this->Heqf->reportMultiple($application['CESM'], $CesmCode);
			
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['institution_id']}[$cat_a['HeqfQualification']['institution_id']]) ? ${$lookups['institution_id']}[$cat_a['HeqfQualification']['institution_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['qualification_reference_no']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['qualification_title_short']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['saqa_qualification_id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_designator_id']}[$cat_a['HeqfQualification']['lkp_designator_id']]) ? ${$lookups['lkp_designator_id']}[$cat_a['HeqfQualification']['lkp_designator_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['other_designator']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['motivation_other_designator']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cesms);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_delivery_mode_id']}[$cat_a['HeqfQualification']['lkp_delivery_mode_id']]) ? ${$lookups['lkp_delivery_mode_id']}[$cat_a['HeqfQualification']['lkp_delivery_mode_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_professional_class_id']}[$cat_a['HeqfQualification']['lkp_professional_class_id']]) ? ${$lookups['lkp_professional_class_id']}[$cat_a['HeqfQualification']['lkp_professional_class_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_nqf_level_id']}[$cat_a['HeqfQualification']['lkp_nqf_level_id']]) ? ${$lookups['lkp_nqf_level_id']}[$cat_a['HeqfQualification']['lkp_nqf_level_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['credits_total']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['wil_el_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_a['HeqfQualification']['research_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $majors);
			$row++;
		}
	}
	
	
	if(!empty($category_b)){
		$column = 0;
		$style = $worksheetOne->getStyle('A' . $row . ':O' . $row)->applyFromArray($highlightAppendix);
		$worksheetOne->setCellValueByColumnAndRow(($column++),$row, 'Appendix B');
		$row++;
		foreach($category_b as $cat_b){
			$column = 0;
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['institution_id']}[$cat_b['HeqfQualification']['institution_id']]) ? ${$lookups['institution_id']}[$cat_b['HeqfQualification']['institution_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['qualification_reference_no']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['qualification_title_short']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['saqa_qualification_id']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_designator_id']}[$cat_b['HeqfQualification']['lkp_designator_id']]) ? ${$lookups['lkp_designator_id']}[$cat_b['HeqfQualification']['lkp_designator_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['other_designator']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['motivation_other_designator']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $this->Heqf->reportMultiple($cat_b['HeqfQualification']['lkp_cesm1_code_id'], $cesm1_codes));
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_delivery_mode_id']}[$cat_b['HeqfQualification']['lkp_delivery_mode_id']]) ? ${$lookups['lkp_delivery_mode_id']}[$cat_b['HeqfQualification']['lkp_delivery_mode_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_professional_class_id']}[$cat_b['HeqfQualification']['lkp_professional_class_id']]) ? ${$lookups['lkp_professional_class_id']}[$cat_b['HeqfQualification']['lkp_professional_class_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, isset(${$lookups['lkp_nqf_level_id']}[$cat_b['HeqfQualification']['lkp_nqf_level_id']]) ? ${$lookups['lkp_nqf_level_id']}[$cat_b['HeqfQualification']['lkp_nqf_level_id']] : '');
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['credits_total']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['wil_el_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $cat_b['HeqfQualification']['research_credits']);
			$worksheetOne->setCellValueByColumnAndRow($column++, $row, $this->Heqf->reportMultiple($cat_b['HeqfQualification']['hemis_lkp_cesm3_code_id'], $hemis_qualifiers));
			$row++;
		}
	}