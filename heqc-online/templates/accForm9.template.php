<?php

$this->title		= "CHE Accreditation";
$this->bodyHeader	= "formHead";
$this->body		= "accForm9";
$this->bodyFooter	= "formFoot";
$this->NavigationBar	= "<span class=pathdesc>Programme information > Programme design</span>";

$this->formOnSubmit = "return checkDocumentsSelected(5, ".$this->getValueFromTable("HEInstitution", "HEI_id", $this->getValueFromTable("users", "user_id", $this->currentUserID, "institution_ref"), "priv_publ").");";

$this->formHidden["DELETE_RECORD"] = "";
?>
