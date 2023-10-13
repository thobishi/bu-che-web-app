<div class="dashboard">
	<?php
		$url = array();
		if (isset($this->params['named']['qual'])) {
			$url['qual'] = $this->params['named']['qual'];
		}
		echo $this->Form->create('HeqfQualificationModule', array('type' => 'file', 'id' => 'importForm', 'url' => $url));
	?>
		<fieldset id="uploadForm">
			<legend>Bulk Import for qualification modules</legend>
			<p class="infoText">Submit your completed spreadsheet by browsing to it and then clicking the "Upload" button:</p>
			<?php
					echo $this->Form->input('file', array('type' => 'file', 'label' => ''));
					echo $this->Form->hidden('browser');
					echo $this->Form->submit(__('Upload / Import', true), array('name' => 'saveNormal', 'div' => true, 'id' => 'importBut'));
			?>
		</fieldset>

		<p class="infoText">
			If you do not have a spreadsheet template yet, please download the template by clicking the  "Download template for bulk import" link under the Actions menu on the right. 
		</p>
	<?php echo $this->Form->end(); ?>
</div>

<div id="validationReport" class="ui-helper-hidden"></div>

<?php
	$this->Html->script('import', array('inline' => false));

	$sidebar[] = $this->Html->link('Download template for bulk import', array('action' => 'download_template', 'controller' => 'heqf_qualification_modules'));	
	$this->set('sidebar', $sidebar);	