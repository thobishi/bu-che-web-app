<?php

$this->title		= "CHE Accreditation";
$this->bodyHeader	= "formHead";
$this->body			= "instSitePayment1";
$this->bodyFooter	= "formFoot";
$this->NavigationBar	= "<span class=pathdesc>Sites > Prepare for invoicing </span>";


$this->formOnSubmit = "return checkFrm();";

$this->scriptTail = <<<SCRIPTTAIL
	function checkFrm() {
		if (document.defaultFrm.MOVETO.value == 'next')  {
if (!valDocRequired(document.defaultFrm.FLD_invoicing_doc,'Please upload the  invoicing spreadsheet for this site application.'))		{return false;}
		
		
		//if (parseInt(document.defaultFrm.FLD_invoice_total.value) == 0  || document.defaultFrm.FLD_invoice_total.value =='' || document.defaultFrm.FLD_invoice_total.value ==null){
		//	alert('Please total amount to be invoiced ');
		//		return false;
		//}
		return true;
    }
	}
SCRIPTTAIL;

?>
