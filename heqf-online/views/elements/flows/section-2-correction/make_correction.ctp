<div class="modules form">

	<?php
		echo $this->Form->input('HeqfQualification.id');
		echo $this->Form->input('HeqfQualification.qualification_title', array('label' => 'Qualification title'));
		echo $this->Form->input('HeqfQualification.qualification_title_short', array('label' => 'Qualification title abbr'));
		echo $this->Form->input('HeqfQualification.lkp_cesm1_code_id', array('label' => 'CESM', 'type' => 'select', 'multiple' => true, 'options' => $cesm_codes, 'empty' => '-- Select --','selected' => $this->data['HeqfQualification']['lkp_cesm1_code_id'], 'after' => $this->element('information/cesm', array('field' => 'lkp_cesm1_code_id'))));				
		echo $this->Form->input('HeqfQualification.hemis_lkp_cesm3_code_id', array('label' => 'Major field of study', 'type' => 'select', 'multiple' => true, 'options' => $hemis_qualifiers, 'empty' => '-- Select --', 'selected' => $this->data['HeqfQualification']['hemis_lkp_cesm3_code_id'], 'after' => $this->element('information/mfos', array('field' => 'hemis_lkp_cesm3_code_id'))));
		echo $this->Form->input('HeqfQualification.lkp_designator_id', array('label' => 'Qualification designator', 'options' => $designators, 'empty' => '-- Select --'));
		echo $this->Form->input('HeqfQualification.other_designator', array('label' => 'Other designator'));
		echo $this->Form->input('HeqfQualification.motivation_other_designator', array('label' => 'Motivation for other designator'));		
		echo $this->Form->input('HeqfQualification.credits_total', array('label' => 'Total credits'));

	?>
</div>
<?php
	echo $this->Html->script(array(
		'/js/application/section-2-correction'
	));
