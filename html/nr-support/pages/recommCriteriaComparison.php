<?php
	$path="../";
	require_once("_systems/nr-online.php");
	$NRonline = new NRonline(2);
	$prog_id = readGET("prog_id", 0);

	$NRonline->displayCriteriaComparison($prog_id);
?>