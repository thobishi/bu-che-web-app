<?php
	$this->setFilename('outcome_letter_' . $institutionName . '_' . date('d_F_Y'));
	$this->loadTemplate($file);
	$programmeData = '';
	$table = '';
	$table .= $this->tableHead;
	

	foreach($docData as $programme){
		$title = (!empty($programme['HeqfQualification']['qualification_title'])) ? $programme['HeqfQualification']['qualification_title'] : $programme['HeqfQualification']['s1_qualification_title'];
		$qual_ref = (!empty($programme['HeqfQualification']['qualification_reference_no'])) ? $programme['HeqfQualification']['qualification_reference_no'] : $programme['HeqfQualification']['s1_qualification_reference_no'];

		$table .= $this->tableRow;
		$table = str_replace('qual_title_replace', $title, $table);
		$table = str_replace('qual_ref_replace', $qual_ref, $table);
		$table = str_replace('meeting_date_replace', $programme['HeqcMeeting']['date'], $table);	
		$table = str_replace('outcome_replace', $programme['Outcome']['outcome_desc'], $table);
	}
	$table .= '</w:tbl>';

	$this->document->setValue('adminName', $adminName);
	$this->document->setValue('programmes', $table);
	
?>