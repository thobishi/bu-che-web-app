<?php
	ini_set("memory_limit","128M");
	require_once("/var/www/html/common/xls_generator/cl_xls_generator.php");
	require_once ('/var/www/html/common/_systems/nr-online.php');
	require_once (SYSTEM_ENGINE . '/class.dbTableInfo.php');
	require_once(SYSTEM_ENGINE . '/class.octoToken.php');
	require_once(SYSTEM_ENGINE . '/class.octoDoc.php');

	$nrOnline = new NRonline (1);
	octoDB::connect ();
	include '/var/www/html/common/PHPExcel/PHPExcel.php';

	/** PHPExcel_Writer_Excel5 */
	include '/var/www/html/common/PHPExcel/PHPExcel/Writer/Excel5.php'; 

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();
?>