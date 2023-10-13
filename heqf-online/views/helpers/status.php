<?php
class StatusHelper extends AppHelper {
	
	public function accepted($outcomes, $Outcomes){
		$acceptedCount = 0;
		$notifiedCount = 0;
		foreach($Outcomes as $OutcomeLookUp){
			if(isset($outcomes[$OutcomeLookUp])){
				foreach($outcomes[$OutcomeLookUp] as $appInfo){
					$acceptedCount = (!($appInfo['outcome'])) ? $acceptedCount + 1 : $acceptedCount;
					$notifiedCount = (!($appInfo['notified'])) ? $notifiedCount + 1 : $notifiedCount;
				}
			}
		}
		$accepted = ($acceptedCount > 0) ? false : true;
		
		return $accepted;
	}
	
	public function submittedDate($date){
		$display = 'Not submitted';
		if($date !== '1970-01-01') {
			$display = $date;
		}
		return $display;
	}
	
	public function getUserAssigned($application){
		
		$user = $application['User']['first_name'] . ' ' . $application['User']['last_name'] . '('.$application['User']['email_address'].')';
		
		if($application['Application']['submission_date'] != '1970-01-01'){
			$user = 'CHE';
			if($application['Application']['application_status'] == 'RenewEdited' && $application['Application']['review_error'] == 1){
					$user = $application['User']['first_name'] . ' ' . $application['User']['last_name'] . '('.$application['User']['email_address'].')';
			}
		}
		
		return $user;
	}
	
	public function instStatus($application, $rowError){
	
		$application['Application'] = (isset($application['Application'])) ? $application['Application'] : $application;
		
		if($application['Application']['submission_date'] != '1970-01-01'){
			$applicationStatus = 'Submitted';
			if($application['Application']['application_status'] == 'RenewEdited'){
				$applicationStatus = isset($application['ApplicationStatus']['application_status_desc']) ? $application['ApplicationStatus']['application_status_desc'] : $application['Application']['application_status'];
			}
		}
		
		switch($application['Application']['application_status']){
			case 'New':
				$applicationStatus = 'Ready for submission';
				if($rowError){
					switch($application['HeqfQualification']['s1_lkp_heqf_align_id']){
						case 'B':
							$applicationStatus = 'Needs completion - Category B';
							break;
						default:
							$applicationStatus = 'Needs correction';
							break;
					}
				}
				break;
			case 'RenewEdited':
				if(!$application['Application']['review_error']){
					$applicationStatus = 'Re-submitted';
				}
				if($rowError){
					$applicationStatus .= ' - Needs correction';
				}
				break;
		}
		
		if(!empty($application['HeqfQualification']) && $application['HeqfQualification']['apx_B']){
			$applicationStatus = $this->appendixStatusCheck($application['HeqfQualification']);
		}
		
		return $applicationStatus;
	}
	
	public function appendixStatusCheck($qualification){
		$applicationStatus = "";
		
		if(($qualification['apx_B'] && $qualification['s2_error']) || ($qualification['apx_B'] && !$qualification['s2_error'] && $qualification['modified'] < '2013-03-02 00:00:00')){
			$applicationStatus = 'Appendix B - Needs correction';
		}
		elseif($qualification['apx_B'] && !$qualification['s2_error'] && $qualification['modified'] >= '2013-03-02 00:00:00'){
			$applicationStatus = 'Appendix B - Updated';
		}
		
		return $applicationStatus;
	}
	
	public function statusClass($application, $rowError){
		$class = '';
		
			
		if($application['Application']['submission_date'] != '1970-01-01') {
			$class = ' submitted';
		}
		else{
			if($rowError) {
				$class = ' error';
			}
			elseif($application['Application']['application_status'] !== 'Submitted') {
				$class = ' ready';	
			}
		}
		
		return $class;
	}
	
	public function statusDisabled($application){
		$disabled = false;
		
		if($application['Application']['submission_date'] != '1970-01-01'){
			if($application['Application']['application_status'] !== 'RenewEdited'){
				$disabled = true;
			}
			else{
				switch($application['Application']['review_error']){
					case '0':
						$disabled = true;
						break;
					case '1':
						$disabled = false;
						break;
				}
			}
		}
		
		return $disabled;
	}
	
	public function checkActionsUpdate($application){
		$return = false;
		
		if($application['Application']['user_id'] == Auth::get('User.id')){
			if($application['Application']['submission_date'] == '1970-01-01' || 
				$application['Application']['application_status'] == 'RenewEdited'){
				$return = true;
			}
		}
		
		return $return;
	}
	
	public function checkAppendixB($application){
		$return = false;
		
		if(isset($application['HeqfQualification']['apx_B']) && $application['HeqfQualification']['apx_B']){
			$return = true;
		}
		
		return $return;
	}

	public function getClass($applicationStatus){
	
		$status = array(
			'New' => '',
			'Submitted' => 'Submitted',
			'Submitted (after checklisting corrections)' => 'Submitted (after checklisting corrections)',
			'In checklisting' => 'Checklisting',
			'Checklisted' => 'Checklisting',
			'Checklisted (return)' => 'Checklisting',
			'In evaluation' => 'Evaluation',
			'Evaluated' => 'Evaluation',
			'In review' => 'Review',
			'Reviewed' => 'Review',
			'Reviewed (return)' => 'Review',
			'Inactive' => 'Inactive',
			'Re-submitted (after review)' => 'RenewEdited',
			'Representation (Institution)' => 'Representation',
			'Deferral (Institution)' => 'Deferral',
			'Representation (Submitted)' => 'Representation',
			'Deferral (Submitted)' => 'Deferral',
			'Representation (Reviewer)' => 'Representation',
			'Deferral (Reviewer)' => 'Deferral',
			'Representation (Processed)' => 'Representation',
			'Deferral (Processed)' => 'Deferral'
		);
		
		return ($applicationStatus) ? $status[$applicationStatus] : '';
	
	}

