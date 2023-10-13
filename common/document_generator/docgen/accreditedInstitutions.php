<?php
	require_once ('/var/www/html/common/_systems/heqc-online.php');
	require_once ('/var/www/html/common/document_generator/cl_xml2driver.php');

	octoDB::connect ();
	writeXMLhead ();
?>

<DOC
	config_file="docgen/doc_config.inc"
	title="Project Budget and Expenditure Report"
	subject=""
	author="Project Register"
	manager=""
	company="Council on Higher Education"
	operator=""
	category="Project Budget and Expenditure"
	keywords="project budget report"
	comment=""
>

<?php

	HEQConline::displayReportCoverPage("Accredited Institutions Report");
	HEQConline::displayGeneralPageSetup("Accredited Institutions Report");
	echo "<section landscape='yes'/>\n";

//set variables for document
	$hei_id = readGET("hei_id");

	HEQConline::reportAccreditedInstitutions($hei_id, "docgen");

?>

</DOC>
