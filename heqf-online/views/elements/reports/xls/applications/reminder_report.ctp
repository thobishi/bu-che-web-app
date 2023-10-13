<?php
	$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	$title = 'Report - Evaluator/Reviewer reminder - ' . date('Y-m-d H:i');
	$fileName = 'Report - Evaluator/Reviewer reminder';
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);
	
	$row = 1;

	$headings = array(
		'Institution',
		'Qualification title (Section 2)',
		'Institution alignment Category',
		'Application status',
		'User assigned to',
		'Assigned date',
		'Due date',
		'Days outstanding',
		'First reminder',
		'Second reminder',
		'First overdue reminder',
		'Second overdue reminder'	
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
	$maxColumn = count($headings) - 1;
	$style = $worksheet->getStyle('A1:'.(PHPExcel_Cell::stringFromColumnIndex($maxColumn)).($row))->applyFromArray($headerArray);
	$worksheet->freezePane('A2');

	foreach($headings as $heading) {
		$worksheet->setCellValueByColumnAndRow(($column++),$row, $heading);
	}
	$column = 0;
	$row = 2;

	if(!empty($reportData)) {
		foreach ($reportData as $key => $application) {
			$column = 0;
			$applicationStatus = $this->Status->getStatus($application['Application']);
			$QualRefNo = '';
			$QualRefNo = !empty($application['HeqfQualification']['qualification_reference_no']) ? $application['HeqfQualification']['qualification_reference_no'] : $application['HeqfQualification']['s1_qualification_reference_no'];
			$QualRefNo = (!empty($QualRefNo)) ? ' (' . $QualRefNo . ')' : '';

			$displayName = $application['User']['first_name'] . ' ' . $application['User']['last_name'];
			$displayEmail = (!empty($application['User']['email_address'])) ? '('.$application['User']['email_address'].')' : '';
			$display = $displayName . '<br />' . $displayEmail;
			if($displayName == ' ' && empty($displayEmail)){
				$display = '&nbsp;';					
			}

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Institution']['hei_name'] . ' (' 
			.$application['Institution']['hei_code']. ')');


			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, !empty($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] . $QualRefNo : '');

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row,  $application['HeqfQualification']['s1_lkp_heqf_align_id']);

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $applicationStatus);

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $displayName);

			$assignedDate =  $this->Heqf->getAssignedDate($application, $applicationStatus);
			$dueDate =  $this->Heqf->getDueDate($application, $applicationStatus); 
			$daysOutstanding =  $this->Heqf->getDaysOutstanding($application, $applicationStatus);
			$first_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'first_reminder');
			$second_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'second_reminder');
			$third_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'third_reminder');
			$fourth_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'fourth_reminder');

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $assignedDate);

			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $dueDate );
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $daysOutstanding);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $first_reminder);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $second_reminder);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $third_reminder);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $fourth_reminder);
			$row++;
		}

	}
	
	$worksheet->getHeaderFooter()->setOddHeader('&C&H' . $title);
	$worksheet->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');
?>