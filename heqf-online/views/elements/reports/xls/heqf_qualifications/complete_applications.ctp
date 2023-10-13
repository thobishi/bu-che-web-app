<?php

	$this->PhpExcel->getSheet(0)->setTitle('S1 Existing qualification info');
	
	$this->PhpExcel->createSheet();
	$this->PhpExcel->getSheet(1)->setTitle('S2 Amended qualification info');
	
	$worksheetOne = $this->PhpExcel->getSheet(0);
	$worksheetTwo = $this->PhpExcel->getSheet(1);
	
	$title = 'Complete programme list  - ' . date('Y-m-d H:i');
	$fileName = 'Complete programme list';
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);

	/*
		Put the sheet data into one array so as to be able to access it from one location and therefore no need to repeat stuff.
	*/
	$sheetData = array(
		'worksheetOne' => array(
			'headings' => array(
				'Qual Ref No',
				'Qual Title Abbr',
				'HEQC Ref',
				'Qual Title',
				'SAQA Qual ID',
				'Mode of Delivery',
				'NQF Exit Level',
				'Min Duration Full',
				'Min Duration Part',
				'Total Credits',
				'Min Admission Req',
				'Proposed HEQSF Catg',
				'Teach-out Date',
				'Major Field Of Study',
				'HEMIS Qual Type',
				'HEMIS Min Exp Time',
				'Total Subsidy Units',
				'Funding Level'
			),
			'fields' => array(
				's1_qualification_reference_no',
				's1_qualification_title_short',
				's1_heqc_reference_no',
				's1_qualification_title',
				's1_saqa_qualification_id',
				's1_lkp_delivery_mode_id',
				's1_lkp_nqf_level_id',
				's1_minimum_years_full',
				's1_minimum_years_part',
				's1_credits_total',
				's1_minimum_admission_requirements',
				's1_lkp_heqf_align_id',
				's1_teachout_date',
				's1_lkp_hemis_qualifier_id',
				's1_lkp_hemis_qualification_type_id',
				's1_hemis_minimum_exp_time',
				's1_hemis_total_subsidy_units',
				's1_lkp_hemis_funding_level_id'
			)
		),
		'worksheetTwo' => array(
			'headings' => array(
				'Qual Ref No',
				'Qual Title Abbr',
				'HEQC Ref',
				'Qual Title',
				'SAQA Qual ID',
				'Replace Qual',
				'Qual Type',
				'Qual Designator',
				'Motivation Other Designator',
				'CESM',
				'Mode of Delivery',
				'Prof Class',
				'Prof Body',
				'NQF Exit Level',
				'Total Credits',
				'WIL EL Credits',
				'Research Credits',
				'Min Admission Req',
				'Min Duration Full',
				'Min Duration Part',
				'Qual Purpose',
				'Qual Rationale',
				'Struct/ Elect',
				'Grad Attributes',
				'Int Assess',
				'Articulation Progression',
				'Moderation',
				'RPL',
				'International Comparability',
				'Major Field Of Study',
				'HEMIS Amended Qual Type',
				'HEMIS Min Exp Time',
				'Total Subsidy Units',
				'Funding Level'
			),
			'fields' => array(
				'qualification_reference_no',
				'qualification_title_short',
				'heqc_reference_no',
				'qualification_title',
				'saqa_qualification_id',
				'replace_qual',
				'lkp_qualification_type_id',
				'lkp_designator_id',
				'motivation_other_designator',
				'lkp_cesm1_code_id',
				'lkp_delivery_mode_id',
				'lkp_professional_class_id',
				'professional_body',
				'lkp_nqf_level_id',
				'credits_total',
				'wil_el_credits',
				'research_credits',
				'minimum_admission_requirements',
				'minimum_years_full',
				'minimum_years_part',
				'qualification_purpose',
				'qualification_rationale',
				'struct_elect',
				'exit_level_outcome',
				'int_assess',
				'articulation_progression',
				'moderation',
				'rpl',
				'international_comparability',
				'hemis_lkp_cesm3_code_id',
				'lkp_hemis_heqf_qualification_type_id',
				'hemis_minimum_exp_time',
				'hemis_total_subsidy_units',
				'lkp_hemis_funding_level_id'
			)
		),
	);
	
	$lookups = array(
		's1_lkp_delivery_mode_id' => 'delivery_modes',
		's1_lkp_nqf_level_id' => 'nqf_levels',
		's1_lkp_hemis_qualifier_id' => 'hemis_qualifiers',
		's1_lkp_hemis_funding_level_id' => 'hemis_funding_levels',
		'lkp_qualification_type_id' => 'qualification_types',
		'lkp_delivery_mode_id' => 'delivery_modes',
		'lkp_professional_class_id' => 'professional_classes',
		'lkp_nqf_level_id' => 'nqf_levels',
		'hemis_lkp_cesm3_code_id' => 'cesm3_codes',
		'lkp_hemis_heqf_qualification_type_id' => 's1_hemis_qualification_types',
		'lkp_hemis_funding_level_id' => 'hemis_funding_levels'
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
	
	foreach($sheetData as $worksheet => $data){
		$maxColumn = count($data['headings']) - 1;
		
		$column = 0;
		$row = 1;
		$style = ${$worksheet}->getStyle('A1:'.(PHPExcel_Cell::stringFromColumnIndex($maxColumn)).($row))->applyFromArray($headerArray);
		${$worksheet}->freezePane('A2');
		
		foreach($data['headings'] as $heading) {
			${$worksheet}->setCellValueByColumnAndRow(($column++),$row, $heading);
		}
		
		$row = 2;
		
		if(!empty($reportData)){
			foreach($reportData as $qualification){
				if(!empty($data['fields'])){
					$column = 0;
					foreach($data['fields'] as $field){
						$value = (isset($lookups[$field]) && !empty($qualification['HeqfQualification'][$field])) ? ${$lookups[$field]}[$qualification['HeqfQualification'][$field]] : $qualification['HeqfQualification'][$field];
						${$worksheet}->setCellValueByColumnAndRow($column++, $row, $value);
					}
				}
				$row++;
			}
		}
		${$worksheet}->getHeaderFooter()->setOddHeader('&C&H' . $title);
		${$worksheet}->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');
	}