	public function getStatus($application){
		$status = array(
			'New' => array(
				'conditions' => array(
					'equal' => array(
						'submission_date' => '1970-01-01',
						// 'evaluation_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						'review_date' => '1970-01-01'
					)
				)
			),
			'Submitted' => array(
				'conditions' => array(
					'equal' => array(
						// 'evaluation_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'checklisting_status_id' => NULL,
						'returned_from_checklisting' => '0',
						'lkp_proceeding_type_id' => ''
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01'
					)
				)
			),
			'Submitted (after checklisting corrections)' => array(
				'conditions' => array(
					'equal' => array(
						// 'evaluation_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'checklisting_status_id' => NULL,
						'returned_from_checklisting' => '1'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01'
					)
				)
			),			
			'In checklisting' => array(
				'conditions' => array(
					'equal' => array(
						// 'evaluation_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'checklisting_status_id' => 'New'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01'
					)
				)
			),
			'Checklisted' => array(
				'conditions' => array(
					'equal' => array(
						// 'evaluation_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => ''
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01'
					)
				)		
			),
			'Checklisted (return)' => array(
				'conditions' => array(
					'equal' => array(
						// 'evaluation_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'checklisting_status_id' => 'Return',
						'evaluation_status_id' => ''
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01'
					)
				)			
			),
			'In evaluation' => array(
				'conditions' => array(
					'equal' => array(
						// 'evaluation_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'New'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01'
					)
				)		
			),
			'Evaluated' => array(
				'conditions' => array(
					'equal' => array(
						'review_date' => '1970-01-01',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => NULL
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01'//,
						// 'evaluation_date' => '1970-01-01'
					)
				)		
			),
			'In review' => array(
				'conditions' => array(
					'equal' => array(
						'review_date' => '1970-01-01',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'New'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						// 'evaluation_date' => '1970-01-01'
					)
				)		
			),
			'Reviewed' => array(
				'conditions' => array(
					'equal' => array(
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'lkp_proceeding_type_id' => ''
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						// 'evaluation_date' => '1970-01-01',
						'review_date' => '1970-01-01',
					)
				)		
			),
			'Reviewed (return)' => array(
				'conditions' => array(
					'equal' => array(
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Return'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						// 'evaluation_date' => '1970-01-01',
						'review_date' => '1970-01-01'
					)
				)		
			),
			'Re-submitted (after review)' => array(
				'conditions' => array(
					'equal' => array(
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Returned',
						'application_status' => 'RenewEdited',
						'review_date' => '1970-01-01',
						'review_error' => '0'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'checklisting_date' => '1970-01-01',
						// 'evaluation_date' => '1970-01-01',
						'resubmission_date' => '1970-01-01'
					)
				)
			),
			'Representation (Institution)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'InstNew',
						'lkp_proceeding_type_id' => 'r',
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'user_id' => '',
					)
				)
			),
			'Deferral (Institution)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'InstNew',
						'lkp_proceeding_type_id' => 'd',
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'user_id' => '',
					)
				)
			),
			'Representation (Submitted)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'InstComplete',
						'lkp_proceeding_type_id' => 'r',
						'user_id' => '',
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01'
					)
				)
			),
			'Deferral (Submitted)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'InstComplete',
						'lkp_proceeding_type_id' => 'd',
						'user_id' => ''
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01'
					)
				)
			),
			'Representation (Reviewer)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'ReviewerNew',
						'lkp_proceeding_type_id' => 'r',
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'user_id' => '',
					)
				)
			),
			'Deferral (Reviewer)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'ReviewerNew',
						'lkp_proceeding_type_id' => 'd'
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01',
						'user_id' => ''
					)
				)
			),
			'Representation (Processed)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'ReviewerComplete',
						'lkp_proceeding_type_id' => 'r',
						'user_id' => '',
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01',
					)
				)
			),
			'Deferral (Processed)' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Proceeding',
						'checklisting_status_id' => 'Evaluate',
						'evaluation_status_id' => 'Complete',
						'review_status_id' => 'Reviewed',
						'proceeding_status_id' => 'ReviewerComplete',
						'lkp_proceeding_type_id' => 'd',
						'user_id' => ''
					),
					'notEqual' => array(
						'submission_date' => '1970-01-01',
						'review_date' => '1970-01-01',
					)
				)
			),
			'Inactive' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Inactive'
					)
				)		
			),
			'Appendix B - needs correction' => array(
				'conditions' => array(
					'equal' => array(
						'application_status' => 'Inactive'
					)
				)		
			)
		);
		
		$theStatus = array();
			
			
		$notEqualPass = true;
		
		foreach($status as $finalStatus => $conditions){
			foreach($conditions as $conditionData){
				foreach($conditionData as $function => $data){
					switch($function){
						case 'equal':
							$equalFail = 0;
							foreach($data as $column => $value){
								if($application[$column] != $value){
									$equalFail++;
								}
							}
							$equalPass = ($equalFail == 0) ? true : false;
							break;
						case 'notEqual':
							$notEqualFail = 0;
							foreach($data as $column => $value){
								if($application[$column] == $value){
									$notEqualFail++;
								}
							}
							$notEqualPass = ($notEqualFail == 0) ? true : false;
							break;
					}
				}
			}
			
			if($equalPass && $notEqualPass){
				array_push($theStatus, $finalStatus);
			}
		}
		
		if(!end($theStatus)){
			return $this->instStatus($application, false);
		}

		return end($theStatus);
	}


}