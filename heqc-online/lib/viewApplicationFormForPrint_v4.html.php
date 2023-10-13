<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2">
<tr>
<td>
<?php 
	$this->showInstitutionTableTop ();
	$app_id = $this->dbTableInfoArray["Institutions_application"]->dbTableCurrentID;
?>
</td>
</tr>
</table>

<table width="95%" align="center">
	<tr>
		<td>
			<?php $this->displayPopulatedApplicationForm($app_id, "html"); ?>
		</td>
	</tr>
</table>

<?php 
	$settings = $this->getStringWorkFlowSettings($this->workFlow_settings);

	$forms = array ("accForm1_v4", "accForm2_v4", "accForm3-1_v4", "accForm3-2_v4", "accFormCreateUsersDescriptive_v2", "accForm5_v4");

function doOutPutBuffer ($buffer) {
	$h = fopen ("/tmp/che_mis_output.html", "w+");
	$search_array = array("/\<script\>.*\<\/script\>/sU", "/(\<a.*[^>]href=.*(?:openFileWin|changeCMD|winContentText.*).*\>)(.*)(\<\/a\>)/U");
	$replace_array = array("", "\\2");

	$html = $buffer;
	$html = preg_replace ($search_array, $replace_array, $buffer);

	fwrite($h, $html);

	return $html;
}

ob_start("doOutPutBuffer");

	foreach ($forms as $form) {
		$app = new HEQConline (1);
		$app->parseWorkFlowString($settings);
		$app->template = $form;
		$app->view = 1;
		$app->formStatus = FLD_STATUS_TEXT;
		$app->readTemplate();
		$app->createHTML($app->body);

		unset ($app);
	}
?>
	<!-- </td>
</tr>
</table> -->

<?php 
ob_end_flush();
?>
