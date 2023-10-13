<?php

$this->title		= "CHE Accreditation";
$this->bodyHeader	= "formHead";
$this->body			= "accForm1_v2";
$this->bodyFooter	= "formFoot";
$this->NavigationBar	= "<span class=pathdesc>Institution Information</span>";

$this->formHidden["FLD_user_ref"] = $this->currentUserID;
$this->formHidden["DELETE_RECORD"] = "";
$this->formOnSubmit = "return checkFrm(this);";

$prov_type = $this->getValueFromTable("HEInstitution", "HEI_id", $this->getValueFromTable("users", "user_id", $this->currentUserID, "institution_ref"), "priv_publ");
$app_id = $this->dbTableInfoArray["Institutions_application"]->dbTableCurrentID;
$app_type = $this->getValueFromTable("Institutions_application", "application_id", $app_id, "application_type");


$this->scriptHead .= "\n\n";
$this->scriptHead .= "function isInteger (str) {\n";
$this->scriptHead .= "	var regexp = /(^-?\d\d*$)/;"."\n";
$this->scriptHead .= "	return regexp.test(str);\n";
$this->scriptHead .= "}\n\n";

$this->scriptTail .= "\n\n";
$this->scriptTail .= "function checkFrm(obj) {\n";
$this->scriptTail .= "	var flag = false;\n";
$this->scriptTail .= "	var count = 0;\n";
$this->scriptTail .= "	if (obj.MOVETO.value == 'next') {\n";
$this->scriptTail .= "		for (j=0; j<obj.FLD_prog_type.length; j++) {\n";
$this->scriptTail .= "			if ((obj.FLD_prog_type[j].checked)) {\n";
$this->scriptTail .= "				flag = true;\n";
$this->scriptTail .= "			}\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (!(flag)) {\n";
$this->scriptTail .= "			alert('Please select a programme type.');\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (obj.FLD_senate_approved.value != 2) {\n";
$this->scriptTail .= "			alert('The programme must be approved by an institutional structure.');\n";
$this->scriptTail .= "			document.defaultFrm.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if ((document.defaultFrm.FLD_senate_approved_date.value == '') || (document.defaultFrm.FLD_senate_approved_date.value == '1970-01-01')) {\n";
$this->scriptTail .= "			alert('Please enter the date of institutional structure approval');\n";
$this->scriptTail .= "			document.defaultFrm.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (obj.FLD_designation.value == '') {\n";
$this->scriptTail .= "			alert('Please enter the qualification designation.');\n";
$this->scriptTail .= "			obj.FLD_designation.focus();\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (obj.FLD_1st_qualifier.value == '') {\n";
$this->scriptTail .= "			alert('Please enter the first qualifier.');\n";
$this->scriptTail .= "			obj.FLD_1st_qualifier.focus();\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (obj.FLD_2nd_qualifier.value == '') {\n";
$this->scriptTail .= "			alert('Please enter the second qualifier.');\n";
$this->scriptTail .= "			obj.FLD_2nd_qualifier.focus();\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (obj.FLD_CESM_code1.options[obj.FLD_CESM_code1.selectedIndex].value == 0) {\n";
$this->scriptTail .= "			alert('Please select a CESM category.');\n";
$this->scriptTail .= "			obj.FLD_CESM_code1.focus();\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (obj.FLD_NQF_ref.options[obj.FLD_NQF_ref.selectedIndex].value == 0) {\n";
$this->scriptTail .= "			alert('Please select an NQF level.');\n";
$this->scriptTail .= "			obj.FLD_NQF_ref.focus();\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if ((obj.FLD_num_credits.value == '') || (!isInteger(obj.FLD_num_credits.value))) {\n";
$this->scriptTail .= "			alert('Please enter the number of credits - digits only.');\n";
$this->scriptTail .= "			obj.FLD_num_credits.focus();\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		if (! checkCredits(obj.FLD_num_credits) ) {\n";
$this->scriptTail .= "			obj.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";


