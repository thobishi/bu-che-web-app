<fieldset><legend>Filter report</legend>
<?php
	echo $this->Form->create($model, array('url' => $url, 'class' => 'search', 'id' => 'search'));
	
	echo $this->Form->input('s1_lkp_heqf_align_id', array('label' => 'Institution alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));

	echo $this->Form->input('lkp_delivery_mode_id', array('label' => 'Mode of delivery', 'empty' => 'Select', 'type' => 'select', 'options' => $DeliveryMode));
	
	echo $this->Form->input('lkp_heqf_align_id', array('label' => 'CHE alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));
	
	echo $this->Form->input('institution_id', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));
	
	echo $this->Form->input('lkp_qualification_type_id', array('label' => 'Section 2 Qualification type', 'empty' => 'Select', 'type' => 'select', 'options' => $QualificationType));
	
	echo $this->Form->input('lkp_outcome_id', array('label' => 'Application Outcome', 'empty' => 'Select', 'type' => 'select', 'options' => $Outcome));
	
	echo $this->Form->submit('Filter', array('id' => 'searchButton', 'value' => 'advancedSearch', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear filter</a>'));
	
	echo $this->Form->end();
?>
</fieldset>
<br />
<br />
<script>
$(function() {
	var $searchLink = $("#searchLink"),
		$clearSearchLink = $("#clearSearchLink");

	$clearSearchLink.click(function(e){
		e.preventDefault();
		resetForm($('#search'));
	});
	
	function resetForm($form){
		$form.find('input:text, input:password, input:file, select, textarea').val('');
		$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	}
	
});
</script>