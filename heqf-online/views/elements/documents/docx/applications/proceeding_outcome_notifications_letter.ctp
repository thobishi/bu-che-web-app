<?php
	$this->setFilename('outcome_letter_' . $institutionName . '_' . date('d_F_Y'));
	$this->loadTemplate($file);
	$programmeData = '';
	$table = '';
	$table .= $this->tableHead;
	

	foreach($docData as $programme){
		$title = (!empty($programme['Application']['HeqfQualification']['qualification_title'])) ? $programme['Application']['HeqfQualification']['qualification_title'] : $programme['Application']['HeqfQualification']['s1_qualification_title'];
		$qual_ref = (!empty($programme['Application']['HeqfQualification']['qualification_reference_no'])) ? $programme['Application']['HeqfQualification']['qualification_reference_no'] : $programme['Application']['HeqfQualification']['s1_qualification_reference_no'];

		$table .= $this->tableRow;
		$table = str_replace('qual_title_replace', $title, $table);
		$table = str_replace('qual_ref_replace', $qual_ref, $table);
		$table = str_replace('meeting_date_replace', $programme['ProcHeqcMeeting']['date'], $table);	
		$table = str_replace('outcome_replace', $programme['Application']['Outcome']['outcome_desc'], $table);
	}
	$table .= '</w:tbl>';

	$this->document->setValue('adminName', $adminName);
	$this->document->setValue('programmes', $table);
	
?>