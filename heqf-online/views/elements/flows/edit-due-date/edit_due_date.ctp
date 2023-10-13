<div class="modules form">

	<?php
		echo $this->Form->input('Application.id');
		
		$applicationStatus = $this->data['Application']['application_status'];
		if($applicationStatus == 'Review') {
			echo $this->Form->input('Application.review_due_date', array('label' => 'Review due date', 'type' => 'text'));
		}
		
		if($applicationStatus == 'Evaluation'){
			echo $this->Form->input('Evaluation.id');
			echo $this->Form->input('Evaluation.evaluation_due_date', array('label' => 'Evaluation due date', 'type' => 'text'));
		}

		if($applicationStatus == 'Proceeding'){
			echo $this->Form->input('ReviewProceeding.id');
			$procType = $this->Heqf->getProceedingTypeDesc($this->data['ReviewProceeding']['proceeding_type_id']);
			echo $this->Form->input('ReviewProceeding.proc_due_date', array('label' => $procType . ' due date', 'type' => 'text'));
		}
	?>
</div>
<?php echo $this->Html->script(array(
		'/js/application/due-date'
	));