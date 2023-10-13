<?php
	if (empty($worksheet)) {
		$worksheet = $this->PhpExcel->setActiveSheetIndex(0);
	}
	$worksheet->setTitle('Institution modules');

	$headings = array(
		'Module reference',
		'Module title',
		'NQF Level',
		'Credits',
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
	if (empty($row)) {
		$row = 1;
	}
	foreach ($headings as $heading) {
		$worksheet->setCellValueByColumnAndRow($column, $row, $heading);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);
	}
	$worksheet->getStyle('A' . $row . ':' . PHPExcel_Cell::stringFromColumnIndex($column - 1) . $row)->applyFromArray($headerArray);

	$row++;
	foreach ($modules as $module) {
		$column = 0;
		$worksheet->setCellValueByColumnAndRow($column, $row, $module['InstitutionModule']['reference']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['InstitutionModule']['title']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['InstitutionModule']['nqf_level_id']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$worksheet->setCellValueByColumnAndRow($column, $row, $module['InstitutionModule']['credits']);
		$worksheet->getColumnDimensionByColumn($column++)->setAutoSize(true);

		$row++;
	}

	$this->setOption('filename', 'Institution modules');