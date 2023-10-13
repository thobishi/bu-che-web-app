<?php
class HeqfQualificationSite extends AppModel {
	var $name = 'HeqfQualificationSite';
	
	public $belongsTo = array(
		'HeqfQualification'
	);	

	public $actsAs = array(
		'OctoLog.AuditLog' => array(
			'userModel' => 'OctoUsers.User'
		)
	);

	public function removeValues($qualId){
		$this->deleteAll(array('HeqfQualificationSite.heqf_qualification_id' => $qualId));
	}
}