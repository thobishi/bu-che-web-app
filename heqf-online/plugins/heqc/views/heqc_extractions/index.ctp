<div class="dashboard">
<h1>Extract HEQC and SAQA data</h1>
<fieldset id="extractForm">
	<legend>Extract data for all HEQC applications for my institution</legend>
		Click on the following link to extract existing application data for your institution in HEQC-Online into an Excel spreadsheet.  The fields extracted will have the same column headings as the fields in the HEQSF alignment application spreadsheet.<br><br>
		<?php echo $html->link(__('Extract data for users institution', true), array('action' => 'extract_data', 'ext' => 'xlsx'));?>	
</fieldset>

<?php
	$this->set('sidebar', array(
		$this->Html->link('Return to list', array('plugin' => '', 'controller' => 'process', 'action' => 'list_process', 'process-slug' => 'application')),
	));
?>
</div>