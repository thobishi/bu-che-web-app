<?php
class ProgrammeAssessmentApproach extends AppModel {
	var $name = 'ProgrammeAssessmentApproach';
	
	public $belongsTo = array(
		'HeqfQualification'
	);
	
	public function beforeSave(){
		return true;
	}
}
?>