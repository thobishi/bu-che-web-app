<?php

$this->title		= "CHE Accreditation";
$this->bodyHeader	= "formHead";
$this->body			= "conditionFormRecomm";
$this->bodyFooter	= "formFoot";
$this->NavigationBar	= "<span class=pathdesc>Indicate whether conditions have been met> Data capture form</span>";

$this->formOnSubmit = "return checkFrm(document.defaultFrm);";

$this->scriptTail = <<< SCRIPTTAIL
	function checkFrm(obj) {
		if (document.defaultFrm.MOVETO.value == 'next')  {
			if (!valCheckboxRequired(obj.FLD_condition_confirm_ind,'Note: You may save without indicating that you have confirmed the evaluation of conditions.  However, please check the box when completed to indicate that to the CHE.'))	{return true};
		}
		return true;
	}
SCRIPTTAIL;
?>
