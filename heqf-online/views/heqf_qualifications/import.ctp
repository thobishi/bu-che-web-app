<div class="dashboard">
	<?php
		echo $this->element('notice');
		echo $this->Form->create('HeqfQualification', array('type' => 'file', 'id' => 'HEQFQualification_importForm'));
	?>
		<fieldset id="uploadForm">
			<legend>Bulk Import</legend>
			<p class="infoText">Submit your completed spreadsheet by browsing to it and then clicking the "Upload" button:</p>
			<?php
					echo $this->Form->input('import_file', array('type' => 'file', 'label' => ''));
					echo $this->Form->hidden('browser');
					echo $this->Form->submit(__('Upload / Import', true), array('name' => 'saveNormal', 'div' => true, 'id' => 'importBut'));
			?>
		</fieldset>

		<p class="infoText">
			If you do not have a spreadsheet template yet, please download the template by clicking the  "Download template for bulk import" link under the Actions menu on the right. 
		</p>
	<?php echo $this->Form->end(); ?>
	
	<div id="waiting" class="waitingDivClass ui-helper-hidden"></div>
	<div id="completedDiv" class="ui-helper-hidden"></div>		
	<div id="loadingDiv" class="ui-helper-hidden"></div>
	<div id="progressbar" class="ui-helper-hidden"></div>
	<div id="validationReport" class="ui-helper-hidden"></div>
	<div id="errorMsg" title="ERROR">
	</div>
</div>
<div class="ui-helper-hidden" id="statusUrl"><?php echo $this->Html->url(array('action' => 'result', 'ext' => 'json')) ?></div>

<?php
	$this->Html->script('heqf_qualifications/import', array('inline' => false));

	$this->set('sidebar', array(
		$this->Html->link('Return to applications', array('plugin' => '', 'controller' => 'process', 'action' => 'list_process', 'process-slug' => 'application')),
		$this->Html->link('Re-import', array('action' => 'import', 'controller' => 'heqf_qualifications'), array('id' => 'reImportLink')),
		$this->Html->link('Accept', array('action' => 'saveData', 'controller' => 'heqf_qualifications'), array('id' => 'acceptLink')),
		$this->Html->link('Discard', array('action' => 'saveData', 'controller' => 'heqf_qualifications'), array('id' => 'discardLink')),
		$this->Html->link('Download report', '', array('id' => 'downloadLink')),
		$this->Html->link(__('Download template for bulk import', true), array('action' => 'download_template')),
		$this->Html->link('Download Revised HEQSF as of September 2011', array('controller' => 'pages', 'action' => 'download_help', 'revised'))
	));