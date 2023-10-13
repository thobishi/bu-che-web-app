<?php
	$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	$title = 'Report of HEQSF alignment applications - ' . date('Y-m-d H:i');
	$fileName = 'Report of HEQSF alignment applications';
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);

	$headings = array(
		'Institution',
		'Status',
		'User assigned to',
		'Qualification reference number',
		'HEQSF reference number',
		'Qualification title (Section 1)',
		'Qualification title (Section 2)',
		'Qualification title (Section 2 original)',
		'Qualification title abbreviation (Section 1)',
		'Qualification title abbreviation (Section 2)',
		'CESM',
		'NQF',
		'Total credits',
		'Qualification type',
		'HEQSF alignment Category',
		'Institution alignment Category',
		'Designator',
		'Mode of delivery',
		'Professional Classification',
		'Submission date',
		'Checklister name',
		'Checklisting date',
		'Evaluator name',
		'Evaluation date',
		'Evaluation comments',
		'Edited evaluation comments',
		'Reviewer name',
		'Review date',
		'Review history',
		'Outcome',
		'HEQC Meeting',
		'Application ID',
		'Outcome approval date',
		'Outcome accepted',
		'Institution notified',
		'Archive date',
		'Archived by',
		'Categoy A to B',
		'Categoy B to C',
		'Categoy A to C'		
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

	$evaluationHeadings = array(
		'Evaluator',
		'Recommended Evaluation Outcome',
		'Evaluation Date',
		'Evaluation Comments'
	);

	$reviewHeadings = array(
		'Reviewer',
		'Review Outcome',
		'Review Date',
		'Review Comments'
	);

	$reviewProceedingHeadings = array(
		'Reviewer(Proceeding)',
		'Proceeding Type',
		'Review Outcome',
		'Review Date',
		'HEQC meeting date',
		'Review Comments'
	);
	
	$evalStyleArray = array(
		'font' => array(
			'bold' => true
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'C1E1F7'
			)
		)
	);

	$ReviewStyleArray = array(
		'font' => array(
			'bold' => true
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'F7BCBC'
			)
		)
	);

	$reviewProcStyleArray = array(
		'font' => array(
			'bold' => true
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'ED0C28'
			)
		)		
	);

	$maxColumn = count($headings) - 1;
	$maxEvalColumn = count($headings) - 1;
	
	$column = 0;
	$row = 1;
	
	$style = $worksheet->getStyle('A1:'.(PHPExcel_Cell::stringFromColumnIndex($maxColumn)).($row))->applyFromArray($headerArray);
	$worksheet->freezePane('A2');
	
	foreach($headings as $heading) {
		$worksheet->setCellValueByColumnAndRow(($column++),$row, $heading);
	}
	
	$row = 2;
	if(!empty($reportData)){
		$reportData = $this->Heqf->combineApplicationData($reportData);
		foreach($reportData as $key => $application){
			$column = 0;
			$cesms = $this->Heqf->reportMultiple($application['HeqfQualification']['lkp_cesm1_code_id'], $CesmCode);

			if(isset($application['evaluationHistory'])){
				$evaluationRowCount = count($application['evaluationHistory']) + 1;

				if(isset($application['ReviewUser'])){
					$evaluationRowCount = $evaluationRowCount + 2;
				}

				if(isset($application['proceedingHistory']) && !empty($application['proceedingHistory'])){
					$evaluationRowCount = $evaluationRowCount + 2;
				}
				$worksheet->mergeCells("A".($row).":A".($row + $evaluationRowCount));
				$worksheet->getStyle("A".($row).":A".($row + $evaluationRowCount))->getAlignment()
    			->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			}

			
			
			$displayName = $application['User']['first_name'] . ' ' . $application['User']['last_name'];
			$displayEmail = (!empty($application['User']['email_address'])) ? '('.$application['User']['email_address'].')' : '';
			$display = $displayName . ' ' . $displayEmail;
			if($displayName == ' ' && empty($displayEmail)){
				$display = ' ';					
			}

			$applicationStatus = $this->Status->getStatus($application['Application']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Institution']['hei_name'] . ' (' 
			.$application['Institution']['hei_code']. ')');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $applicationStatus);

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $display);

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row,  $application['HeqfQualification']['s1_qualification_reference_no']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['heqf_reference_no']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['s1_qualification_title']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['qualification_title']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['qualification_title_orig']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['s1_qualification_title_short']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['qualification_title_short']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $cesms);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($NqfLevel[$application['HeqfQualification']['lkp_nqf_level_id']])) ? $NqfLevel[$application['HeqfQualification']['lkp_nqf_level_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HeqfQualification']['credits_total']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']])) ? $QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($AppHeqfAlign[$application['Application']['lkp_heqf_align_id']])) ? $AppHeqfAlign[$application['Application']['lkp_heqf_align_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($AppHeqfAlign[$application['HeqfQualification']['s1_lkp_heqf_align_id']])) ? $AppHeqfAlign[$application['HeqfQualification']['s1_lkp_heqf_align_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($Designator[$application['HeqfQualification']['lkp_designator_id']])) ? $Designator[$application['HeqfQualification']['lkp_designator_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($DeliveryMode[$application['HeqfQualification']['lkp_delivery_mode_id']])) ? $DeliveryMode[$application['HeqfQualification']['lkp_delivery_mode_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($ProfessionalClass[$application['HeqfQualification']['lkp_professional_class_id']])) ? $ProfessionalClass[$application['HeqfQualification']['lkp_professional_class_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['submission_date'] != '1970-01-01') ? $application['Application']['submission_date'] : 'Not submitted');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (!empty($application['ChecklistUser']['id'])) ? $application['ChecklistUser']['first_name'] . ' ' . $application['ChecklistUser']['last_name'] : 'No checklister assigned');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['checklisting_date'] != '1970-01-01') ? $application['Application']['checklisting_date'] : 'Not checklisted');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (!empty($application['EvalUser']['id'])) ? $application['EvalUser']['first_name'] . ' ' . $application['EvalUser']['last_name'] : 'No evaluator assigned');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['evaluation_date'] != '1970-01-01') ? $application['Application']['evaluation_date'] : 'Not evaluated');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getAlignment()->setWrapText(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (!empty($application['Application']['evaluation_comments'])) ? $application['Application']['evaluation_comments'] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getAlignment()->setWrapText(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (!empty($application['Application']['edited_evaluation_comments'])) ? $application['Application']['edited_evaluation_comments'] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (!empty($application['ReviewUser']['id'])) ? $application['ReviewUser']['first_name'] . ' ' . $application['ReviewUser']['last_name'] : 'No reviewer assigned');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['review_date'] != '1970-01-01') ? $application['Application']['review_date'] : 'Not reviewed');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($column) . $row)->getAlignment()->setWrapText(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, str_replace(' _|_ ', "\r\n", $application['Application']['review_history']));
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, (isset($AllOutcome[$application['Application']['lkp_outcome_id']])) ? $AllOutcome[$application['Application']['lkp_outcome_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($HeqcMeeting[$application['Application']['heqc_meeting_id']]) ? $HeqcMeeting[$application['Application']['heqc_meeting_id']] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Application']['id']);
			
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['outcome_approval_date'] != '1970-01-01') ? $application['Application']['outcome_approval_date'] : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['outcome_accepted'] == '1') ? 'Accepted' : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['Application']['notified'] == '1') ? 'Notified' : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Application']['archive_date']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Application']['archived_by']);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['HeqfQualification']['catg_A_to_B_ind'] != 0) ? 'Yes' : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['HeqfQualification']['catg_B_to_C_ind'] != 0) ? 'Yes' : '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, ($application['HeqfQualification']['catg_A_to_C_ind'] != 0) ? 'Yes' : '');				
			$row++;
			if(isset($application['evaluationHistory'])){
				$column = 1;
				foreach($evaluationHeadings as $evaluationHeading) {
					$worksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($column).($row))->applyFromArray($evalStyleArray);					
					$worksheet->setCellValueByColumnAndRow(($column++),$row, $evaluationHeading);
					
				}
				$column = 1;
				$row++;	
				foreach ($application['evaluationHistory'] as $evaluation) {
					$evaluation_outcome = isset($AllOutcome[$evaluation['eval_lkp_outcome_id']]) ? $AllOutcome[$evaluation['eval_lkp_outcome_id']] : '';
					$evaluationCommentsCatA = !empty($evaluation['eval_comments']) ? $evaluation['eval_comments'] : 'None';						
					$evaluationCommentsCatB = (!empty($evaluation['eval_outcome_comment']) || !empty($evaluation['request_second_evaluation_comment'])) ? $evaluation['eval_outcome_comment'] . ' ' . $evaluation['request_second_evaluation_comment'] : 'None';
					if($this->Heqf->isCatB($application) && empty($evaluation['eval_comments'])){
						$comments = $evaluationCommentsCatB;
					}else{
						$comments = $evaluationCommentsCatA;
					}
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $evaluation['first_name'] . ' ' . $evaluation['last_name']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row,  $evaluation_outcome);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $evaluation['eval_date']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $comments);
					$column = 1;
					$row++;
				}				
			}

			if(!empty($application['ReviewUser']) && $application['Application']['review_status_id'] == 'Reviewed'){
				$column = 1;
				foreach($reviewHeadings as $reviewHeading) {
					$worksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($column).($row))->applyFromArray($ReviewStyleArray);					
					$worksheet->setCellValueByColumnAndRow(($column++),$row, $reviewHeading);
					
				}
				$column = 1;
				$row++;
				$reviewerName = (!empty($application['ReviewUser']['id'])) ? $application['ReviewUser']['name'] : 'No reviewer assigned';
				$review_outcome = isset($AllOutcome[$application['Application']['review_outcome_id']]) ? $AllOutcome[$application['Application']['review_outcome_id']] : '';
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $reviewerName);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row,  $review_outcome);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Application']['review_date']);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Application']['review_comments']);
				$row++;
			}

			if(isset($application['proceedingHistory']) && !empty($application['proceedingHistory'])) {
				$column = 1;
				foreach($reviewProceedingHeadings as $reviewProceedingHeading) {
					$worksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($column).($row))->applyFromArray($reviewProcStyleArray);					
					$worksheet->setCellValueByColumnAndRow(($column++),$row, $reviewProceedingHeading);
					
				}
				$column = 1;
				$row++;
				foreach ($application['proceedingHistory'] as $proceeding) {
					$proc_outcome = isset($AllOutcome[$proceeding['proc_lkp_outcome_id']]) ? $AllOutcome[$proceeding['proc_lkp_outcome_id']] : '';
					$procHeqcMeeting = isset($proceeding['date']) && !empty($proceeding['date']) ? $proceeding['date'] : '';
					$procType = $this->Heqf->getProceedingTypeDesc($proceeding['proceeding_type_id']);

					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $proceeding['first_name'] . ' ' . $proceeding['last_name']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $procType);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row,  $proc_outcome);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $proceeding['proc_date']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $procHeqcMeeting);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $proceeding['proc_comments']);
					$column = 1;
					$row++;
				}
			}

		}
	}
	
	$worksheet->getHeaderFooter()->setOddHeader('&C&H' . $title);
	$worksheet->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');