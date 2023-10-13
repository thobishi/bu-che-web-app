<?php echo $this->Form->input('HeqfQualification.id');?>
<?php
	echo $this->element('item_view/application', array('processData' => $this->data));
	
	if($this->data['HeqfQualification']['s1_error'] == 0 && $this->data['HeqfQualification']['s2_error'] == 0) {
		//TODO: Form for user to propose category
		/*echo '<div class="ui-state-error ui-corner-all">Need to add form here for user to propose category</div>';
		echo $this->Form->input('Application.proposed_category', array('label' => 'Proposed categorisation', 'options' => array(
			'A', 'B', 'C'
		)));*/
	}
?>