<?php
	if (empty($worksheet)) {
		$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	}

	$headings = array(
		'Qualification reference',
		'Module reference',
		'Year',
		'Compulsory',
		'Elective',
		'Action'
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

	$tableData = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('argb' => '000000'),
			)
		)
	);

	$column = 0;
	$row = 1;
	foreach ($headings as $heading) {
		$worksheet->setCellValueByColumnAndRow($column, $row, $heading);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);
	}
	$worksheet->getStyle('A1:' . PHPExcel_Cell::stringFromColumnIndex($column - 1) . $row)->applyFromArray($headerArray);

	$row = 2;
	foreach ($qualModules as $module) {
		$column = 0;
		$worksheet->setCellValueByColumnAndRow($column, $row, $module['HeqfQualification']['s1_qualification_reference_no']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['InstitutionModule']['reference']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['HeqfQualificationModule']['year']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['HeqfQualificationModule']['compulsory']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['HeqfQualificationModule']['elective']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $moduleActions[$module['HeqfQualificationModule']['module_action_id']]);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$row++;
	}

	$worksheet->setTitle('Qualification modules');

	$worksheet2 = $this->PhpExcel->createSheet();
	$this->element('../institution_modules/xls/export', array('worksheet' => $worksheet2, 'row' => 2));
	$worksheet2->mergeCells('A1:' . $worksheet2->getHighestColumn() . '1');
	$worksheet2->setCellValueByColumnAndRow(0, 1, 'For information only! Changes to this sheet will be ignored on import.');
	$headerArray['font']['size'] = '15';
	$headerArray['font']['color'] = array(
		'rgb' => 'AA2020'
	);
	$headerArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
	$headerArray['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;
	$headerArray['alignment']['wrap'] = true;
	$worksheet2->getStyle('A1:' . $worksheet2->getHighestColumn() . '1')->applyFromArray($headerArray);
	$worksheet2->getColumnDimensionByColumn(0)->setAutoSize(true);
	$worksheet2->getRowDimension(1)->setRowHeight(55);

	$this->PhpExcel->setActiveSheetIndex(0);

	$filename = 'Qualfication modules';
	if (isset($this->params['named']['qual'])) {
		$qualRef = Set::extract($qualModules, '/HeqfQualification/s1_qualification_reference_no');
		$filename .= ' - ' . array_shift($qualRef);
	}
	$this->setOption('filename', $filename);