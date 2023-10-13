<?php 

//getRestrictionsIDs(acmemid)

/*
Rebecca
2007-08-23
Displays a list of applications that have been assigned to a specific AC meeting, along with their relevant documents.
2016-10-17
Added additional documents and application form for re-accreditation
*/

	$path="../";

	require_once ("/var/www/html/common/_systems/heqc-online.php");
	//require_once ("/var/www/heqc-online/download.php");
	$dbConnect = new dbConnect();
	$app = new HEQConline (1);
	$ac_meeting_id = readGET("ac_ref");
	$ac_member_id = base64_decode(readGET("member_id"));

?>
<title>Report</title>
<link rel=STYLESHEET TYPE="text/css" href="<?php echo $path?>styles.css" title="Normal Style">
<script language="JavaScript" src="../js/che.js"></script>
<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr><td bgcolor="#CC3300" height="2"></td></tr><tr><td bgcolor="#ECF1F6" align="center"><img src="<?php echo $path?>images/help_top.gif" width="255" height="45"></td></tr></table><br>
</head>
<table width="98%" cellspacing="2" cellpadding="2" align="center" border=0>
<tr><td colspan='10'><?php $app->getACMeetingTableTop(base64_decode($ac_meeting_id));?></td></tr>
<tr><td>
<?php 


$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWD, DB_DATABASE);
if ($conn->connect_errno) {
    $this->error_email ("ERROR: $this->DBname", "$this->DBname database down\n\nMySQL: ".$conn->error () ,$this->DBname);
    printf("Error: %s\n".$conn->error);
    exit();
}

$restrictions_arr = $app->getRestrictionsIDs($ac_member_id);
// Users that are part of minutes group must see all applications
if ($app->sec_partOfGroup(23) or $app->sec_partOfGroup(13)){
	$restrictions_arr = array("0");
}

$total_applications = 0;
$viewable_applications = 0;
$restricted_applications = 0;
$meeting_id = base64_decode($ac_meeting_id);

// Record of AC meetings is kept on proceeding record from meeting 1 June 2011.
if ($meeting_id >= 15){
/*	$SQL  = <<<SQL
		SELECT lkp_proceedings.lkp_proceedings_desc,
			p.ia_proceedings_id,
			a.application_id,
			a.program_name,
			a.CHE_reference_code,
			a.institution_id,
			a.secretariat_doc,
			a.AC_desision,
			p.recomm_doc,
			p.ac_decision_ref,
			p.lkp_proceedings_ref,
			p.reaccreditation_application_ref,
			HEInstitution.priv_publ,
			HEInstitution.HEI_name 
		FROM Institutions_application a
		JOIN ia_proceedings p ON p.application_ref = a.application_id 
		INNER JOIN HEInstitution ON HEInstitution.HEI_id = a.institution_id
		LEFT JOIN lkp_proceedings ON lkp_proceedings.lkp_proceedings_id = p.lkp_proceedings_ref
		LEFT JOIN Institutions_application_reaccreditation r ON a.CHE_reference_code = r.referenceNumber
		WHERE p.ac_meeting_ref= $meeting_id and (r.reacc_submission_date > '1970-01-01' OR r.reacc_submission_date IS NULL)
SQL;*/
//2017-09-13: Richard - Added AC agenda type
	$SQL  = <<<SQL
		SELECT lkp_AC_agenda_type.lkp_AC_agenda_type_desc,
			lkp_proceedings.lkp_proceedings_desc,
			p.ia_proceedings_id,
			a.application_id,
			a.program_name,
			a.CHE_reference_code,
			a.institution_id,
			a.secretariat_doc,
			a.AC_desision,
			p.recomm_doc,
			p.ac_decision_ref,
			p.lkp_proceedings_ref,
			p.reaccreditation_application_ref,
			HEInstitution.priv_publ,
			HEInstitution.HEI_name 
		FROM Institutions_application a
		JOIN ia_proceedings p ON p.application_ref = a.application_id 
		INNER JOIN HEInstitution ON HEInstitution.HEI_id = a.institution_id
		LEFT JOIN lkp_proceedings ON lkp_proceedings.lkp_proceedings_id = p.lkp_proceedings_ref
		LEFT JOIN Institutions_application_reaccreditation r ON a.CHE_reference_code = r.referenceNumber
		LEFT JOIN lkp_AC_agenda_type on lkp_AC_agenda_type.lkp_AC_agenda_type_id = p.lkp_AC_agenda_type_ref
		WHERE p.ac_meeting_ref= ? and (r.reacc_submission_date > '1970-01-01' OR r.reacc_submission_date IS NULL)
SQL;
//	$order_by = " ORDER BY lkp_proceedings.order_acagenda, HEInstitution.priv_publ, HEInstitution.HEI_name, a.program_name";
	//2017-09-13: Richard - Added AC agenda type
	$order_by = " ORDER BY lkp_AC_agenda_type.lkp_AC_agenda_type_desc, lkp_proceedings.order_acagenda, HEInstitution.priv_publ, HEInstitution.HEI_name, a.program_name";

} else {  // Before proceedings existed and users just overwrote AC Meeting outcomes per AC meeting. Thus no history of prev AC meetings
	$SQL = <<<SQL
		SELECT 	a.application_id,
			a.program_name,
			a.CHE_reference_code,
			a.institution_id,
			a.secretariat_doc,
			a.AC_desision,
			HEInstitution.priv_publ,
			HEInstitution.HEI_name 
		FROM Institutions_application a
		INNER JOIN HEInstitution ON HEInstitution.HEI_id = a.institution_id
		WHERE a.AC_Meeting_ref = ?
SQL;
	$order_by = " ORDER BY HEInstitution.priv_publ, HEInstitution.HEI_name, a.program_name";
}