if ($prov_type == 1) {
	$this->scriptTail .= "	if (obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 0) {\n";
	$this->scriptTail .= "		alert('Please select the status of the programme registration with DoE.');\n";
	$this->scriptTail .= "		obj.FLD_is_reg_doe.focus();\n";
	$this->scriptTail .= "		obj.MOVETO.value = '';\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if ((obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 2) && (obj.FLD_doe_reg_nr.value == '')) {\n";
	$this->scriptTail .= "		alert('Please enter your DoE registration number.');\n";
	$this->scriptTail .= "		obj.FLD_doe_reg_nr.focus();\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if ((obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 2) && (obj.FLD_doe_registration_certificate_doc.value == '0')) {\n";
	$this->scriptTail .= "		alert('Please upload the DOE registration certificate.');\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if ((obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 3) && (obj.FLD_doe_appl_date.value == '1970-01-01')) {\n";
	$this->scriptTail .= "		alert('Please enter the date when application was made to DoE.');\n";
	$this->scriptTail .= "		obj.FLD_doe_appl_date.focus();\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "		if (obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 0) {\n";
	$this->scriptTail .= "			alert('Please select the status of the programme registration with SAQA.');\n";
	$this->scriptTail .= "			obj.FLD_is_reg_saqa_nqf.focus();\n";
	$this->scriptTail .= "			obj.MOVETO.value = '';\n";
	$this->scriptTail .= "			return false;\n";
	$this->scriptTail .= "		}\n";
	$this->scriptTail .= "		if ((obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 2) && (obj.FLD_saqa_reg_nr.value == '')) {\n";
	$this->scriptTail .= "			alert('Please enter your SAQA registration number.');\n";
	$this->scriptTail .= "			obj.FLD_saqa_reg_nr.focus();\n";
	$this->scriptTail .= "			return false;\n";
	$this->scriptTail .= "		}\n";
	$this->scriptTail .= "		if ((obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 3) && (obj.FLD_saqa_appl_date.value == '1970-01-01')) {\n";
	$this->scriptTail .= "			alert('Please enter the date when application was made to SAQA.');\n";
	$this->scriptTail .= "			obj.FLD_saqa_appl_date.focus();\n";
	$this->scriptTail .= "			return false;\n";
	$this->scriptTail .= "		}\n";
	$this->scriptTail .= "	if ((obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 2) && (obj.FLD_saqa_registration_certificate_doc.value == '0')) {\n";
	$this->scriptTail .= "		alert('Please upload the required SAQA registration certificate.');\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
}

if ($prov_type == 2) {
	$this->scriptTail .= "	if ((obj.FLD_is_part_pqm.options[obj.FLD_is_part_pqm.selectedIndex].value == 1) && (obj.FLD_doe_pqm_lkp.options[obj.FLD_doe_pqm_lkp.selectedIndex].value == 1)) {\n";
	$this->scriptTail .= "		alert('You may not apply for accreditation without PQM approval.');\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if (obj.FLD_is_part_pqm.options[obj.FLD_is_part_pqm.selectedIndex].value == 0) {\n";
	$this->scriptTail .= "		alert('Please select whether the programme forms part of your institutionís approved PQM.');\n";
	$this->scriptTail .= "		obj.FLD_is_part_pqm.focus();\n";
	$this->scriptTail .= "		obj.MOVETO.value = '';\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if ((obj.FLD_is_part_pqm.options[obj.FLD_is_part_pqm.selectedIndex].value == 2) && (obj.FLD_doe_pqm_doc.value == '0')) {\n";
	$this->scriptTail .= "		alert('Please upload the DoE PQM approval document.');\n";
	$this->scriptTail .= "		return false;\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if (obj.FLD_is_part_pqm.options[obj.FLD_is_part_pqm.selectedIndex].value == 2) {\n";
	$this->scriptTail .= "		if (obj.FLD_doe_pqm_date.value == '1970-01-01') {\n";
	$this->scriptTail .= "			alert('Please enter the date when the PQM application was made to DoE.');\n";
	$this->scriptTail .= "			obj.FLD_doe_pqm_date.focus();\n";
	$this->scriptTail .= "			return false;\n";
	$this->scriptTail .= "		}\n";
	$this->scriptTail .= "	}\n";
	$this->scriptTail .= "	if (obj.FLD_is_part_pqm.options[obj.FLD_is_part_pqm.selectedIndex].value == 1) {\n";
	$this->scriptTail .= "		if (obj.FLD_doe_pqm_lkp.options[obj.FLD_doe_pqm_lkp.selectedIndex].value == 0) {\n";
	$this->scriptTail .= "			alert('Please select whether you have applied for PQM approval with the DoE for this programme.');\n";
	$this->scriptTail .= "			obj.FLD_doe_pqm_lkp.focus();\n";
	$this->scriptTail .= "			obj.MOVETO.value = '';\n";
	$this->scriptTail .= "			return false;\n";
	$this->scriptTail .= "		}\n";
	$this->scriptTail .= "		if (obj.FLD_doe_pqm_lkp.options[obj.FLD_doe_pqm_lkp.selectedIndex].value == 2) {\n";
	$this->scriptTail .= "			if (obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 0) {\n";
	$this->scriptTail .= "				alert('Please select the status of the programme registration with SAQA on the NQF.');\n";
	$this->scriptTail .= "				obj.FLD_is_reg_saqa_nqf.focus();\n";
	$this->scriptTail .= "				obj.MOVETO.value = '';\n";
	$this->scriptTail .= "				return false;\n";
	$this->scriptTail .= "			}\n";
	$this->scriptTail .= "			if ((obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 2) && (obj.FLD_saqa_reg_nr.value == '')) {\n";
	$this->scriptTail .= "				alert('Please enter your SAQA registration number.');\n";
	$this->scriptTail .= "				obj.FLD_saqa_reg_nr.focus();\n";
	$this->scriptTail .= "				return false;\n";
	$this->scriptTail .= "			}\n";
	$this->scriptTail .= "			if ((obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 3) && (obj.FLD_saqa_appl_date.value == '1970-01-01')) {\n";
	$this->scriptTail .= "				alert('Please enter the date when application was made to SAQA.');\n";
	$this->scriptTail .= "				obj.FLD_saqa_appl_date.focus();\n";
	$this->scriptTail .= "				return false;\n";
	$this->scriptTail .= "			}\n";
	$this->scriptTail .= "		}\n";
	$this->scriptTail .= "	}\n";
}

$this->scriptTail .= "		if ((document.defaultFrm.FLD_prog_start_date.value == '') || (document.defaultFrm.FLD_prog_start_date.value == '1970-01-01')) {\n";
$this->scriptTail .= "			alert('Please enter the date by which you plan to start offering the programme.');\n";
$this->scriptTail .= "			document.defaultFrm.MOVETO.value = '';\n";
$this->scriptTail .= "			return false;\n";
$this->scriptTail .= "		}\n";

if ($app_type == "reaccred"){
	$this->scriptTail .= "		if ((document.defaultFrm.FLD_date_first_student_intake.value == '') || (document.defaultFrm.FLD_date_first_student_intake.value == '1970-01-01')) {\n";
	$this->scriptTail .= "			alert('Please enter the date of the first intake of students.');\n";
	$this->scriptTail .= "			document.defaultFrm.MOVETO.value = '';\n";
	$this->scriptTail .= "			return false;\n";
	$this->scriptTail .= "		}\n";
}

$this->scriptTail .= "	}\n";
$this->scriptTail .= "	return true;\n";
$this->scriptTail .= "}\n";
$this->scriptTail .= "\n\n";

$this->scriptTail .= "function checkSelects() {\n";
$this->scriptTail .= "	var obj = document.defaultFrm;\n";
$this->scriptTail .= "	if (obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 1) {\n";
$this->scriptTail .= "		obj.FLD_is_reg_saqa_nqf.selectedIndex = 1;\n";
$this->scriptTail .= "		document.defaultFrm.FLD_doe_reg_nr.value = '';\n";
$this->scriptTail .= "		document.defaultFrm.FLD_doe_reg_nr.disabled = true;\n";
$this->scriptTail .= "	}\n";
$this->scriptTail .= "	if (obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 3) {\n";
$this->scriptTail .= "		if (obj.FLD_is_reg_saqa_nqf.selectedIndex == 2) {\n"
;$this->scriptTail .= "			alert('You cannot choose Yes here if you are not registered with DoE');\n";
$this->scriptTail .= "			obj.FLD_is_reg_saqa_nqf.selectedIndex = 0;\n";
$this->scriptTail .= "		}\n";
$this->scriptTail .= "		document.defaultFrm.FLD_doe_reg_nr.value = '';\n";
$this->scriptTail .= "		document.defaultFrm.FLD_doe_reg_nr.disabled = true;\n";
$this->scriptTail .= "	}\n";
$this->scriptTail .= "	if (obj.FLD_is_reg_doe.options[obj.FLD_is_reg_doe.selectedIndex].value == 2) {\n";
$this->scriptTail .= "		document.defaultFrm.FLD_doe_reg_nr.disabled = false;\n";
$this->scriptTail .= "		document.defaultFrm.FLD_doe_reg_nr.focus();\n";
$this->scriptTail .= "	}\n";

$this->scriptTail .= "	if (obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 1) {\n";
$this->scriptTail .= "		document.defaultFrm.FLD_saqa_reg_nr.value = '';\n";
$this->scriptTail .= "		document.defaultFrm.FLD_saqa_reg_nr.disabled = true;\n";
$this->scriptTail .= "	}\n";
$this->scriptTail .= "	if (obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 3) {\n";
$this->scriptTail .= "		document.defaultFrm.FLD_saqa_reg_nr.value = '';\n";
$this->scriptTail .= "		document.defaultFrm.FLD_saqa_reg_nr.disabled = true;\n";
$this->scriptTail .= "	}\n";
$this->scriptTail .= "	if (obj.FLD_is_reg_saqa_nqf.options[obj.FLD_is_reg_saqa_nqf.selectedIndex].value == 2) {\n";
$this->scriptTail .= "		document.defaultFrm.FLD_saqa_reg_nr.disabled = false;\n";
$this->scriptTail .= "	}\n";

$this->scriptTail .= "}\n";
$this->scriptTail .= "\n\n";

$this->scriptTail .= "\n\n";
$this->scriptTail .= "function checkCredits (obj) {\n";
$this->scriptTail .= "	if ((parseInt(obj.value) < 120) || (parseInt(obj.value) > 999)) {\n";
$this->scriptTail .= "		alert('Credits may only be between 120 and 999');\n";
$this->scriptTail .= "		obj.focus();\n";
$this->scriptTail .= "		return false;\n";
$this->scriptTail .= "	}\n";
$this->scriptTail .= "	return true;\n";
$this->scriptTail .= "}\n\n";
?>
