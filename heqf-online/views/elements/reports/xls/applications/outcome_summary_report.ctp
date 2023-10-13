<?php
	$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	$title = 'Report - Outcome summary per institution - ' . date('Y-m-d H:i');
	$fileName = 'Report - Outcome summary per institution';
	$this->set('title_for_layout', $title);
	$this->setOption('filename', $fileName);

	$categories = array(
		'A', 'B', 'C'
	);
	
	$headings = array(
		'Outcome',
		'Category',
		'Number'
	);
	
/*
	Need to get the validation messages and the field names somehow, without hardcoding
	-> set them in the controller ??
*/
	
	$column = 0;
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
	
	$tableHeaders = array(
		'font' => array(
			'bold' => true
		),
	);
	
	$instArray = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => 'D9F2D0'
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
		foreach($reportData as $instInfo){
			$column = 0;
			$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
			$worksheet->setCellValueByColumnAndRow($column, $row, $instInfo['Institution']['hei_name'] . ' (' 
			.$instInfo['Institution']['hei_code']. ')');
			$worksheet->getStyle(chr(65 + $column) . $row . ':' . chr(65 + $column + 12) . $row)->applyFromArray($headerArray);
			$row++;
			$startRow = $row;
			foreach($categories as $category){
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column, $row++, 'Number of category ' . $category . ' applications received: ' . $instInfo['Application']['category_' . $category .'_total']);
				foreach($headings as $heading) {
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $column) . ($row))->applyFromArray($tableHeaders);
					$worksheet->setCellValueByColumnAndRow(($column++),$row, $heading);
				}
				$lastRow = $row;
				$lastColumn = $column;
				//accredited
				$count = 0;
				foreach($categories as $subCategory){
					$row++;
					$column -= 3;
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, ($count == 0) ? 'Deemed accredited' : '');
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $subCategory);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $instInfo['Application']['accredited_' . $category . '_' . $subCategory. '_total']);
					$count++;
					//style
					$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $column - 1) . ($row))->applyFromArray($tableData);
				}
				//re-categorised
				$count = 0;
				foreach($categories as $subCategory){
					$row++;
					$column -= 3;
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, ($count == 0) ? 'Re-categorised' : '');
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $subCategory);
					$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
					$worksheet->setCellValueByColumnAndRow($column++, $row, $instInfo['Application']['re_categorised_' . $category . '_' . $subCategory]);
					$count++;
					//style
					$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $column - 1) . ($row))->applyFromArray($tableData);
				}			
				//not
				$row++;
				$column -= 3;
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'Not HEQSF-aligned');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $category);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $instInfo['Application']['not_aligned_' . $category]);
				//style
				$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $column - 1) . ($row))->applyFromArray($tableData);
				
				//no outcome
				$row++;
				$column -= 3;
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, 'No outcome (not processed yet)');
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $category);
				$worksheet->getColumnDimensionByColumn($column)->setAutoSize(true);
				$worksheet->setCellValueByColumnAndRow($column++, $row, $instInfo['Application']['no_outcome_' . $category]);
				//style
				$worksheet->getStyle(chr(65) . $row . ':' . chr(65 + $column - 1) . ($row))->applyFromArray($tableData);
				
				//reset
				$column = $lastColumn;
				$row = $lastRow - 1;
				
				$column++; //space inbetween tables
			}
			$row += 12;
			$worksheet->getStyle(chr(65) . $startRow . ':' . chr(65 + $column) . ($row - 2))->applyFromArray($instArray);
		}
	}
	
	$worksheet->getHeaderFooter()->setOddHeader('&C&H' . $title);
	$worksheet->getHeaderFooter()->setOddFooter('&L&B' . $title . '&RPage &P of &N');

?>
    