$sm = $conn->prepare($SQL);
$sm->bind_param("s", $meeting_id);
$sm->execute();
$totalRs = $sm->get_result();

//$totalRs = mysqli_query($SQL);
$total_applications = mysqli_num_rows($totalRs);

// Add restriction for the AC member logged in.  AC members may not see the applications for their institution
$SQL .= " AND a.institution_id NOT IN (1, 2, ".implode(", ", $restrictions_arr).") ";
$SQL .= $order_by;

$sm = $conn->prepare($SQL);
$sm->bind_param("s", $meeting_id);
$sm->execute();
$rs = $sm->get_result();

//$rs = mysqli_query($SQL);
$viewable_applications = mysqli_num_rows($rs);
$restricted_applications = $total_applications-$viewable_applications;

//if ($ac_member_id != "") {
	echo "<tr align='right'>";
	echo "<td colspan='10'>Total applications assigned to this meeting: ".$total_applications."<br>";
	echo "Applications viewable by you: ".$viewable_applications."<br>";
	echo "Restricted applications (not viewable by you): ".$restricted_applications."</td>";
	echo "</tr>";
//}

	echo "<tr class='oncolourb' valign='top'>";
	//echo "<td width='4%'>No.</td>";
	echo "<td width='10%'>Proceedings.</td>";
	//2017-09-13: Richard - Added AC agenda type
	echo "<td width='10%'>Type</td>";
	echo "<td width='10%'>HEQC reference number</td>";
	echo "<td width='15%'>Programme name</td>";
	echo "<td width='15%'>Institutional profile</td>";
	echo "<td width='30%'>Evaluator reports</td>";
	echo "<td width='8%'>Proceedings<br>Directorate recommendation</td>";
	echo "<td width='8%'>Outcome</td>";
	echo "</tr>";

