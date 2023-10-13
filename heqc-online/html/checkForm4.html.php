<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2"><tr><td>
<?php $this->showInstitutionTableTop ()?>
<br>
<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2">
<?php 
	$isSent = 0;
	$app_id = $this->dbTableInfoArray["Institutions_application"]->dbTableCurrentID;

	$this->showField("doe_isSent_provider");
	$this->showField("doe_email_provider");
	$this->showField("doe_email_provider_count");
	$this->showField("doe_isSent_provider_date");

	$isSent = $this->getFieldValue("doe_isSent_provider");

	if (($isSent == 1) && (empty($_POST["send_message"]))) {
?>
<tr>
	<td><b>The message was already sent to the DoE on the following date: <?php echo $this->getFieldValue("doe_isSent_provider_date");?></b></td>
</tr><tr>
	<td>
	<br>If you'd like to resend the message, click the checkbox below:</td>
</tr><tr>
	<td>
		<script>
			function resendEmailMsg() {
				var obj = document.defaultFrm;
				var intCount = 0;
				intCount = parseInt(obj.FLD_doe_email_provider_count.value) + parseInt(1);
				obj.FLD_doe_email_provider_count.value = intCount;
				obj.FLD_doe_isSent_provider_date.value = "<?php echo $this->getCurrentDate()?>";
				moveto('stay');
			}
		</script>
	</td>
</tr><tr>
	<td>Force a resend of the message? <?php $this->showField("send_message") ?> &nbsp; <input type="button" class="btn" value="Resend" onClick="if (checkSendMessage(document.defaultFrm.send_message)) { resendEmailMsg(); }"></td>
</tr>
<?php 
	}
	if (($isSent == 1) && isset($_POST["send_message"])) {
		$re = "";
		if ($this->getFieldValue("doe_email_provider_count") > 1) {
			$re = "RE: ";
?>
<tr>
	<td>The message was resent successfully!</td>
</tr>
<?php 
		}

		if ($this->getFieldValue("doe_email_provider_count") == 1) {
?>
<tr>
	<td>Your message was sucessfully sent to DoE.</td>
</tr>
<?php 
		}
		if (empty($_POST["comments"]) || (!($_POST["comments"] > ""))) {
			$this->formFields["doe_email_provider"]->fieldValue = str_replace("Comments:<br />", "", $this->getFieldValue("doe_email_provider"));
		}
		/* Changed $email_message so that it gets the value from the database
		   before it checks to see if it is a resend.
		   If it is not a resend, it will still be sent via e-mail.
		*/
		$email_message = str_replace("<br />", "", $this->getFieldValue("doe_email_provider"));
		if ($re > "") {
			$email_message = str_replace("Application", $re."Application", $email_message);
		}
		$private_public = ($this->getValueFromTable("HEInstitution", "HEI_id", $this->getValueFromTable("Institutions_application", "application_id", $this->dbTableInfoArray["Institutions_application"]->dbTableCurrentID, "institution_id"), "priv_publ") == 1)?($this->getDBsettingsValue("current_doe_priv_user_id")):($this->getDBsettingsValue("current_doe_publ_user_id"));
		$this->misMail($private_public, "Registration of Private Provider with the DoE", $email_message, $this->getDBsettingsValue("che_registry_email"), true);
	}

	if (($isSent == 0) && (empty($_POST["send_message"]))) {
?>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><b>To continue the process you need to send the following e-mail to confirm that the private provider is registered with the DoE . Make sure that the information in the e-mail is correct and that you have included comments if necessary.</b></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="oncoloursoft">
	<fieldset>
	<legend><span class="specialb"><i>Message</i></span></legend>
<?php 
			$inst_id = $this->getValueFromTable("Institutions_application", "application_id", $app_id, "institution_id");
			$messageTop = $this->getTextContent ($this->template, "EmailDOE_private_part1");
			$messageTop = nl2br ($messageTop);
			echo $messageTop;
			echo 'Click <a href="javascript:showComments(document.all.commentsDiv)">here</a> to add comments'."<br />";
			echo '<div id="commentsDiv" style="display:none">';
			$messageComments = $this->getTextContent ($this->template, "EmailDOE_private_part2");
			$messageComments = nl2br ($messageComments);
			echo $messageComments;
			echo '</div>';
			$messageEnd = $this->getTextContent ($this->template, "EmailDOE_private_part3");
			$messageEnd = nl2br ($messageEnd);
			echo $messageEnd;

?>
	</fieldset>
</td>
</tr>
<tr><td>
	<script>
		function firstEmailMsg() {
			var obj = document.defaultFrm;
			obj.FLD_doe_email_provider.value = '<?php echo ((isset($messageTop))?($this->newGenerationAddcslashes($messageTop)):(""))?>';
			obj.FLD_doe_email_provider.value += obj.comments.value;
			obj.FLD_doe_email_provider.value += '<?php echo ((isset($messageEnd))?($this->newGenerationAddcslashes($messageEnd)):(""))?>';
			obj.FLD_doe_isSent_provider.value = 1;
			obj.FLD_doe_email_provider_count.value = 1;
			obj.FLD_doe_isSent_provider_date.value = "<?php echo $this->getCurrentDate()?>";
			moveto('stay');
		}

		function showComments(obj) {
			if (obj.style.display == "none") {
				obj.style.display = "Block";
			}else{
				obj.style.display = "none";
			}
		}
	</script>
</td></tr>
<tr>
	<td>Send message? &nbsp; <?php $this->showField("send_message") ?> &nbsp; <input type="button" class="btn" value="Send" onClick="if(checkSendMessage(document.defaultFrm.send_message)) {firstEmailMsg();}"></td>
</tr>
<tr>
	<td>To override this message check this box: <?php $this->showField("override_doe_send_message");?></td>
</tr>
<tr>
	<td>
		<div id="override_div" style="display:none">
		<table><tr>
			<td>Please provide a reason for overriding this message:<br>
			<?php $this->showField("override_message_doe_reason");?>
			</td>
		</tr></table>
		</div>
	</td>
</tr>
<?php 
	}
?>
</table>
</td></tr></table>
<script>
try {
	if ((document.defaultFrm.FLD_override_doe_send_message.checked) && (document.all.override_div.style.display = "none")) {
		showHide (document.all.override_div);
	}
}catch(e){}
</script>
