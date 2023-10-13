<?php
        $conn = $this->getDatabaseConnection();
	function formatDate($ddate,$upl_ind=0){
		if ($ddate == '1000-01-01' || $ddate ==''){
			return "&nbsp;";
		}

		// Submission requirements for due date have been met.
		if ($upl_ind == 1){
			return $ddate;
		}

		$dt_format = "&nbsp;";

		$date_today = date("Y-m-d");  // used to flag dates that are nearing or passed end dates.
		$ddarr = explode("-",$ddate);

		$di2w = date ("Y-m-d", mktime (0,0,0,$ddarr[1],$ddarr[2]-14,$ddarr[0]));

		$colr = "#000000";
		$color_green = "#228B22";
		$color_orange = "#FFA500";
		$color_red = "#ff0000";

		if ($ddate > '1000-01-01'){
			// Due date passed and complete date not set. Order is important.
			if ($ddate > $date_today) $colr = $color_green;
			if ($ddate > $date_today && $date_today > $di2w) $colr = $color_orange;
			if ($ddate < $date_today) $colr = $color_red;
			
			$dt_format = '<span style="color:'.$colr.'">'.$ddate.'</span>';
		}

		return $dt_format;
	}

	$fc_arr = $this-> build_candidacy_search_criteria($_POST);
	// 2012-02-06 The decode of this serialize and encode was failing on dates passed.  Encoding a string.
	// 2014-09-26 < and > are not part of base64 alphabet.  This is causing the problem.
	//$ser_fc_arr = base64_encode(serialize($fc_arr));

	$filter_criteria = (count($fc_arr) > 0) ? "AND ". implode(' AND ',$fc_arr) : "";
	$fc_replace = str_replace(">","+gt+",$filter_criteria);
	$fc_replace = str_replace("<","+lt+",$fc_replace);
	$ser_fc_arr = base64_encode($fc_replace);

?>
<br>
<table width="100%" border=0 align="center" cellpadding="2" cellspacing="2">
<tr>
	<td class="loud">Process applications:</td>
<tr>
	<td>
		<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td align="right">Institution:</td>
			<td><?php $this->showField('search_institution');	?></td>
		</tr>
		<tr>
			<td align="right">HEQC Reference Number:  </td>
			<td><?php $this->showField('search_HEQCref');	?></td>
		</tr>
		<tr>
			<td align="right">Programme name:  </td>
			<td><?php $this->showField('search_progname');	?></td>
		</tr>
		<tr>
			<td align="right">Mode of delivery:  </td>
			<td><?php $this->showField('mode_delivery');	?></td>
		</tr>		
		<tr>
			<td align="right">Original application Submission date: From	</td>
			<td><?php $this->showField('subm_start_date');	?>	To: <?php $this->showField('subm_end_date');	?></td>
		</tr>
		<tr>
			<td align="right">Proceeding Submission date: From	</td>
			<td><?php $this->showField('proc_subm_start_date');	?>	To: <?php $this->showField('proc_subm_end_date');	?></td>
		</tr>
		<tr>
			<td align="right">Invoice date: From</td>
			<td><?php $this->showField('invoice_start_date');	?>	To: <?php $this->showField('invoice_end_date');	?>
			</td>
		</tr>
		<tr>
			<td align="right">Appoint evaluators: From</td>
			<td><?php $this->showField('evalappoint_start_date');	?>	To: <?php $this->showField('evalappoint_end_date');	?></td>
		</tr>
		<tr>
			<td align="right">Directorate recommendation due: From</td>
			<td><?php $this->showField('recomm_due_start_date');	?>	To: <?php $this->showField('recomm_due_end_date');	?></td>
		</tr>
		<tr>
			<td align="right">AC meeting date: From</td>
			<td><?php $this->showField('acmeeting_start_date');	?>	To: <?php $this->showField('acmeeting_end_date');?></td>
		</tr>
		<tr>
			<td align="right">HEQC meeting date: From</td>
			<td><?php $this->showField('heqcmeeting_start_date');	?>	To: <?php $this->showField('heqcmeeting_end_date');?></td>
		</tr>
		<tr>
			<td align="right">HEQC Decision:</td>
			<td><?php $this->showField('search_heqc_decision'); ?>
		</tr>
		<tr>
			<td align="right">
				Outcome due date: From<br><span class="specialsi">(Select specific HEQC decision for due dates for that decision)</span>
			</td>
			<td><?php $this->showField('outcome_due_start_date');	?>	To: <?php $this->showField('outcome_due_end_date');	?> </td>
		</tr>		
		<tr>
			<td align="right">Outcome:  </td>
			<td><?php $this->showField('search_outcome');	?>	or	<?php $this->showField('no_outcome');	?> Check to identify applications without outcomes</td>
		</tr>
		<tr>
			<td align="right">Application processing status:  </td>
			<td><?php $this->showField('search_status');	?></td>
		</tr>
		<tr>
			<td align="right">Show who currently has the process:<br><span class="specialsi">Note: Takes a while to run if checked</span></td>
			<td><?php $this->showField('display_process');	?></td>
		</tr>
		<tr>
			<td align="center" colspan="4">
				<br><input type="submit" class="btn" name="submitButton" value="Search" onClick="javascript:moveto('_label_candidacyProcessApplic');">
				<input type="button" class="btn" name="clear" value="Clear fields" onclick="clearFields(document.defaultFrm);">
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<?php

