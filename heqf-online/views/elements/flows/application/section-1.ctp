<?php
	$user = Auth::get();
	if ($user) {
		$institutionType = $user['Institution']['priv_publ'];
	}

	echo $this->Form->input('HeqfQualification.id');
	echo $this->Form->input('HeqfQualification.s1_qualification_reference_no', array('label' => 'Qualification reference number', 'readonly' => true));
	echo $this->Form->input('HeqfQualification.s1_qualification_title_short', array('label' => 'Qualification title abbreviation', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_qualification_title_short')));
	echo $this->Form->input('HeqfQualification.s1_heqc_reference_no', array('label' => 'HEQC reference number', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_heqc_reference_no')));
	echo $this->Form->input('HeqfQualification.s1_qualification_title', array('label' => 'Qualification title', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_qualification_title')));

	echo $this->Form->input('HeqfQualification.s1_saqa_qualification_id', array('label' => 'SAQA qualification ID', 'type' => 'text', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_saqa_qualification_id')));

	echo $this->Form->input('HeqfQualification.s1_lkp_delivery_mode_id', array('label' => 'Mode of delivery', 'options' => $s1_delivery_modes, 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_lkp_delivery_mode_id')));

	echo $this->Form->input('HeqfQualification.s1_lkp_nqf_level_id', array('label' => 'NQF Exit Level', 'options' => $s1_nqf_levels, 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_lkp_nqf_level_id')));
	echo $this->Form->input('HeqfQualification.s1_minimum_years_full', array('label' => 'Minimum duration full', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_minimum_years_full')));
	echo $this->Form->input('HeqfQualification.s1_minimum_years_part', array('label' => 'Minimum duration part', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_minimum_years_part')));
	echo $this->Form->input('HeqfQualification.s1_credits_total', array('label' => 'Total credits', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_credits_total')));

	echo $this->Form->input('HeqfQualification.s1_minimum_admission_requirements', array('label' => 'Minimum admission requirements', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_minimum_admission_requirements')));

	foreach ($s1_heqf_aligns as $key => $value) {
		if ($key != $this->data['HeqfQualification']['s1_lkp_heqf_align_id']) {
			unset($s1_heqf_aligns[$key]);
		}
	}
	$categoryTypeC = ($this->data['HeqfQualification']['s1_lkp_heqf_align_id'] == 'C') ? true : false;
	echo $this->Form->input('HeqfQualification.s1_lkp_heqf_align_id', array('label' => 'Proposed HEQSF Category', 'readonly' => true, 'options' => $s1_heqf_aligns, 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_lkp_heqf_align_id')));
	if($categoryTypeC) {
		echo $this->Form->input('HeqfQualification.s1_teachout_date', array('label' => 'Teach-out date', 'type' => 'text'));
	}else{
		echo $this->Form->input('HeqfQualification.s1_teachout_date', array('label' => 'Teach-out date', 'type' => 'text', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_teachout_date')));
	}
	

	if ($institutionType == 2) {
		echo $this->Form->input('HeqfQualification.s1_lkp_hemis_qualifier_id', array('label' => 'Major field of study', 'type' => 'select', 'multiple' => true, 'options' => $hemis_qualifiers, 'empty' => '-- Select --', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_lkp_hemis_qualifier_id'), 'after' => $this->element('information/mfos', array('field' => 's1_lkp_hemis_qualifier_id'))));
		echo $this->Form->input('HeqfQualification.s1_lkp_hemis_qualification_type_id', array('label' => 'HEMIS qualification type', 'options' => $s1_hemis_qualification_types, 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_lkp_hemis_qualification_type_id')));
		echo $this->Form->input('HeqfQualification.s1_hemis_minimum_exp_time', array('label' => 'HEMIS minimum experiential time', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_hemis_minimum_exp_time')));
		echo $this->Form->input('HeqfQualification.s1_hemis_total_subsidy_units', array('label' => 'Total subsidy units', 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_hemis_total_subsidy_units')));

		echo $this->Form->input('HeqfQualification.s1_lkp_hemis_funding_level_id', array('label' => 'Funding level', 'options' => $s1_hemis_funding_levels, 'disabled' => $disableFields && !$this->Form->isFieldError('HeqfQualification.s1_lkp_hemis_funding_level_id')));
	}

	echo $this->Html->script(array(
		'/js/application/section-1'
	));