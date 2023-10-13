<fieldset>
	<legend><?php echo $currentProcess['Process']['name'] . ' - ' . $currentFlow['Flow']['name']?></legend>
	<?php
		$nextFlow = reset(Set::extract('/Flow[order>'.$currentFlow['Flow']['order'].']', $currentProcess));	
		
		if(!empty($nextFlow)) {
			$buttonText = 'Save and move to ' . $nextFlow['Flow']['name'];
			$formUrl = array(
				'action' => 'form', 
				'process-slug' => $currentProcess['Process']['slug'], 
				'flow-slug' => $currentFlow['Flow']['slug'], 
				'to-flow' => $nextFlow['Flow']['slug']
			);
		}
		else {
			$buttonText = 'Save and return to list';
			$formUrl = array(
				'action' => 'close', 
				'flow-slug' => $currentFlow['Flow']['slug'],
				'process-slug' => $currentProcess['Process']['slug']
			);
		}
		$processWithUpload = array(
			'upload-proceeding-document'
		);

		$formOptions = array(
			'id' => 'Process', 
			'url' => $formUrl
		);

		if (in_array($currentProcess['Process']['slug'], $processWithUpload)) {
			$formOptions['enctype'] = 'multipart/form-data';
		}
		
		echo $this->Form->create('Process', $formOptions);
		echo $this->Form->input($currentProcess['Process']['main_model'] . '.id', array('value' => $this->Session->read('process.id')));
		echo $this->element('flows/'.$currentProcess['Process']['slug'].'/'.$currentFlow['Flow']['slug']);
		echo '<div class="submit">';
			if(empty($nextFlow)) {
				echo $this->Form->input('saveForm', array('value' => true, 'type' => 'hidden', 'name' => 'saveForm'));
			}		
			echo $this->Form->button($buttonText, 
				array(
					'id' => 'moveButton',
					'value' => $this->Html->url($formUrl)
				)
			);
		echo '</div>';
		echo $this->Form->end();
	?>
</fieldset>