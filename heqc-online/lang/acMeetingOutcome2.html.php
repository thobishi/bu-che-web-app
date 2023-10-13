<?php
	$app_id = $this->dbTableInfoArray["Institutions_application"]->dbTableCurrentID;
	$app_proc_id = $this->dbTableInfoArray["ia_proceedings"]->dbTableCurrentID;
	$this->showInstitutionTableTop ();
	$report = $this->formatOutcomeHeader($app_proc_id);
?>
<table width="95%" border=0 align="center" cellpadding="2" cellspacing="2">
<tr>
	<td>
	<br>
		<span class="loud">Edit the AC meeting outcome and minutes for this application</span>
	</td>
</tr>
<tr>
	<td>
		<?php echo $report; ?>
	</td>
</tr>
<tr>
	<td>
		<?php $this->edit_outcomes("ac_decision_ref", $app_proc_id); ?>
	</td>
</tr>
<tr>
	<td><hr></td>
</tr>
<tr>
	<td>
	The following are the minutes taken at the AC meeting and the discussion that took place with respect to this application
	</td>
</tr>
<tr>
	<td>
	<?php $this->showField('minutes_discussion'); ?>
	</td>
</tr>
</table>
<br>