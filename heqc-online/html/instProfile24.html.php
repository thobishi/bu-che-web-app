<a name="application_form_question7"></a>
<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2"><tr><td>
<?php 
	$headArr = array();
	array_push($headArr, "");
	array_push($headArr, "Yes / No");
	array_push($headArr, "Comment");
	array_push($headArr, "Upload File");

//	$evalArr = array();
//	array_push($evalArr, "lkp_pol_budgets_post_grad_pol_desc");

	$fieldsArr = array();
//	array_push($fieldsArr, "yes_no");
//	array_push($fieldsArr, "comment_text");
	array_push($fieldsArr, "type__radio|name__yes_no|description_fld__lkp_yn_desc|fld_key__lkp_yn_id|lkp_table__lkp_yes_no|lkp_condition__lkp_yn_id!=0|order_by__lkp_yn_desc");
	array_push($fieldsArr, "type__textarea|name__comment_text");
?>
<br><br>
<b>7. POSTGRADUATE POLICIES AND PROCEDURES:</b>
<br><br>
<i><?php echo  $this->getDBsettingsValue("InstProfilePolMsgPostGrad"); ?></i>
<br><br>
<table width='95%' cellpadding='2' cellspacing='2' align='center' border='1'>
<?php 
	$this->gridShow("institutional_profile_pol_budgets_post_grad_pol", "institutional_profile_pol_budgets_post_grad_pol_id", "institution_ref__".$this->dbTableInfoArray["institutional_profile"]->dbTableCurrentID, $fieldsArr, $headArr, "lkp_pol_budgets_post_grad_pol", "lkp_pol_budgets_post_grad_pol_id", "lkp_pol_budgets_post_grad_pol_desc", "lkp_pol_budgets_post_grad_pol_ref", 1, 40, 10, true, "inst_uploadDoc");
	//$this->makeGRID("lkp_pol_budgets_post_grad_pol", $evalArr, "lkp_pol_budgets_post_grad_pol_id", "1", "institutional_profile_pol_budgets_post_grad_pol", "institutional_profile_pol_budgets_post_grad_pol_id", "lkp_pol_budgets_post_grad_pol_ref", "institution_ref", $this->dbTableInfoArray["institutional_profile"]->dbTableCurrentID, $fieldsArr, $headArr, "", "10", "40", "4", "", "", "", 1, 1);
?>
</table>
</td></tr></table>