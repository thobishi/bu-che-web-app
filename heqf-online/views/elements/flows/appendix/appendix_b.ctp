<?php
	echo $this->Form->input('HeqfQualification.id');
	echo $this->element('information/cesm', array('field' => 'lkp_cesm1_code_id'));
	echo $this->Form->input('HeqfQualification.lkp_cesm1_code_id', array('label' => 'CESM', 'type' => 'select', 'multiple' => true, 'options' => $cesm_codes, 'empty' => '-- Select --'));
	echo $this->Form->input('HeqfQualification.research_credits', array('label' => 'Research credits'));
?>
	<div class="notify">
		The <em>"Major field of study"</em> needs to be a 3rd order (6-digit) CESM code. Multiple CESM codes can be separated with a comma (,). <br /><br />
		The above mentioned CESM codes can be found in the template used to import the applications. These templates can be found at <a href="http://www.che.ac.za/heqf/" target="_blank">http://www.che.ac.za/heqf/</a> under <em>"HEQSF Implementation Templates"</em>.
	</div>
<?php
	echo $this->Form->input('HeqfQualification.let_dupl_ind', array('type' => 'hidden'));
	echo $this->element('information/mfos', array('field' => 'hemis_lkp_cesm3_code_id'));
	echo $this->Form->input('HeqfQualification.hemis_lkp_cesm3_code_id', array('label' => 'Major field of study', 'type' => 'select', 'multiple' => true, 'options' => $hemis_qualifiers, 'empty' => '-- Select --'));
	echo ($this->data['HeqfQualification']['let_dupl_ind']) ? $this->Form->input('HeqfQualification.motivation_duplicate', array('label' => 'Motivation for duplicate')) : '';
	
	echo $this->Html->script(array(
		'/js/heqf_qualifications/qual_sections'
	));
?>