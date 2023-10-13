<?php
class Proceeding extends AppModel {
	var $name = 'Proceeding';

	public $belongsTo = array(
		'Application',
		'ProcHeqcMeeting' => array(
			'className' => 'HeqcMeeting',
			'foreignKey' => 'heqc_meeting_id',
		),
		'ProceedingType' => array(
			'className' => 'Lookups.ProceedingType',
			'foreignKey' => 'proceeding_type_id',
		),
		'ProcUser' => array(
			'className' => 'OctoUsers.User',
			'foreignKey' => 'proc_user_id',
			'fields' => 'ProcUser.first_name, ProcUser.last_name, ProcUser.email_address'
		)
	);

	public $validate = array(
		'proc_document' => array(
			'validDocSize' => array(
				'rule' => 'validDocSize',
				'message' => 'The document size must not exceed the limit of 20Mb and must not be empty'
			)
		),
		'proc_lkp_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select a Review oucome'
			)
		),
		'proc_comments' => array(
			'rule' => 'validateProcComments',
			'message' => 'It is required to fill in the comment field'
		),
	);

	public function validDocSize($params) {
		$val = array_shift($params);
		$valid = false;

		if (isset($val['size']) && $val['size'] < 20971520 && $val['size'] != 0 && (isset($val['error']) && $val['error'] == 0)) {
			$valid = true;
		}

		return $valid;
	}

	public function validateProcComments() {
		if (!empty($this->data[$this->alias]['proc_lkp_outcome_id']) && ($this->data[$this->alias]['proc_lkp_outcome_id'] == 'ni' || $this->data[$this->alias]['proc_lkp_outcome_id'] == 'nr') && empty($this->data[$this->alias]['proc_comments'])) {
			return false;
		}

		return true;
	}

/*
	public function validateProcDocument($params){
	    $val = array_shift($params);
	    $valid = false;
	    
	    if ((isset($val['error']) && $val['error'] == 0) ||
	    (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) {
	        $valid = is_uploaded_file($val['tmp_name']);
	    }
	    return $valid;
	}*/

/**
 * Finding the maximum order of a proceeding for a particular application.
 * The value returned is used to indicate the order of proceedings for an application
 * .
 * @param  string $application_id [description]
 * 
 * @return int          [maximum order for the application]
 */	
	public function lastProceeding($application_id) {
		$proc_order = 0;
		$this->virtualFields['max_order'] = 'MAX(Proceeding.proc_order)';
		$last = $this->find('all', array('conditions' => array('Proceeding.application_id' => $application_id), 'fields' => array('max_order')));

		if($last[0]['Proceeding']['max_order'] != 'null'){

			$proc_order = $last[0]['Proceeding']['max_order'];
		}
		unset($this->virtualFields['max_order']);
		return intval($proc_order);
	}

	public function getProceedingTypeDesc($proceedingTypeId) {
		$proceedingTypeDesc = $this->ProceedingType->find('list', array('fields' => array('ProceedingType.id', 'ProceedingType.description')));
		$proceedingTypeDesc = $proceedingTypeDesc[$proceedingTypeId];

		return $proceedingTypeDesc;
	}

	public function deleteExistingProceedingFile($destinationPath, $existingFile) {
		$allfiles = glob($destinationPath . '/*');

		if (!empty($allfiles)) {
			foreach($allfiles as $file){ // iterate files			
			  if(is_file($file) && strpos($file, $existingFile) !== false) {
			  	unlink($file); // delete file
			  }
			}
		}		
	}

	public function getHeqcProceedings($conditions) {
		$docData = array();

		if (!empty($conditions)) {
			$this->Application->recursive = -1;
			$docData = $this->find('all', array(
				'fields' => array(
					'Proceeding.id',
					'Proceeding.application_id',
					'Proceeding.proc_lkp_outcome_id'
				),
				'contain' => array(
					'ProcHeqcMeeting' => array(
						'fields' => array(
							'id',
							'date'
						)
					),
					'Application' => array(
						'fields' => array(
							'lkp_outcome_id'
						),
						'Outcome' => array(
							'fields' => array(
								'id',
								'outcome_desc'
							)
						),
						'HeqfQualification' => array(
							'fields' => array(
								'id',
								'qualification_title',
								'qualification_reference_no',
								's1_qualification_title',
								's1_lkp_heqf_align_id',
								's1_qualification_reference_no'
							)
						)
					)
				),
				'conditions' => $conditions
			));
		}

		return $docData;
	}
}