if (mysqli_num_rows($rs) > 0) {
	$i = 1;
	while ($row = mysqli_fetch_array($rs)) {
		//tmpSettings for link to application and insitutional profile
		$tmpSettings = "PREV_WORKFLOW=11%7C154&DBINF_HEInstitution___HEI_id=".$row["institution_id"]."&DBINF_institutional_profile___institution_ref=".$row["institution_id"]."&DBINF_Institutions_application___application_id=".$row["application_id"];
		
		$recomm = "";
		if ($row['secretariat_doc'] > 0){
			$secretariatRecommendation = new octoDoc($row['secretariat_doc']);
			$recomm = "<a href='".$secretariatRecommendation->url()."' target='_blank'>".$secretariatRecommendation->getFilename()."</a>";
		}
		if (isset($row['recomm_doc']) && $row['recomm_doc'] > 0){
			$dirRecomm = new octoDoc($row['recomm_doc']);
			if ($recomm > ""){
				$recomm .= "<br>";
			}
			$recomm .= "<a href='".$dirRecomm->url()."' target='_blank'>".$dirRecomm->getFilename()."</a>";
		}

		//$evalReportsArray = array();
		$finalEvalDoc = "";
		// Set outcome to application outcome.  If there is a proceeding outcome then set it to proceeding outcome.
		$outcome = ($row['AC_desision'] > 0) ? $app->getValueFromTable("lkp_desicion", "lkp_id", $row['AC_desision'], "lkp_title") : "";
		if (isset($row["ac_decision_ref"]) && $row["ac_decision_ref"] > 0){
			$outcome = $app->getValueFromTable("lkp_desicion", "lkp_id", $row['ac_decision_ref'], "lkp_title");
		}
		$linkToApp = '<a href="javascript:winPrintApplicationForm(\'Application Form\',\''.$row["application_id"].'\', \''.base64_encode($tmpSettings).'\', \'../\');">';

		// Get additional documentation if this is a deferral, representation or conditional accreditation.
		$proc_docs = array();
		$outcome_docs = "&nbsp;";
		if ( $row['lkp_proceedings_ref'] == 2 || $row['lkp_proceedings_ref'] == 3 || $row['lkp_proceedings_ref'] == 4){
			$proc_docs = getDeferredConditionRepresentationDocuments($row['application_id']);
		
			//$outcome_docs = "<br />Related documents:<br />";
			$outcome_docs = "<br />";
			foreach ($proc_docs as $d){
				$outcome_docs .= $d . "<br />";
			}
		}
		$proceeding_desc = "No proceeding prior June 2011";
		if (isset($row["lkp_proceedings_desc"])){
			$proceeding_desc = $row["lkp_proceedings_desc"];
		}

		//If Re accreditation exists then create the link
		$reAcc = ""; $linkToReacc = "";
		if ($row['reaccreditation_application_ref'] > 0){
			//tmpSettingsReacc for link to Re-accredit application and insitutional profile
			$tmpSettingsReacc = "PREV_WORKFLOW=11%7C154&DBINF_HEInstitution___HEI_id=".$row["institution_id"]."&DBINF_institutional_profile___institution_ref=".$row["institution_id"]."&DBINF_Institutions_application_reaccreditation___Institutions_application_reaccreditation_id=".$row["reaccreditation_application_ref"];
			$reAcc = 'Re-accreditation';
			$linkToReacc = '<a href="javascript:winPrintReaccApplicForm(\'Re-accreditation Application Form\',\''.$row['reaccreditation_application_ref'].'\', \''.base64_encode($tmpSettingsReacc).'\', \'../\');">' ;
		}

		// Get additional documentation if this is a re-accreditation.
		$reAccProc_docs = array();
		$reAcc_docs = "&nbsp;";
		if ( $row['lkp_proceedings_ref'] == 5 ){
			$reAccProc_docs = getDeferredConditionRepresentationDocuments($row["ia_proceedings_id"]);
		
			$reAcc_docs = "<br />";
			foreach ($reAccProc_docs as $d){
				$reAcc_docs .= $d . "<br />";
			}
		}

		echo "<tr class='onblue' valign='top'>";
		//echo "<td valign='top'>".$i."</a></td>\n";
		echo "<td valign='top'>".$proceeding_desc. $outcome_docs ." ".$reAcc_docs."</a></td>\n";
		//2017-09-13: Richard - Added AC agenda type
		echo "<td>".$row['lkp_AC_agenda_type_desc']."</td>";
		echo "<td valign='top'>".$linkToApp.$row["CHE_reference_code"]." ".$linkToReacc.$reAcc."</a></td>\n";
		echo "<td>".$row['program_name']."</td>";
		echo '<td><a href="javascript:winPrintInstProfileForm(\'Institutional Profile\',\''.$row['institution_id'].'\', \''.base64_encode($tmpSettings).'\', \'../\');">'.$row["HEI_name"].'</a></td>';

		$evalReportsArray = $app->listEvaluatorReports($row["application_id"]);
		echo "<td>";
		foreach ($evalReportsArray as $value) {
			echo $value;
		}
		echo ($finalEvalDoc) ? "<br><a href='"."' target='_blank'>".$finalEvalDoc->getFilename()."</a>" : "&nbsp;";
	
		echo "</td>";

		echo "<td>$recomm</td>";
		echo "<td>".$outcome."</td>";
		echo "</tr>";
		$i++;
	}
}
else { echo "<td colspan='10'>No applications have been assigned to this AC meeting.</td>"; }

function getDeferredConditionRepresentationDocuments($app_id){
	
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWD, DB_DATABASE);
    if ($conn->connect_errno) {
        $this->error_email ("ERROR: $this->DBname", "$this->DBname database down\n\nMySQL: ".$conn->error () ,$this->DBname);
        printf("Error: %s\n".$conn->error);
        exit();
    }
	
	$doc_arr = array();
	
	$sql = <<<DOCUMENTS
		SELECT deferral_doc, representation_doc, condition_doc
		FROM ia_proceedings
		WHERE application_ref = $app_id
		ORDER BY ac_meeting_ref
DOCUMENTS;
    
    

   // $sm = $conn->prepare($sql);
   // $sm->bind_param("s", $app_id);
   // $sm->execute();
   // $rs = $sm->get_result();

	$rs = mysqli_query($conn, $sql);
	if ($rs){
		while ($row = mysqli_fetch_array($rs)){
			if ($row['deferral_doc'] > 0){
				$oDoc = new octoDoc($row['deferral_doc']);
				$doc = "<a href='".$oDoc->url()."' target='_blank'>".$oDoc->getFilename()."</a>";
				array_push($doc_arr, $doc);
			}
			if ($row['representation_doc'] > 0){
				$oDoc = new octoDoc($row['representation_doc']);
				$doc = "<a href='".$oDoc->url()."' target='_blank'>".$oDoc->getFilename()."</a>";
				array_push($doc_arr, $doc);
			}
			if ($row['condition_doc'] > 0){
				$oDoc = new octoDoc($row['condition_doc']);
				$doc = "<a href='".$oDoc->url()."' target='_blank'>".$oDoc->getFilename()."</a>";
				array_push($doc_arr, $doc);
			}
		}
	}
	return $doc_arr;
}
?>
</td></tr></table>
