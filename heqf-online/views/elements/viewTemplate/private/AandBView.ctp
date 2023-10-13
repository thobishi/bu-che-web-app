<?php
	echo $this->element('viewTemplate/AandBView', array('viewType' => 'privateAB', 'information' => $information, 'institutionType' => $institutionType));

	echo ((!empty($information)) && ($information['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B')) ? $this->element('viewTemplate/catB_section_3', array('information' => $information)) : '';