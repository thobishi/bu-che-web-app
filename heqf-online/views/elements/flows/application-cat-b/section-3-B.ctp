<?php
	echo $this->Form->input('HeqfQualification.id');

	echo $this->element('instructions/section-3-B');
	echo $this->Form->input('HeqfQualification.s3_curriculum', array('label' => $this->Heqf->section3Fields['s3_curriculum']));

	echo $this->element('grids/section_3/assessment');
	echo $this->element('grids/section_3/learning_activities');

	echo $this->Form->input('HeqfQualification.s3_has_wil', array('label' => $this->Heqf->section3Fields['s3_has_wil'], 'options' => array(0 => 'No', 1 => 'Yes')));
	echo $this->Form->inputs(array(
		'fieldset' => 'wil-explain',
		'legend' => 'Workplace-based learning',
		'HeqfQualification.s3_guideline_explained' => array('label' => $this->Heqf->section3Fields['s3_guideline_explained']),
		'HeqfQualification.s3_placement_explained' => array('label' => $this->Heqf->section3Fields['s3_placement_explained']),
		'HeqfQualification.s3_workplace_explained' => array('label' => $this->Heqf->section3Fields['s3_workplace_explained'])
	))
?>
<div class="tooltip_container">
</div>
<?php
	echo $this->Html->script('application/section-3-B', array('inline' => false));