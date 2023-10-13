<?php
	$this->PhpExcel->setActiveSheetIndex(0);
	/*Split panes*/
	$this->PhpExcel->getActiveSheet()->freezePane('A2');
	
	/*Background colour for headings*/
	
	$count = 0;
	$totalSites = 0;
	foreach($heqcData as $application){
		if(isset($application['Site'])){
			$count = count($application['Site']);
		}
		
		$totalSites = ($totalSites < $count) ? $count : $totalSites;
	}
	$lastRow = 74;//J
	
	$this->PhpExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('C0C0C0');
	$this->PhpExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('C0C0C0');
	$this->PhpExcel->getActiveSheet()->getStyle('C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('C1')->getFill()->getStartColor()->setRGB('C0C0C0');
	$this->PhpExcel->getActiveSheet()->getStyle('D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('D1')->getFill()->getStartColor()->setRGB('C0C0C0');
	$this->PhpExcel->getActiveSheet()->getStyle('E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('E1')->getFill()->getStartColor()->setRGB('C0C0C0');	
	$this->PhpExcel->getActiveSheet()->getStyle('F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('F1')->getFill()->getStartColor()->setRGB('C0C0C0');		
	$this->PhpExcel->getActiveSheet()->getStyle('G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('G1')->getFill()->getStartColor()->setRGB('C0C0C0');		
	$this->PhpExcel->getActiveSheet()->getStyle('H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('H1')->getFill()->getStartColor()->setRGB('C0C0C0');		
	$this->PhpExcel->getActiveSheet()->getStyle('I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('I1')->getFill()->getStartColor()->setRGB('C0C0C0');			
	$this->PhpExcel->getActiveSheet()->getStyle('J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$this->PhpExcel->getActiveSheet()->getStyle('J1')->getFill()->getStartColor()->setRGB('C0C0C0');			
	for($i = 1;$i <= $totalSites;$i++){
		$this->PhpExcel->getActiveSheet()->getStyle(chr($lastRow+$i).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->PhpExcel->getActiveSheet()->getStyle(chr($lastRow+$i).'1')->getFill()->getStartColor()->setRGB('C0C0C0');			
	}			
	
	/*Column widths and order*/
	$columnsOrder = array(
		'CHE_reference_code',
		'program_name',
		'saqa_reg_nr',
		'mode_delivery',
		'NQF_ref',
		'full_time',
		'part_time',		
		'num_credits'
	);
	
	$this->PhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$this->PhpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	for($i = 1;$i <= $totalSites;$i++){
			$this->PhpExcel->getActiveSheet()->getColumnDimension(chr($lastRow+$i))->setWidth(35);
	}
	$this->PhpExcel->getActiveSheet()->SetCellValue('A1', 'Inst name');
	$this->PhpExcel->getActiveSheet()->SetCellValue('B1', 'HEQC inst no');
	$this->PhpExcel->getActiveSheet()->SetCellValue('C1', 'HEQC ref');		
	$this->PhpExcel->getActiveSheet()->SetCellValue('D1', 'Qual title');
	$this->PhpExcel->getActiveSheet()->SetCellValue('E1', 'SAQA qual id');
	$this->PhpExcel->getActiveSheet()->SetCellValue('F1', 'Mode of delivery');
	$this->PhpExcel->getActiveSheet()->SetCellValue('G1', 'NQF level');
	$this->PhpExcel->getActiveSheet()->SetCellValue('H1', 'MIN duration full');
	$this->PhpExcel->getActiveSheet()->SetCellValue('I1', 'MIN duration part');	
	$this->PhpExcel->getActiveSheet()->SetCellValue('J1', 'Total credits');
	for($i = 1;$i <= $totalSites;$i++){
			$this->PhpExcel->getActiveSheet()->SetCellValue(chr($lastRow+$i).'1', 'Site '.$i);
	}
	
	/*Fill in the data*/
	$row = 2;
	foreach($heqcData as $extractData){
		$column = 0;		
		if(isset($extractData['HeqcInstitution'])){
			foreach($extractData['HeqcInstitution'] as $value){
				$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow($column++,$row, $value);
			}		
		}
		foreach($columnsOrder as $columnName){
			$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow($column++,$row, $extractData['HeqcInstitutionApplication'][$columnName]);
		}
		if(isset($extractData['Site'])){
			foreach($extractData['Site'] as $value){
				$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow($column++,$row, $value);
			}				
		}
		$row++;
	}

	/*Sheet title*/
	$this->PhpExcel->getActiveSheet()->setTitle('S1 Existing qualification info');	
