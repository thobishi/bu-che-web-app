<?php
	$this->data['HeqfQualification']['qualification_reference_no'] = $this->data['HeqfQualification']['s1_qualification_reference_no'];
	if ($user = Auth::get()) {
		$institutionType = $user['Institution']['priv_publ'];
	}
	echo $this->Form->input('HeqfQualification.id');
	echo $this->Form->input('HeqfQualification.qualification_reference_no', array('label' => 'Qualification reference number', 'readonly' => true));
	echo $this->Form->input('HeqfQualification.qualification_title_short', array('label' => 'Qualification title abbr'));
	echo $this->Form->input('HeqfQualification.heqc_reference_no', array('label' => 'HEQC reference number'));
	echo $this->Form->input('HeqfQualification.qualification_title', array('label' => 'Qualification title'));

	echo $this->Form->input('HeqfQualification.replace_qual', array('label' => 'Which qualifications are being replaced', 'after' => $this->element('information/replace_qual'), 'type' => 'select', 'multiple' => true, 'options' => $InstitutionQualification, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.lkp_qualification_type_id', array('label' => 'Qualification type', 'options' => $qualification_types, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.lkp_designator_id', array('label' => 'Qualification designator', 'options' => $designators, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.other_designator', array('label' => 'Other designator'));
	echo $this->Form->input('HeqfQualification.motivation_other_designator', array('label' => 'Motivation for other designator'));

	echo $this->Form->input('HeqfQualification.lkp_cesm1_code_id', array('label' => 'CESM', 'type' => 'select', 'multiple' => true, 'options' => $cesm_codes, 'empty' => '-- Select --', 'after' => $this->element('information/cesm', array('field' => 'lkp_cesm1_code_id'))));

	echo $this->Form->input('HeqfQualification.lkp_delivery_mode_id', array('label' => 'Mode of delivery', 'options' => $delivery_modes, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.lkp_professional_class_id', array('label' => 'Professional class', 'options' => $professional_classes, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.professional_body', array('label' => 'Professional body'));
	echo $this->Form->input('HeqfQualification.lkp_nqf_level_id', array('label' => 'NQF Exit Level', 'options' => $nqf_levels, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.credits_total', array('label' => 'Total credits'));
	echo $this->Form->input('HeqfQualification.wil_el_credits', array('label' => 'WIL EL credits'));
	echo $this->Form->input('HeqfQualification.research_credits', array('label' => 'Research credits'));
	echo $this->Form->input('HeqfQualification.minimum_admission_requirements', array('label' => 'Minimum admission requirements'));
	echo $this->Form->input('HeqfQualification.minimum_years_full', array('label' => 'Minimum duration full'));
	echo $this->Form->input('HeqfQualification.minimum_years_part', array('label' => 'Minimum duration part'));
	echo $this->Form->input('HeqfQualification.struct_elect', array('label' => 'Structured or with electives'));
	?>

	<?php
	echo $this->Form->input('HeqfQualification.hemis_lkp_cesm3_code_id', array('label' => 'Major field of study', 'type' => 'select', 'multiple' => true, 'options' => $hemis_qualifiers, 'empty' => '-- Select --', 'after' => $this->element('information/mfos', array('field' => 'hemis_lkp_cesm3_code_id'))));

	if ($institutionType == 2){
		echo $this->Form->input('HeqfQualification.lkp_hemis_heqf_qualification_type_id', array('label' => 'HEMIS amended qualification type', 'options' => $hemis_heqf_qualification_types, 'empty' => '-- Select --'));
		echo $this->Form->input('HeqfQualification.hemis_minimum_exp_time', array('label' => 'HEMIS minimum experiential time'));
		echo $this->Form->input('HeqfQualification.hemis_total_subsidy_units', array('label' => 'Total subsidy units'));
		echo $this->Form->input('HeqfQualification.lkp_hemis_funding_level_id', array('label' => 'Funding level', 'options' => $hemis_funding_levels, 'empty' => '-- Select --'));	
	}
?>

	<?php echo $this->Form->input('HeqfQualification.saqa_qualification_id', array('label' => 'SAQA qualification ID', 'type' => 'text'));
	 ?>
	<fieldset id="saqaFields">
		<legend>SAQA fields</legend>
		<div class="flash-messages">
			<div class="ui-state-good ui-corner-all">If you have entered the <b>SAQA qualification ID</b> , the following fields are not required to be completed
			</div>
		</div>	
		<?php
		echo $this->Form->input('HeqfQualification.qualification_purpose', array('label' => 'Qualification purpose'));
		echo $this->Form->input('HeqfQualification.qualification_rationale', array('label' => 'Qualification
		rationale'));
		echo $this->Form->input('HeqfQualification.exit_level_outcome', array('label' => 'Exit level outcomes'));
		echo $this->Form->input('HeqfQualification.int_assess', array('label' => 'Integrated Assessment'));
		echo $this->Form->input('HeqfQualification.articulation_progression', array('label' => 'Articulation progression'));
		echo $this->Form->input('HeqfQualification.moderation', array('label' => 'Moderation'));
		echo $this->Form->input('HeqfQualification.rpl', array('label' => 'RPL'));
		echo $this->Form->input('HeqfQualification.international_comparability', array('label' => 'International comparability'));
		?>
	</fieldset>

<?php
	echo '<span class="ui-helper-hidden" id="nqfLevels">' . json_encode($QualificationTypeNQFs) . '</span>';

	echo $this->Html->script(array(
		'/js/application/section-2'
	));