$conn = $this->getDatabaseConnection();
if ($filter_criteria > "" OR isset($_POST['submitButton'])){

	$s_displayProcess = readPost('display_process');

	$sql = <<<APP
		SELECT Distinct HEInstitution.HEI_name,
			HEInstitution.HEI_code,
			Institutions_application.institution_id,
			Institutions_application.application_id,
			Institutions_application.submission_date,
			Institutions_application.CHE_reference_code,
			Institutions_application.program_name,
			Institutions_application.mode_delivery,
			Institutions_application.secretariat_doc,
			Institutions_application.AC_Meeting_date,
			Institutions_application.AC_desision,
			Institutions_application.AC_conditions_doc,
			app.ac_start_date AS app_ac_start_date,
			Institutions_application.application_status,
			Institutions_application.evaluator_access_end_date,
			Institutions_application.deferral_doc,
			Institutions_application.condition_doc,
			Institutions_application.representation_doc,
			Institutions_application.withdrawn_ind
                        Institutions_application.withdrawn_decision_ref,
   		        Institutions_application.withdrawn_decision_date,
		FROM Institutions_application
		LEFT JOIN ia_proceedings ON ia_proceedings.application_ref = Institutions_application.application_id
		LEFT JOIN AC_Meeting AS iap ON iap.ac_id = ia_proceedings.ac_meeting_ref
		LEFT JOIN AC_Meeting AS app ON app.ac_id = Institutions_application.AC_Meeting_ref
		LEFT JOIN HEQC_Meeting ON HEQC_Meeting.heqc_id = ia_proceedings.heqc_meeting_ref
		LEFT JOIN payment ON payment.application_ref = Institutions_application.application_id
		LEFT JOIN HEInstitution ON HEInstitution.HEI_id = Institutions_application.institution_id
		LEFT JOIN evalReport ON evalReport.application_ref = Institutions_application.application_id
		WHERE Institutions_application.submission_date > '1000-01-01'
		$filter_criteria
		ORDER BY Institutions_application.CHE_reference_code
APP;
// 2017-08-02 Richard: Changes to include reaccreditation details in main proceeding
$sql = <<<APP
		SELECT Distinct HEInstitution.HEI_name,
			HEInstitution.HEI_code,
			Institutions_application.institution_id,
			Institutions_application.application_id,
			Institutions_application.submission_date,
			Institutions_application.CHE_reference_code,
			Institutions_application.program_name,
			Institutions_application.mode_delivery,
			Institutions_application.secretariat_doc,
			Institutions_application.AC_Meeting_date,
			Institutions_application.AC_desision,
			Institutions_application.AC_conditions_doc,
			app.ac_start_date AS app_ac_start_date,
			Institutions_application.application_status,
			Institutions_application.evaluator_access_end_date,
			Institutions_application.deferral_doc,
			Institutions_application.condition_doc,
			Institutions_application.representation_doc,
			Institutions_application.withdrawn_ind,
			Institutions_application.withdrawn_decision_ref,
   		        Institutions_application.withdrawn_decision_date,
			HEInstitution.HEI_id
		FROM Institutions_application
		LEFT JOIN ia_proceedings ON ia_proceedings.application_ref = Institutions_application.application_id
		LEFT JOIN AC_Meeting AS iap ON iap.ac_id = ia_proceedings.ac_meeting_ref
		LEFT JOIN AC_Meeting AS app ON app.ac_id = Institutions_application.AC_Meeting_ref
		LEFT JOIN HEQC_Meeting ON HEQC_Meeting.heqc_id = ia_proceedings.heqc_meeting_ref
		LEFT JOIN payment ON payment.application_ref = Institutions_application.application_id
		LEFT JOIN HEInstitution ON HEInstitution.HEI_id = Institutions_application.institution_id
		LEFT JOIN evalReport ON evalReport.application_ref = Institutions_application.application_id
		WHERE Institutions_application.submission_date > '1000-01-01'
		$filter_criteria
		ORDER BY Institutions_application.CHE_reference_code
APP;
	$rs = mysqli_query($conn, $sql);
	$n_app = mysqli_num_rows($rs);
?>
	<hr>
	<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2">
	<tr class="Loud">
		<td class="Loud">
			List of accreditation applications
		</td>
		<td class="Loud" align="right"><?php echo "Number of applications: " . $n_app; ?>
		</td>
	</tr>
	<tr class="Loud">
		<td class="Loud">
		</td>
		<td class="Loud" align="right">
			<a href="docgen/xls_candidacyInterfaceReport.php?data=<?php echo $ser_fc_arr; ?>" target="_blank">Download report in Excel</a>
		</td>
	</tr>	
	<tr>
		<td colspan="2">
			<!-- <td class="doveblox">Representations<br>Submission<br>date</td> -->
			<?php 
			$html = <<<HTMLHEAD
				<table class="saphireframe" width="100%" border=0  cellpadding="2" cellspacing="0">
				<tr class="doveblox">
					<td class="doveblox">Edit</td>
					<td class="doveblox">Institution<br>name</td>
					<td class="doveblox">HEQC<br>reference<br>number</td>
					<td class="doveblox">Programme<br>name</td>
					<td class="doveblox">Mode of<br>delivery</td>
					<td class="doveblox">Submission<br>date</td>
					<td class="doveblox">Progress<br>status</td>
					<td class="doveblox">Invoice<br>date</td>
					<td class="doveblox">Payment<br>/PQM<br>confirmed</td>
					<td class="doveblox">Screening</td>
					<td class="doveblox">Evaluators<br>appointed<br>date</td>
					<td class="doveblox">Evaluators<br>report<br>due</td>
					<td class="doveblox">Evaluators<br>report<br>received</td>
					<td class="doveblox">Directorate<br>recommendation<br>due</td>
					<td class="doveblox">Directorate<br>recommendation</td>
					<td class="doveblox">Background<br>or<br>Conditions</td>
					<td class="doveblox">Date of<br>AC meeting</td>
					<td class="doveblox">Deferral<br>due date</td>
					<td class="doveblox">Deferral<br>Information<br>received</td>
					<td class="doveblox">Date of<br>HEQC Board<br>meeting</td>
					<td class="doveblox">Outcome</td>
					<td class="doveblox">Letter to institution<br> and document basket</td>
					<td class="doveblox">Conditions<br>due</td>
					<td class="doveblox">Conditions<br>report</td>
					<td class="doveblox">Representations<br>due</td>
					<td class="doveblox">Representations<br>report</td>
   					<td class="doveblox">Accreditation Withdrawn<br>report</td>
					<td class="doveblox">Date Withdrawn<br>report</td>
				</tr>
HTMLHEAD;

			if ($rs){

				$cross = '<img src="images/dash_mark.gif">';
				$check = '<img src="images/check_mark.gif">';
				$notapplic = 'n/a';
				$historic = 'historic';

				while ($row = mysqli_fetch_array($rs)){
					$app_id = $row["application_id"];
					$inst_id = $row["institution_id"];
					$mode_deliveryDesc = $this->getValueFromTable("lkp_mode_of_delivery","lkp_mode_of_delivery_id",$row["mode_delivery"],"lkp_mode_of_delivery_desc");
					$link1 = $this->scriptGetForm ('Institutions_application', $app_id, 'next');
					
					// 2017-08-02 Richard: Changes to include previous title
					$programName = $row["program_name"];
					$prevTitleSQL=<<<prevTitle
						SELECT old_title
						FROM ia_title_history 
						WHERE application_ref = ?
prevTitle;
                                        $stmt = $conn->prepare($prevTitleSQL);
                                        $stmt->bind_param("s", $app_id);
                                        $stmt->execute();
					
					$prevTitleRS = $stmt->get_result(); //mysqli_query($prevTitleSQL);
					$prevTitle = "";
					while ($prevTitlerow = mysqli_fetch_array($prevTitleRS)){
						if ($prevTitlerow['old_title'] > ""){
							$prevTitle .= $prevTitlerow['old_title'] . '<br>';
						}
					}
					if ($prevTitle > ""){
						$programName = $programName." <i><small>Previous: ".$prevTitle."</small></i>";
					}
					
					$tmpSettings = "PREV_WORKFLOW=36%7C213&DBINF_HEInstitution___HEI_id=".$inst_id."&DBINF_institutional_profile___institution_ref=".$inst_id."&DBINF_Institutions_application___application_id=".$app_id;
					$applicationLink = '<a href="javascript:winPrintApplicationForm(\'Application Form\',\''.$app_id.'\', \''.base64_encode($tmpSettings).'\', \'\');">'.$row["CHE_reference_code"].'</a>';
					
					// 2017-08-02 Richard: Changes to include institutional profile in main proceeding
					$link2 = '<a href="javascript:winPrintInstProfileForm(\'Institutional Profile\',\''.$row["HEI_id"].'\', \''.base64_encode($tmpSettings).'\', \'\');">'.$row["HEI_name"]."</a>";
					
					// 2017-08-02 Richard: Changes to include reaccreditation details in main proceeding
					//If Re accreditation exists then create the link
//					$reACCSQL=<<<reAcc
//						SELECT reaccreditation_application_ref, DATE_FORMAT(Institutions_application_reaccreditation.reacc_submission_date, '%Y%m') AS reacc_submission_date
//						FROM ia_proceedings
//						LEFT JOIN Institutions_application ON ia_proceedings.application_ref = Institutions_application.application_id
//						LEFT JOIN Institutions_application_reaccreditation ON Institutions_application.CHE_reference_code = Institutions_application_reaccreditation.referenceNumber
//						WHERE application_ref = $app_id
//reAcc;

					// 2017-11-30 Richard: Changed to remove reference to ia_proceedings table
					//If Re accreditation exists then create the link
					$reACCSQL=<<<reAcc
						SELECT Institutions_application_reaccreditation_id, DATE_FORMAT(Institutions_application_reaccreditation.reacc_submission_date, '%Y%m') AS reacc_submission_date
						FROM Institutions_application 
						LEFT JOIN Institutions_application_reaccreditation ON Institutions_application.CHE_reference_code = Institutions_application_reaccreditation.referenceNumber
						WHERE application_id = ?
reAcc;

                                        $stmt = $conn->prepare($reACCSQL);
                                        $stmt->bind_param("s", $app_id);
                                        $stmt->execute();
					
					$reAccRs = $stmt->get_result();
					//$reAccRs = mysqli_query($reACCSQL);
					$reAcc = "";
					$linkToReacc = "";
					while ($rArow = mysqli_fetch_array($reAccRs)){
						if ($rArow['Institutions_application_reaccreditation_id'] > 0){
							//tmpSettingsReacc for link to Re-accredit application and insitutional profile
							$tmpSettingsReacc = "PREV_WORKFLOW=11%7C154&DBINF_HEInstitution___HEI_id=".$row["institution_id"]."&DBINF_institutional_profile___institution_ref=".$row["institution_id"]."&DBINF_Institutions_application_reaccreditation___Institutions_application_reaccreditation_id=".$rArow["Institutions_application_reaccreditation_id"];
							$reAcc = 'Reacc' . $rArow["reacc_submission_date"] . ' ';
							$linkToReacc .= '<a href="javascript:winPrintReaccApplicForm(\'Re-accreditation Application Form\',\''.$rArow['Institutions_application_reaccreditation_id'].'\', \''.base64_encode($tmpSettingsReacc).'\', \'\');">'.$reAcc.'</>' ;
						}
					}
					
					$submission_date = $row["submission_date"];
					$app_status = "";

					if ($row["application_status"] == -1 || $row["application_status"] == 9){
						$app_status = $this->getValueFromTable("lkp_application_status","lkp_application_status_id",$row["application_status"],"lkp_application_status_desc");
					}
					if ($row["withdrawn_ind"] == 1){
						$app_status .= "-withdrawn";
					}
					
					// Get screening id for this application
					$screen_id = $this->getValueFromTable("screening","application_ref",$app_id,"screening_id");

					// For checking if checklisting is complete.  Value in table implies that process has been done.
					// User can answer yes or no to the question.
					//$checklist = $this->getValueFromTable('screening_completion','screening_ref',$screen_id,'yes_no');

					// For checking if screening process has been done.  On the last screening page there is a checklist
					// of whether each criteria has been complied with.  If the screening_compliance table has values in it
					// for this application then assume that screening is done.
					$screen_ind = $this->getValueFromTable('screening_compliance','screening_ref',$screen_id,'regulation_ref');
			
					//2017-04-13 Richard: Changed to look at screened_date as audit finding due to crosses on report
					if ($screen_ind == ""){
$procsql=<<<PROCEEDING
						SELECT DISTINCT screened_date 
							FROM ia_proceedings 
							WHERE lkp_proceedings_ref = 1 AND application_ref = ?
PROCEEDING;

                                                $stmt = $conn->prepare($procsql);
                                                $stmt->bind_param("s", $app_id);
                                                $stmt->execute();
                                                $proceedingrs = $stmt->get_result();
						
						//$proceedingrs = mysqli_query($procsql) or die(mysqli_error());
						if ($proceedingrs){	
							$proc_row = mysqli_fetch_array($proceedingrs);
							$screened_date = $proc_row["screened_date"];
							if ($screened_date <> "" && $screened_date <> "1000-01-01"){
								$screen_ind = 1;
							} else {
								$screen_ind = 0;
							}
						}
					}
					$screening = ($screen_ind >= 1) ? $check . ' ' : $cross;

					$process = '-';
					if ($s_displayProcess == 1){
						$proc_arr = $this->getActiveProcessforApp($app_id);
						$process =  '(<span class="specialsi">'. $proc_arr['name'] .'</span>)';
					}
					//$process = '';

					$invoice_date = $notapplic;
					$recv_confirm = $notapplic;
					
					// Only private applications have payment information
					// 2013-11-25 robin: Display payment information if there is payment information
					//if (strpos($row["CHE_reference_code"],"/PR") > 0){  // Private applications
					$app_pay_data = $this->getPayData($app_id, "application_ref");			
					if (count($app_pay_data) > 0){	
						if (strpos($row["CHE_reference_code"],"/K") > 0){  // Re-accreditation applications needed an application loaded with core details. Gave them reference numbers containing a K.
							$invoice_date = $historic;
							$recv_confirm = $historic;
						}else{
							$invoice_date = "";
							$recv_confirm = "";
							foreach($app_pay_data as $app_pay){								
								$invoice_sent = ($app_pay["invoice_sent"] == 1) ? $check . ' ' : $cross;
								$invoice_date .= (($app_pay["date_invoice"] > '1000-01-01') ? $app_pay["date_invoice"] : $invoice_sent) . "<br/>";
								$recv_confirm .= (($app_pay["received_confirmation"] == 1) ? ($app_pay["date_payment"] > '1000-01-01 00:00:00' ? $app_pay["date_payment"] : $check . "(paid)") : (($app_pay["date_cancelled"] > '1000-01-01') ? "cancelled-" . $app_pay["date_cancelled"] : $cross . "(not paid)")) . "<br/>";
							}
						}
					}

					// Get values for evaluation
					// 1. Get evaluators appointed for this application
					$criteria = array("(evalReport_status_confirm = 1 OR evalReport_doc > 0)");  // Evaluators has confirmed that he will evaluate this application
					$a_evals = $this->getSelectedEvaluatorsForApplication($app_id, $criteria, "Accred", "evalReport_id");

					$evaluator_sel = "";
					$eval_appoint_date = "";

					// Get evaluators evaluation report due date.  This co-incides with the evaluator access portal end date.  They may no longer have access
					// once there report is due.  They need access while doing their report.  The date is specified per application.
					$eval_report_due = "";
					
					foreach ($a_evals as $a_eval){
						$erpt_ind = 0;
						if ($a_eval['evalReport_doc'] > 0){
							$erpt_ind = 1;
						}
						
						$eval_appoint_date .= ($a_eval["evalReport_date_sent"] > '1000-01-01') ? $a_eval["evalReport_date_sent"]."<br>" : "-<br>";

						// If the evaluator has completed the report display completion date as due. Due date can change as new reports 
						// are required for this application.
						if ($a_eval["evalReport_date_completed"] > '1000-01-01'){
							$e_report_due = $a_eval["evalReport_date_completed"];
						} else {
							$e_report_due = formatDate($row["evaluator_access_end_date"],$erpt_ind);
						}

						if ($a_eval['evalReport_doc'] > 0){
							$eval_octoDoc = new octoDoc($a_eval['evalReport_doc']);
							$e_report_due	 = "<a href='".$eval_octoDoc->url()."' target='_blank'>".$e_report_due."</a>";
						}
						$eval_report_due .= $e_report_due . '<br>';
						
						$eval_name = $a_eval['Surname'];
						if ($a_eval["eval_contract_doc"] > 0){
							$cDoc = new octoDoc($a_eval["eval_contract_doc"]);
							$eval_name	 = "<a href='".$cDoc->url()."' target='_blank'>".$a_eval['Surname']."</a>";
						}
						$evaluator_sel .= $eval_name.'<br>';
					}
					$evaluator_sel = ($evaluator_sel == "") ? '&nbsp;' : $evaluator_sel;
					$eval_appoint_date = ($eval_appoint_date == "") ? '&nbsp;' : $eval_appoint_date;
					$eval_report_due = ($eval_report_due == "") ? '&nbsp;' : $eval_report_due;
					
					$dir_recomm = $cross;
					if ($row["secretariat_doc"] > 0){
						$dir_recomm_doc = new octoDoc($row["secretariat_doc"]);
						$dir_recomm	 = "<a href='".$dir_recomm_doc->url()."' target='_blank'>".$dir_recomm_doc->getFilename()."</a>";
					}
					
					//$ac_meeting_date = ($row["AC_Meeting_date"] > '1000-01-01') ? $row["AC_Meeting_date"] : $cross;
					$ac_meeting_date =  $row["AC_Meeting_date"];

					if ($row["AC_desision"] > 0){
						$d_outcome = $this->getValueFromTable('lkp_desicion','lkp_id',$row["AC_desision"],'lkp_title');
						if ($row["AC_conditions_doc"] > 0){
							$out_octoDoc = new octoDoc($row["AC_conditions_doc"]);
							$d_outcome	 = "<a href='".$out_octoDoc->url()."' target='_blank'>".$d_outcome."</a>";
						}
					}else{
						$d_outcome = "&nbsp;";
					};

					$app_defer_doc = $app_condition_doc = $app_repr_doc = "&nbsp";
					$app_defer_octoDoc = $app_condition_octoDoc = $app_repr_octoDoc = '';
					if ($row["deferral_doc"] > 0){
						$app_defer_octoDoc = new octoDoc($row["deferral_doc"]);
						$app_defer_doc = "<a href='".$app_defer_octoDoc->url()."' target='_blank'>".$app_defer_octoDoc->getFilename()."</a>";
					}
					if ($row["condition_doc"] > 0){
						$app_condition_octoDoc = new octoDoc($row["condition_doc"]);
						$app_condition_doc = "<a href='".$app_condition_octoDoc->url()."' target='_blank'>".$app_condition_octoDoc->getFilename()."</a>";
					}
					if ($row["representation_doc"] > 0){
						$app_repr_octoDoc = new octoDoc($row["representation_doc"]);
						$app_repr_doc = "<a href='".$app_repr_octoDoc->url()."' target='_blank'>".$app_repr_octoDoc->getFilename()."</a>";
					}					
					
					$app_doc_basket = "&nbsp;";
					$docs_arr = $this->getApplicationDocs($app_id);
					foreach($docs_arr as $d){
						$app_doc_basket .= "<br />" . $d;
					}

					
					$withdrawn_decision_date=$row['withdrawn_decision_date'];
					$withdrawn_decision=$row['withdrawn_decision_ref'];
                                        $withdrawn_decision = ($withdrawn_decision > 0) ? $this->getValueFromTable("lkp_desicion", "lkp_id", $withdrawn_decision, "lkp_title") : "";
					
					$html .= <<<HTML
						<tr>
							<td class="saphireframe"><a href='$link1'><img src="images/ico_change.gif"></a></td>
							<td class="saphireframe"><span class="specials">$link2</span></td>
							<td class="saphireframe"><span class="specials">$applicationLink<br>$linkToReacc</span></td>
							<td class="saphireframe"><span class="specials">$programName</span></td>
							<td class="saphireframe"><span class="specials">$mode_deliveryDesc</span></td>
							<td class="saphireframe"><span class="specials">$submission_date</span></td>
							<td class="saphireframe"><span class="specials">$app_status $process</span></td>
							<td class="saphireframe"><span class="specials">$invoice_date</span></td>
							<td class="saphireframe"><span class="specials">$recv_confirm</span></td>
							<td class="saphireframe"><span class="specials">$screening</span></td>
							<td class="saphireframe"><span class="specials">$eval_appoint_date</span></td>
							<td class="saphireframe"><span class="specials">$eval_report_due</span></td>
							<td class="saphireframe"><span class="specials">$evaluator_sel</span></td>
							<td class="saphireframe"><span class="specials">&nbsp;</span></td>
							<td class="saphireframe"><span class="specials">$dir_recomm</span></td>
							<td class="saphireframe"><span class="specials">&nbsp;</span></td>
							<td class="saphireframe"><span class="specials">$ac_meeting_date</span></td>
							<td class="saphireframe"><span class="specials">&nbsp;</span></td>
							<td class="saphireframe"><span class="specials">$app_defer_doc</span></td>
							<td class="saphireframe"><span class="specials">&nbsp;</span></td>
							<td class="saphireframe"><span class="specials">$d_outcome</span></td>
							<td class="saphireframe"><span class="specials">$app_doc_basket</span></td>
							<td class="saphireframe"><span class="specials">&nbsp;</span></td>
							<td class="saphireframe"><span class="specials">$app_condition_doc</span></td>
							<td class="saphireframe"><span class="specials">&nbsp;</span></td>
							<td class="saphireframe"><span class="specials">$app_repr_doc</span></td>
					                <td class="saphireframe"><span class="specials">$withdrawn_decision</span></td>
                                                        <td class="saphireframe"><span class="specials">$withdrawn_decision_date</span></td>
						</tr>
HTML;
					
					$psql = <<<PROCEEDINGS
					SELECT *
					FROM ia_proceedings
					LEFT JOIN lkp_proceedings ON lkp_proceedings_id = lkp_proceedings_ref
					LEFT JOIN lkp_application_status ON lkp_application_status.lkp_application_status_id = ia_proceedings.application_status_ref
					LEFT JOIN AC_Meeting ON AC_Meeting.ac_id = ia_proceedings.ac_meeting_ref
					LEFT JOIN HEQC_Meeting ON HEQC_Meeting.heqc_id = ia_proceedings.heqc_meeting_ref
					WHERE ia_proceedings.application_ref = ?
					ORDER BY submission_date
PROCEEDINGS;
                                        $stmt = $conn->prepare($psql);
                                        $stmt->bind_param("s", $app_id);
                                        $stmt->execute();
                                        $prs = $stmt->get_result();
						
						
					//$prs = mysqli_query($psql) or die(mysqli_error());
					if ($prs){
						while ($prow = mysqli_fetch_array($prs)){
						
							$app_proc_id = $prow["ia_proceedings_id"];
							$aplink = "&nbsp;";
							// 2011-09-09 Robin: Allow users to edit whether or not it is closed.
							//if ($prow["proceeding_status_ind"] == 0){ // Only editable if proceedings has not closed.
								$plink = $this->scriptGetForm ('ia_proceedings', $app_proc_id, '_startEditProceedings');
								$aplink = "<a href='".$plink."'>Edit</a>";
							//}
							$p_submission_date = "&nbsp;";
							if ($prow["submission_date"] > '1000-01-01'){
								$p_submission_date = $prow["submission_date"];
							}
							$p_status = "&nbsp;";
							//$p_status = $prow[lkp_application_status_desc]; // Not necessary to display. Status used more for internal processing.
							$p_invoice_date = "&nbsp;";
							$p_recv_confirm = "&nbsp;";
							$p_pay_data = $this->getPayData($app_proc_id, "ia_proceedings_ref");
							if (count($p_pay_data) > 0){	
								foreach($p_pay_data as $p_pay){
									$p_invoice_date = $p_pay["date_invoice"] . "<br/>";
									$p_recv_confirm .= (($p_pay["received_confirmation"] == 1) ? $check . "(paid)" . ($p_pay["date_payment"] > '1000-01-01 00:00:00' ? ' '.$p_pay["date_payment"] :'') : (($p_pay["date_cancelled"] > '1000-01-01') ? "cancelled-" . $p_pay["date_cancelled"] : $cross . "(not paid)")) . "<br/>";
								}
							}
								
							$p_screening = "&nbsp;";
						
							if ($prow["checklist_final_doc"] > 0){
								$checklist_final_dc = new octoDoc($prow["checklist_final_doc"]);
								$checklist_final_doc	 = "<a href='".$checklist_final_dc->url()."' target='_blank'>Final Checklisting Report </a>";
							}else{
							
							  $checklist_final_doc="&nbsp;";
							}
							
							$criteria = array("(evalReport_status_confirm = 1 OR evalReport_doc > 0)");  // Evaluators has confirmed that he will evaluate this application
							$pevals = $this->getSelectedEvaluatorsForApplication ($app_proc_id, $criteria, "Proceedings");

							$p_eval_appoint_date = "&nbsp;";
							$p_eval_report_due = "&nbsp;";
							$p_evaluator_sel = "&nbsp;";
							
							if (count($pevals) > 0){
								$p_eval_appoint_date_arr = array();
								$p_eval_report_due_arr = array();
								$p_evaluator_sel_arr = array();
								
								$p_eval_appoint_date = "";
								foreach($pevals as $pe){
									$p_erpt_ind = 0;
									if ($pe['evalReport_doc'] > 0){
										$p_erpt_ind = 1;
									}
								
									$p_eval_appoint_date = ($pe["evalReport_date_sent"] > '1000-01-01') ? $pe["evalReport_date_sent"] : "&nbsp;";
									$p_eval_appoint_date = ($p_eval_appoint_date == "") ? '&nbsp;' : $p_eval_appoint_date;
									array_push($p_eval_appoint_date_arr, $p_eval_appoint_date);

									$dt_completed = ($pe['evalReport_date_completed'] > '1000-01-01') ? $pe['evalReport_date_completed'] : formatDate($prow["evaluator_access_end_date"],$p_erpt_ind);
									$eval_link = $dt_completed;
									if ($pe["evalReport_doc"] > 0){
										$evalDoc = new octoDoc($pe["evalReport_doc"]);
										$eval_link	 = "<a href='".$evalDoc->url()."' target='_blank'>".$dt_completed."</a>";
									}
									array_push($p_eval_report_due_arr, $eval_link);
									$contract_link = $pe['Surname'];
									if ($pe["eval_contract_doc"] > 0){
										$cDoc = new octoDoc($pe["eval_contract_doc"]);
										$contract_link	 = "<a href='".$cDoc->url()."' target='_blank'>".$pe['Surname']."</a>";
									}
									array_push($p_evaluator_sel_arr, $contract_link);						
								}
								
								$p_eval_appoint_date = implode('<br>',$p_eval_appoint_date_arr);
								$p_eval_report_due = implode('<br>',$p_eval_report_due_arr);
								$p_evaluator_sel = implode('<br>',$p_evaluator_sel_arr);
							}
							
							$p_dir_recomm = $cross;
							$p_dir_recomm_ind = 0;
							if ($prow["recomm_doc"] > 0){
								$p_dir_recomm_doc = new octoDoc($prow["recomm_doc"]);
								$p_dir_recomm	 = "<a href='".$p_dir_recomm_doc->url()."' target='_blank'>".$p_dir_recomm_doc->getFilename()."</a>";
								$p_dir_recomm_ind = 1;
							}else{
							
							  $p_dir_recomm="&nbsp;";
							}

							$p_recomm_access_due_date = formatDate($prow["recomm_access_end_date"], $p_dir_recomm_ind);
							$p_ac_meeting_date = ($prow["ac_start_date"] > "") ? $prow["ac_start_date"] : "&nbsp;";
							$p_heqc_meeting_date = ($prow["heqc_start_date"] > "") ? $prow["heqc_start_date"] : "&nbsp;";
							$decision = $prow["heqc_board_decision_ref"];
							$decision_due_date = $prow["heqc_decision_due_date"];
							$prior_due_date = $prow["condition_prior_due_date"];
							$short_due_date = $prow["condition_short_due_date"];
							$long_due_date = $prow["condition_long_due_date"];
							$view_backg_cond = "&nbsp;";
							
							// 2017-08-02 Richard: include applic_background, applic_background_ac or applic_background_heqc 
							if (($prow["applic_background"] > "")||($prow["applic_background_ac"] > "")||($prow["applic_background_heqc"] > "")){
								$view_backg_cond = "<a href='pages/backgroundsForProceedings.php?id=".base64_encode($app_proc_id)."' target='_blank'>Background</a>";
							}
							//if ($prow['lkp_proceedings_ref'] == 4){
							// 2017-10-16 Richard: include conditions for conditional re-accred
							if (($prow['lkp_proceedings_ref'] == 4) || ($prow['lkp_proceedings_ref'] == 6)){
								$view_backg_cond .= "<br><a href='pages/conditionsForProceedings.php?id=".base64_encode($app_proc_id)."' target='_blank'>Conditions</a>";
							}
							$defer_due_date = $condition_due_date = $representation_due_date = "&nbsp;";
							$p_heqc_outcome = "&nbsp;";
							$defer_doc = $condition_doc = $repr_doc = "&nbsp";
							$defer_doc_ind = $condition_doc_ind = $repr_doc_ind = 0;
							$defer_octoDoc = $condition_octoDoc = $repr_octoDoc = '';
							$p_decision_octoDoc = new octoDoc($prow["decision_doc"]);
							$p_decision_doc = "<a href='".$p_decision_octoDoc->url()."' target='_blank'>".$p_decision_octoDoc->getFilename()."</a>";
							if ($prow["deferral_doc"] > 0){
								$defer_octoDoc = new octoDoc($prow["deferral_doc"]);
								$defer_doc = "<a href='".$defer_octoDoc->url()."' target='_blank'>".$defer_octoDoc->getFilename()."</a>";
								$defer_doc_ind = 1;
							}
							if ($prow["condition_doc"] > 0){
								$condition_octoDoc = new octoDoc($prow["condition_doc"]);
								$condition_doc = "<a href='".$condition_octoDoc->url()."' target='_blank'>".$condition_octoDoc->getFilename()."</a>";
								$condition_doc_ind = 1;
							}
							if ($prow["representation_doc"] > 0){
								$repr_octoDoc = new octoDoc($prow["representation_doc"]);
								$repr_doc = "<a href='".$repr_octoDoc->url()."' target='_blank'>".$repr_octoDoc->getFilename()."</a>";
								$repr_doc_ind = 1;
							}
							if ($decision > 0){
								$p_heqc_outcome = $this->getValueFromTable('lkp_desicion','lkp_id',$prow["heqc_board_decision_ref"],'lkp_title');
								if ($prow["decision_doc"] > 0){
									$p_octoDoc = new octoDoc($prow["decision_doc"]);
									$p_heqc_outcome	 = "<a href='".$p_octoDoc->url()."' target='_blank'>".$p_heqc_outcome."</a>";
								}
								// Get due dates
								if ($decision == 4){ 
									$defer_due_date = formatDate($decision_due_date,$defer_doc_ind);
								}
								if ($decision == 2){ 
									$condition_due_date = formatDate($decision_due_date, $condition_doc_ind);
									if ($prior_due_date > '1000-01-01'){
										$condition_due_date .= '<br>' . formatDate($decision_due_date, $condition_doc_ind) . '&nbsp;(Prior)';
									}
									if ($short_due_date > '1000-01-01'){
										$condition_due_date .= '<br>' . formatDate($decision_due_date, $condition_doc_ind) . '&nbsp;(Short)';
									}
									if ($long_due_date > '1000-01-01'){
										$condition_due_date .= '<br>' . formatDate($decision_due_date, $condition_doc_ind) . '&nbsp;(Long)';
									}
								}
								if ($decision == 3){
									$representation_due_date = formatDate($decision_due_date, $repr_doc_ind);
								}
							}
							// 2017-07-20 Richard: Changed to display re-accred if re-accred proceedings
							$app_doc_basket = "&nbsp;";
							if ($prow['lkp_proceedings_ref'] == 5){
								$reaccred_id = $prow["reaccreditation_application_ref"];
								$reaccDocs = "SELECT * FROM reaccred_document_process WHERE reaccred_programme_ref=?";
	
                                                                $stmt = $conn->prepare($reaccDocs);
                                                                $stmt->bind_param("s", $reaccred_id);
                                                                $stmt->execute();
                                                                $rsDocs = $stmt->get_result();
								//$rsDocs = mysqli_query($reaccDocs);
					
								if (mysqli_num_rows($rsDocs) > 0) {
									while ($row = mysqli_fetch_array($rsDocs)) {
										$title = $row["reaccred_document_title"];
										$doc_ref = $row["reaccred_document_ref"];
										$document = new octoDoc($doc_ref);
										if ($document->url() > ''){
											$app_doc_basket .= "<br />" . "<a href='".$document->url()."' target='_blank'>".$title."</a>";
										} else {
											$docLink = $title;
										}
									}
								} 
							} 
							// 2011-09-09 Robin: No data captured for this yet.  Capture will be in phase 2
							//$representation_submission_date = $prow["representation_submission_date"];
							// 							<td class="saphireframe"><span class="specials">$representation_submission_date</span></td>
							
							$html .= <<<HTML
							<tr>
							<td class="saphireframe">&nbsp;</td>
							<td class="saphireframe">$aplink</td>
							<td class="saphireframe" colspan="3"><span class="specials"><b>Proceedings: </b>$prow[lkp_proceedings_desc]</span></td>
							<td class="saphireframe"><span class="specials">$p_submission_date</span></td>
							<td class="saphireframe"><span class="specials">$p_status</span></td>
							<td class="saphireframe"><span class="specials">$p_invoice_date</span></td>
							<td class="saphireframe"><span class="specials">$p_recv_confirm</span></td>
							<td class="saphireframe"><span class="specials">$p_screening  <br> $checklist_final_doc</span></td>
							<td class="saphireframe"><span class="specials">$p_eval_appoint_date</span></td>
							<td class="saphireframe"><span class="specials">$p_eval_report_due</span></td>
							<td class="saphireframe"><span class="specials">$p_evaluator_sel</span></td>
							<td class="saphireframe"><span class="specials">$p_recomm_access_due_date</span></td>
							<td class="saphireframe"><span class="specials">$p_dir_recomm</span></td>
							<td class="saphireframe"><span class="specials">$view_backg_cond</span></td>
							<td class="saphireframe"><span class="specials">$p_ac_meeting_date</span></td>
							<td class="saphireframe"><span class="specials">$defer_due_date</span></td>
							<td class="saphireframe"><span class="specials">$defer_doc</span></td>
							<td class="saphireframe"><span class="specials">$p_heqc_meeting_date</span></td>
							<td class="saphireframe"><span class="specials">$p_heqc_outcome</span></td>
							<td class="saphireframe"><span class="specials">$p_decision_doc<br>$app_doc_basket</span></td>
							<td class="saphireframe"><span class="specials">$condition_due_date</span></td>
							<td class="saphireframe"><span class="specials">$condition_doc</span></td>
							<td class="saphireframe"><span class="specials">$representation_due_date</span></td>
							<td class="saphireframe"><span class="specials">$repr_doc</span></td>
							<td class="saphireframe"><span class="specials">$withdrawn_decision_ref</span></td>
							<td class="saphireframe"><span class="specials">$withdrawn_decision_date</span></td>
							</tr>
HTML;
						}
					}
				}
			}
			$html .= <<<HTMLFOOT
					</td>
				</tr>
				</table>
HTMLFOOT;
	
			echo $html;
	
			?>
		</td>
	</tr>
	</table>
<?php 
}
?>
<hr>
<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2">
<tr>
	<td>
	Guidelines for searching:
	<ul>
		<li>applications submitted to CHE <b>from a certain date</b>, enter the date in the "From:" date field.</li>
		<li>all applications submitted <b>up until a certain date</b>, enter the date in the "To:" date field.</li>
		<li>applications submitted in a certain <b>date range</b>, fill in both the "From" or "To" submission date fields.</li>
		<li>a <b>specific HEQC reference number</b>, enter either all or part of the reference number in the relevant field. In this way, you are able to search for all applications submitted by a specific institution - by entering the reference code of the institution (e.g. PR064).</li>
		<li>a <b>specific institution</b>, select the insitution from the drop down list.</li>
		<li><b>ALL applications</b> submitted through the HEQC-online system, click "Search" without entering anything into any of the fields.</li>
	</ul>
	Please note that the applications are sorted according to HEQC reference number.
	<br><br>
	</td>
</tr>
</table>
<hr>
