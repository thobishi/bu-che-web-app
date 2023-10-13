<?php
	$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	$title = 'Report - HEQSF alignment outcomes per institution - ' . date('Y-m-d H:i');
	$fileName = 'Report - HEQSF alignment outcomes per institution';
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);
	
	$row = 1;
	
	$headings = array(
		'Outcome',
		'Category',
		'Number'
	);
	
	$subHeadings = array(
		'Existing qualification name',
		'Aligned qualification name',
		'Qualification reference number',
		'HEQSF reference number',
		'SAQA qualification ID',
		'NQF',
		'Total credits',
		'Category',
		'Outcome'
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
		foreach ($reportData as $institution => $data){
			$column = 0;
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column, $row, $institution);
			$worksheet->getStyle(chr(65 + $column) . $row . ':' . chr(65 + $column) . $row)->applyFromArray($headerArray);
			$row++;
			$worksheet->getStyle(chr(65 + $column) . $row . ':' . chr(65 + $column + 2) . $row)->applyFromArray($subHeaderArray);
			
			$worksheet->getRowDimension($row)->setOutlineLevel(1);
			$worksheet->getRowDimension($row)->setVisible(false);
			
			foreach($headings as $heading) {
				$worksheet->setCellValueByColumnAndRow(($column++),$row, $heading);
			}
			
			$row++;

			$totalCount = 0;
			foreach($data as $outcome => $catData){
				foreach($catData as $category => $applications){
					$column = 0;
					$worksheet->getRowDimension($row)->setOutlineLevel(1);
					$worksheet->getRowDimension($row)->setVisible(false);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $outcome);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $category);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, count($applications));
					$row++;
					$totalCount += count($applications);
				}
			}
			$column = 0;
			$worksheet->getRowDimension($row)->setOutlineLevel(1);
			$worksheet->getRowDimension($row)->setVisible(false);
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, 'Total number of applications submitted');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, '');
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column++, $row, $totalCount);
			$row++;
			
			$column = 0;
			$worksheet->getStyle(chr(65 + $column) . $row . ':' . chr(65 + $column + 5) . $row)->applyFromArray($subHeaderArray);
			
			$worksheet->getRowDimension($row)->setOutlineLevel(1);
			$worksheet->getRowDimension($row)->setVisible(false);
			
			foreach($subHeadings as $subHeading) {
				$worksheet->setCellValueByColumnAndRow(($column++),$row, $subHeading);
			}
			
			$row++;

			foreach($data as $outcome => $catData){
				foreach($catData as $category => $applications){
					foreach($applications as $application){
						$column = 0;
						$worksheet->getRowDimension($row)->setOutlineLevel(1);
						$worksheet->getRowDimension($row)->setVisible(false);
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Existing qualification name']);
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Aligned qualification name']);
						
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Qualification reference number']);
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $application['HEQSF reference number']);

						$NqfLevelDesc = isset($NqfLevel[$application['NQF']]) ? $NqfLevel[$application['NQF']] : '';
						$worksheet->setCellValueByColumnAndRow($column++, $row, $application['SAQA qualification ID']);
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $NqfLevelDesc);
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $application['Total credits']);
						
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $category);
						$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
						$worksheet->setCellValueByColumnAndRow($column++, $row, $outcome);
						$row++;
					}
				}
			}
			
			$worksheet->getRowDimension($row)->setCollapsed(true);
			$worksheet->setShowSummaryBelow(false);
			$row++;
			
		}
	}
	
	$worksheet->getHeaderFooter()->setOddHeader('&C&H' . $title);
	$worksheet->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');