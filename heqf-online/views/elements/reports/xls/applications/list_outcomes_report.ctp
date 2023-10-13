<?php
	$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	$title = 'Report - List of outcomes per institution - ' . date('Y-m-d H:i');
	$fileName = 'Report - List of outcomes per institution';
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);
	
	$row = 1;

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
		foreach($reportData as $instName => $data){
			$column = 0;
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column, $row, $instName);
			$worksheet->getStyle(chr(65 + $column) . $row . ':' . chr(65 + $column) . $row)->applyFromArray($headerArray);
			$row++;
			foreach($data as $outcome => $info){
				/*Top headers*/
				$startRow = $row;
				$column = 0;
				$worksheet->mergeCells(chr(65 + $column) . $row . ':' . chr(65 + $column + 2) . $row);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column, $row, 'Outcome: ' . $outcome);
				$column += 5;
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column, $row, 'Total: ' . count($info));
				$worksheet->getRowDimension($row)->setOutlineLevel(1);
				$worksheet->getRowDimension($row)->setVisible(false);
				$row++;
				$column = 0;
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Existing qualification name');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Aligned qualification name');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Qualification title abbreviation');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'SAQA qualification ID');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'NQF');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Total credits');
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'CESM');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Mode of delivery');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Major field of study');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Category');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column, $row, 'Outcome');
				$worksheet->getStyle(chr(65) . $startRow . ':' . chr(65 + $column) . $row)->applyFromArray($subHeaderArray);
				$worksheet->getRowDimension($row)->setOutlineLevel(1);
				$worksheet->getRowDimension($row)->setVisible(false);
				$row++;
				foreach($info as $application){
					/*Data*/
					$column = 0;
					$deliveryModeDesc = isset($DeliveryMode[$application['Mode of delivery']]) ? $DeliveryMode[$application['Mode of delivery']] : '';
					$NqfLevelDesc = isset($NqfLevel[$application['NQF']]) ? $NqfLevel[$application['NQF']] : '';
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Existing qualification name']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Aligned qualification name']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$cesms = $this->Heqf->reportMultiple($application['CESM'], $CesmCode);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Qualification title abbreviation']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $application['SAQA qualification ID']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $NqfLevelDesc);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Total credits']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $cesms);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $deliveryModeDesc);
					$majors = $this->Heqf->reportMultiple($application['Major field of study'], $HemisQualifier);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $majors);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Category']);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column, $row, $outcome);
					$worksheet->getStyle(chr(65) . $startRow . ':' . chr(65 + $column) . $row)->applyFromArray($tableData);
					$worksheet->getRowDimension($row)->setOutlineLevel(1);
					$worksheet->getRowDimension($row)->setVisible(false);
					$row++;
				}
			}
			$worksheet->getRowDimension($row)->setCollapsed(true);
			/*group here*/
			$worksheet->setShowSummaryBelow(false);
			$row++;
		}
	}
	
	$worksheet->getHeaderFooter()->setOddHeader('&C&H' . $title);
	$worksheet->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');
?>