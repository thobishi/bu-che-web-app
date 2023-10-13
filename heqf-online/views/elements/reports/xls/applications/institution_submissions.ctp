<?php
	$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	$title = 'Report - Submissions per institution : ' . $Institution[$this->params['named']['institution_id']] . "\n" . date('Y-m-d H:i');
	$fileName = 'Report - Submissions per institution_' . $Institution[$this->params['named']['institution_id']];
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);
	$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.id')  : '';
	
	$row = 1;
	
	$headings = array(
		'Institution Category' => array(),
		'Qualification reference number' => array(),
		'Original Qualification Name' => array(),
		'Authorised Qualification Name' => array(),
		'HEQSF reference number' => array(),
		'Abbreviation' => array(),
		'HEQSF Qual Type' => array(),
		'Designator' => array(),
		'Major Fields of Study' => array(
			'Description & CESM Code'
		),
		'SAQA qualification ID' => array(),
		'NQF Level' => array(),
		'NQF Credits' => array(
			'Total',
			'WIL/EL',
			'Research'
		),
		'Total Subsidy Units' => array(
			'Total'
		),
		'Funding Level' => array(),
		'Mode of Delivery (Contact/Distance)' => array(),
		'Outcome approval date' => array(),
		'Teachout date' => array()
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
	
	$subHeaderArray = array(
		'font' => array(
			'bold' => true,
			'color' => array('argb' => 'FFFFFF'),
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'BDBAA8'
			)
		)
	);
	
	$tableData = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('argb' => '000000'),
			)
		)
	);
	
	if(!empty($reportData)){
		$column = 0;
		$worksheet->setCellValueByColumnAndRow($column, $row++, 'INSTITUTION NAME: ' . (isset($this->params['named']['institution_id']) ? $Institution[$this->params['named']['institution_id']] : $Institution[$institution]));
		$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
		$worksheet->setCellValueByColumnAndRow($column, $row++, 'Date: ' . date('d F Y', time()));
		$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
		foreach($headings as $heading => $data){
			if(!empty($data)){
				$worksheet->mergeCells(chr(65 + $column) . $row . ':' . chr(65 + $column  + count($data) - 1) . $row);
				$worksheet->setCellValueByColumnAndRow(($column++), $row, $heading);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$column--;
				foreach($data as $subHeading){
					$worksheet->setCellValueByColumnAndRow(($column++), ($row + 1), $subHeading);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				}
			}
			else{
				$worksheet->mergeCells(chr(65 + $column) . $row . ':' . chr(65 + $column) . ($row + 1));
				$worksheet->setCellValueByColumnAndRow(($column++), $row, $heading);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			}
		}
		$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $column - 1) . ($row + 1))->applyFromArray($headerArray);
		$row = 5;
		$endColumn = $column - 1;
		foreach($reportData as $qualType => $applications){
			$column = 0;
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column, $row, $QualificationType[$qualType]);
			$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $endColumn) . ($row))->applyFromArray($subHeaderArray);
			$row++;
			foreach($applications as $application){
				$column = 0;
				
				$majors = $this->Heqf->reportMultiple($application['hemis_lkp_cesm3_code_id'], $HemisQualifier);
				$designatorValue = (isset($Designator[$application['lkp_designator_id']]) && $application['lkp_designator_id'] != 'Oth') ? $Designator[$application['lkp_designator_id']] : (
									 	(isset($Designator[$application['lkp_designator_id']]) && $application['lkp_designator_id'] == 'Oth') ? ($application['other_designator'] > ''  ? $Designator[$application['lkp_designator_id']] . ': ' . $application['other_designator'] : $Designator[$application['lkp_designator_id']]) : $application['lkp_designator_id']);

				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['s1_lkp_heqf_align_id']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['qualification_reference_no']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['s1_qualification_title']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['qualification_title']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['heqf_reference_no']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['qualification_title_short']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $QualificationType[$qualType]);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $designatorValue);
				/*
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['lkp_cesm2_code_id']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['first_qualifier']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['lkp_cesm3_code_id']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['second_qualifier']);
				*/
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $majors);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['saqa_qualification_id']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['lkp_nqf_level_id']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['credits_total']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['wil_el_credits']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['research_credits']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['hemis_total_subsidy_units']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, isset($HemisFundingLevel[$application['lkp_hemis_funding_level_id']]) ? $HemisFundingLevel[$application['lkp_hemis_funding_level_id']] : $application['lkp_hemis_funding_level_id']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $DeliveryMode[$application['lkp_delivery_mode_id']]);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['outcome_approval_date'] > '1970-01-01' ? date('d F Y', strtotime($application['outcome_approval_date'])) : '');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['s1_teachout_date'] > '1970-01-01' ? date('d F Y', strtotime($application['s1_teachout_date'])) : '');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);				
				$row++;
			}
		}
	}
	
	$worksheet->getHeaderFooter()->setOddHeader('&C&H' . $title);
	$worksheet->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');