<?php
class S1QualificationSite extends AppModel {
	var $name = 'S1QualificationSite';
	
	public $belongsTo = array(
		'HeqfQualification'
	);	
	
	public function removeValues($qualId){
		$this->deleteAll(array('S1QualificationSite.heqf_qualification_id' => $qualId));
	}	
}
?>