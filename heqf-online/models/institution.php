<?php
class Institution extends AppModel {

	public $displayField = 'hei_name';

	public $order = 'hei_name';

	public $actsAs = array(
		'Search.Searchable'
	);

	public $hasMany = array(
		'Application',
		'User' => array(
			'className' => 'OctoUsers.User'
		)
	);

	public $filterArgs = array(
		array('name' => 'institution', 'type' => 'value', 'field' => 'Institution.id'),
		array('name' => 'meeting_date', 'type' => 'value', 'field' => 'Application.heqc_meeting_id'),
	);

	public function listSearchParams($params) {
		$presetVars = array(
			array('field' => 'institution', 'type' => 'value'),
			array('field' => 'meeting_date', 'type' => 'value')
		);

		return $presetVars;
	}

	public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		if (!empty($conditions) && isset($extra['contain']['Application'])) {
			extract($this->__paginateConditions($conditions, $extra));
		}
		return $this->find('count', compact('conditions'));
	}

	private function __paginateConditions($conditions, $extra) {
		foreach ($conditions as $field => $value) {
			if (strpos($field, 'Application.') === 0) {
				$extra['contain']['Application']['conditions'][$field] = $value;
				unset($conditions[$field]);
			}
		}
		return compact('conditions', 'extra');
	}

	public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		if (!empty($conditions) && isset($extra['contain']['Application'])) {
			extract($this->__paginateConditions($conditions, $extra));
		}

		$query = compact('conditions', 'fields', 'order');
		$query = array_merge($query, $extra);
		return $this->find('all', $query);
	}

	public function getInformation($instId) {
		$information = $this->find('first', array(
			'conditions' => array(
					'Institution.id' => $instId
				)
		));

		return (!empty($information)) ? $information : false;
	}

	public function standardConditions($view, $params) {
		$conditions = array();

		switch($params["process-slug"]){
			case 'outcome':
				$conditions['Application.heqc_meeting_id !='] = '';
				$conditions['Application.archived !='] = '1';
				break;
		}

		return $conditions;
	}

	public function standardContains($view, $params) {
		return array(
			'Application' => array(
				'HeqfQualification' => array(
					'fields' => array(
						'HeqfQualification.s1_qualification_title',
						'HeqfQualification.qualification_title',
						'HeqfQualification.s1_lkp_heqf_align_id'
					),
					'order' => array(
						'HeqfQualification.s1_qualification_title',
						'HeqfQualification.qualification_title',
					)
				),
				'AppHeqfAlign',
				'Outcome',
				'HeqcMeeting' => array(
					'fields' => array(
						'id',
						'date'
					)
				),
				'fields' => array(
					'Application.id',
					'Application.lkp_heqf_align_id',
					'Application.heqc_meeting_id',
					'Application.outcome_accepted',
					'Application.notified'
				),
			)
		);
	}

	public function paginateParams($view, $paginate, $params) {
		$paginate['contain']['Application']['conditions'] = $paginate['conditions'];
		unset($paginate['conditions']);

		$paginate['order'] = array(
			'Institution.hei_name',
		);
		$paginate['fields'] = array(
			'Institution.hei_name',
			'Institution.hei_code'
		);
		return $paginate;
	}

	public function paginateParams2($conditionsArray, $params) {
		ini_set('memory_limit', -1);
		$conditionsArray = array();
		$conditions = array();

		switch($params["process-slug"]){
			case 'outcome':
				$conditionsArray['Application']['Application.heqc_meeting_id != '] = '';
				break;
		}

		$fields = array(
			'institution' => 'Application.institution_id',
			'meeting_date' => 'Application.heqc_meeting_id',
		);

		//normal search

		if (!empty($params['data']['Process']['advancedSearch'])) {
			if (isset($params['data']['Process']['advancedSearch']['clear']) && $params['data']['Process']['advancedSearch']['clear'] == true) {
				$this->Session->delete('search');
			}
			unset($params['data']['Process']['advancedSearch']['clear']);
			if (isset($params["process-slug"])) {
				$this->Session->write('search.slug', $params["process-slug"]);
			}
			foreach ($params['data']['Process']['advancedSearch'] as $fieldName => $value) {
				if (!empty($value)) {
					$this->Session->write('search.' . $fieldName, $value);
					$conditions['and'][$fields[$fieldName]] = $value;
				}
			}
		}

		//session search

		$searchArray = $this->Session->read('search');
		unset($searchArray['clear']);
		if (!empty($searchArray)) {
			if (isset($searchArray['slug']) && isset($params["process-slug"]) && $searchArray['slug'] == $params["process-slug"]) {
				unset($searchArray['slug']);
				foreach ($searchArray as $field => $value) {
					$conditions['and'][$fields[$field]] = $value;
				}
			} else {
				$this->Session->delete('search');
			}
		}

		$conditions = array_merge($conditionsArray['Application'], $conditions);

		return
			$this->find('all', array(
				'contain' => array(
					'Application' => array(
						'HeqfQualification' => array(
							'fields' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
								'HeqfQualification.s1_lkp_heqf_align_id'
							),
							'order' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
							)
						),
						'AppHeqfAlign',
						'Outcome',
						'HeqcMeeting' => array(
							'fields' => array(
								'id',
								'date'
							)
						),
						'fields' => array(
							'Application.id',
							'Application.lkp_heqf_align_id',
							'Application.heqc_meeting_id',
							'Application.outcome_accepted',
							'Application.notified'
						),
						'conditions' => $conditions,
					)
				),
				'order' => array(
					'Institution.hei_name',
				),
				'fields' => array(
					'Institution.hei_name',
					'Institution.hei_code'
				),
			));
	}

	public function fetchLookups() {
		$lookups = array();

		$lookups['HeqcMeeting'] = $this->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
		$lookups['Outcomes'] = $this->Application->Outcome->find('list', array('conditions' => array('Outcome.id' => array('a', 'r', 'n'))));
		$lookups['AllApplicationOutcomes'] = $this->Application->Outcome->find('list', array('conditions' => array('Outcome.id' => array('a', 'r', 'n', 'ni', 'nr'))));
		$lookups['Institution'] = $this->find('list');

		return $lookups;
	}

	public function getProceedingListOutcomes($conditions = array(), $params = array()) {
		$conditionString = '';
		if (isset($params['data']['Institution']['selected'])) {
			$selectedArray = $params['data']['Institution']['selected'];
			$selectedArray = array_filter($selectedArray);
			if (empty($selectedArray)) {
				return false;
			}
		}

		foreach ($conditions as $key => $value) {
			if ($key == 'AND') {
				foreach ($value as $index => $conditionsArray) {
					foreach ($conditionsArray as $field => $value) {
						$and = end($conditionsArray) == $value ? ')' : 'AND';
						$first = ($index != 0 && reset($conditionsArray) == $value) ? 'OR(' : '';
						$showFistbracket = ($index == 0 && reset($conditionsArray) == $value) ? '(' : '';
						$conditionString .= " $first $showFistbracket $field = '$value' $and ";
					}
				}
				$conditionString = "AND ($conditionString)";
			} else {

				$conditionString .= " AND $key = $value";
			}
		}

		$sql = "
			SELECT Institution.hei_name,
			Institution.hei_code,
			Application.institution_id, 
			HeqcMeeting.date, 
			HeqcMeeting.id, 
			ProceedingType.description, 
			ProceedingType.id,
			Proceeding.outcome_accepted,
			Proceeding.notified,
			count(*) as total_assigned,
			sum(if(proc_lkp_outcome_id = 'a',1,0)) as outcome_aligned,
			sum(if(proc_lkp_outcome_id = 'r',1,0)) as outcome_recat,
			sum(if(proc_lkp_outcome_id = 'n',1,0)) as outcome_notaligned,
			sum(if(proc_lkp_outcome_id = 'ni',1,0)) as outcome_ni,
			sum(if(proc_lkp_outcome_id = 'nr',1,0)) as outcome_recat_to_c,
			sum(if(proc_lkp_outcome_id = 'nir',1,0)) as outcome_return_to_inst
		FROM institutions AS Institution, applications AS Application,
			proceedings AS Proceeding,
			lkp_proceeding_types AS ProceedingType,
			heqc_meetings AS HeqcMeeting
		WHERE Institution.id = Application.institution_id
			AND Proceeding.application_id = Application.id
			AND Proceeding.proceeding_type_id = ProceedingType.id
			AND Proceeding.heqc_meeting_id = HeqcMeeting.id
			$conditionString
		GROUP BY Institution.hei_name,
			Institution.hei_code,
			Application.institution_id, 
			HeqcMeeting.date, 
			HeqcMeeting.id,
			Proceeding.outcome_accepted,
			Proceeding.notified,
			ProceedingType.description, 
			ProceedingType.id
		ORDER BY Institution.hei_name,
			Institution.hei_code,
			Application.institution_id, 
			HeqcMeeting.date, 
			HeqcMeeting.id,
			Proceeding.outcome_accepted,
			Proceeding.notified,
			ProceedingType.description, 
			ProceedingType.id";

		$query = $this->query($sql, $cachequeries = false);
		return $query;
	}

	public function actionListConditions($action, $params) {
		$conditions = array();
		switch ($action) {
			/*
				Use session variable that will contain the date and the function
			*/
			case 'outcome_accept':
				$conditions = $this->__generateConditions($params, $action, '');
				break;
			case 'outcome_notify':
				$conditions = $this->__generateConditions($params, $action, 'outcome_accept');
				break;
			case 'proceeding_outcome_accept':
				$conditions = $this->_generateProcConditions($params, $action);
				
				break;
			case 'proceeding_outcome_notify':
				$conditions = $this->_generateProcConditions($params, $action);
				break;
		}

		return $conditions;
	}

	protected function _generateProcConditions($params, $action) {
		$proctypeArray = array();
		$conditions = array();
		if (!empty($params['data'])) {
			foreach ($params['data']['Institution']['selected'] as $dateInstProc => $instID) {
				if ($instID != 0) {
					array_push($proctypeArray, $dateInstProc);
				}
			}
			$proctypeArray = array_unique($proctypeArray);

			foreach ($proctypeArray as $key => $pieces) {
				$pieces = explode("_", $pieces);
				
				$conditions['AND'][$key]['Application.institution_id'] = $pieces[1];
				$conditions['AND'][$key]['Proceeding.proceeding_type_id'] = $pieces[2];
				$conditions['AND'][$key]['HeqcMeeting.date'] = $pieces[0];
			}

			switch ($action) {
				case 'proceeding_outcome_accept':
					$conditions['Proceeding.outcome_accepted'] = 0;
					$conditions['Proceeding.notified'] = 0;
					break;
				case 'proceeding_outcome_notify':
					$conditions['Proceeding.outcome_accepted'] = 1;
					$conditions['Proceeding.notified'] = 0;
					break;
			}
		}
		return $conditions;
	}

	private function __generateConditions($params, $action, $requiredAction) {
		$conditions = array();
		$datesArray = array();

		if (!empty($params['data'])) {
			foreach ($params['data']['Process']['selected'] as $dateInst => $instID) {
				if ($instID != 0) {
					array_push($datesArray, $dateInst);
				}
			}
			$datesArray = array_unique($datesArray);

			foreach ($datesArray as $dateSearch) {
				$conditions['AND'][]['Institution.actions_performed NOT LIKE'] = '%' . $dateSearch . '_' . $action . '%';
				if ($requiredAction) {
					$conditions['OR'][]['Institution.actions_performed LIKE'] = '%' . $dateSearch . '_' . $requiredAction . '%';
				}
			}
		}

		return $conditions;
	}

	public function actionPermission($action) {
		switch($action) {
			case 'outcome_accept':
			case 'outcome_notify':
				return 'admin';
		}
	}

	public function proceeding_outcome_accept($params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			if (empty($params['data']['Institution']['selected'])) {
				return false;
			}

			$return = false;

			$selectedData = Sanitize::clean($params['data']['Institution']['selected']);

			if (!empty($selectedData)) {
				$this->Application->bindModel(
	                array(
	                	'hasOne' => array(
	                        'HeqcProcReview' => array(
	                            'className' => 'Proceeding',
	                            'foreignKey' => 'application_id',
	                            'fields' => array('HeqcProcReview.proc_lkp_outcome_id'),
	                            'conditions' => array(
	                                'HeqcProcReview.proc_status_id' => 'ReviewerComplete',
	                                'HeqcProcReview.proc_date !=' => '1970-01-01',
	                                'HeqcProcReview.heqc_meeting_id >' => ''
	                            )
	                        )
	                    )
	                ), false
	            );

				foreach ($selectedData as $data) {
					$conditions['Application.institution_id'] = $data['Application']['institution_id'];
					$conditions['HeqcProcReview.heqc_meeting_id'] = $data['HeqcMeeting']['id'];
					$conditions['HeqcProcReview.proceeding_type_id'] = $data['ProceedingType']['id'];
					$conditions['HeqcProcReview.outcome_accepted'] = 0;

					$applications = $this->Application->find('all', array(
						'fields' => array('HeqcProcReview.proc_lkp_outcome_id', 'HeqcProcReview.application_id', 'HeqcProcReview.id'),
		            	'conditions' => $conditions,
	                    'contain' => 'HeqcProcReview'
		            ));
		            if (!empty($applications)) {
		            	foreach ($applications as $application) {
		            		$finalOutome = $application['HeqcProcReview']['proc_lkp_outcome_id'];
		            		$update = array(
								'HeqcProcReview.outcome_accepted' => true,
								'HeqcProcReview.outcome_accepted_date' => "NOW()",
								'Application.lkp_outcome_id' => "'$finalOutome'"
							);
							$updateConditions = array(
								'Application.id' => $application['HeqcProcReview']['application_id'],
								'HeqcProcReview.id' => $application['HeqcProcReview']['id']
							);
							if ($this->Application->updateAll($update, $updateConditions)) {
								$return = true;
							}
		            	}
		            }
				}
			}
			return $return;

		}

		return array(
			'listHeading' => __('Institutions whose proceeding outcomes will be accepted:', true)
		);
	}

	public function proceeding_outcome_notify($params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			if (empty($params['data']['Institution']['selected'])) {
				return false;
			}
			$return = false;

			$selectedData = Sanitize::clean($params['data']['Institution']['selected']);
			if (!empty($selectedData)) {
				$this->Application->bindModel(
	                array(
	                	'hasOne' => array(
	                        'HeqcProcReview' => array(
	                            'className' => 'Proceeding',
	                            'foreignKey' => 'application_id',
	                            'fields' => array('HeqcProcReview.proc_lkp_outcome_id'),
	                            'conditions' => array(
	                                'HeqcProcReview.proc_status_id' => 'ReviewerComplete',
	                                'HeqcProcReview.proc_date !=' => '1970-01-01',
	                                'HeqcProcReview.heqc_meeting_id >' => ''
	                            )
	                        )
	                    )
	                ), false
	            );

	            foreach ($selectedData as $data) {
					$conditions['Application.institution_id'] = $data['Application']['institution_id'];
					$conditions['HeqcProcReview.heqc_meeting_id'] = $data['HeqcMeeting']['id'];
					$conditions['HeqcProcReview.proceeding_type_id'] = $data['ProceedingType']['id'];
					$conditions['HeqcProcReview.outcome_accepted'] = 1;
					$conditions['HeqcProcReview.notified'] = 0;

					$applications = $this->Application->find('all', array(
						'fields' => array('HeqcProcReview.heqc_meeting_id', 'HeqcProcReview.application_id', 'HeqcProcReview.id'),
		            	'conditions' => $conditions,
	                    'contain' => 'HeqcProcReview'
		            ));
		            if (!empty($applications)) {
		            	$HeqcProcReviewIds = Set::extract('/HeqcProcReview/id', $applications);
		            	// $applicationIds = Set::extract('/HeqcProcReview/application_id', $applications);
		            	//foreach ($applications as $application) {
		            		//get inst admin
							$instAdm = $this->User->find('all', array(
									'conditions' => array(
										'User.institution_id' => $data['Application']['institution_id'],
									),
									'contain' => array('Role')
								)
							);
							$adminID = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $instAdm));
							//get CHE admin
							$cheAdmin = $this->User->find('all', array(
								'conditions' => array(
									'User.role_id' => '71f77998-544e-11e0-b14b-000c292ff614',
								),
							));

		            		$update = array(
								'HeqcProcReview.notified' => true,
								'HeqcProcReview.notified_date' => "NOW()",
							);
							$updateConditions = array(
								'HeqcProcReview.id' => $HeqcProcReviewIds
							);

							if ($this->Application->updateAll($update, $updateConditions)) {
								$return = true;
							}

							/*
								Email
							*/
							
							if($return){
								$admin = $this->User->findById($adminID);
								$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $admin['User']['email_address'] : Configure::read('Email.debug_address');
								$data = array(
									'to' => $to,
									'subject' => Configure::read('System.email.prefix') . 'Outcomes notification',
									'from' => Configure::read('System.email.from'),
									'template' => 'proceeding_outcome_notification',
									'sendAs' => 'text',
									'variables' => array(
										'admin' => $admin
									)
								);

								//Email
								$this->generateOutcomeNotifyPdf($data);
							}
		            	}
		            //}
				}
			}

			return $return;

		}

		return array(
			'listHeading' => __('Institutions that will be notified of proceeding outcomes:', true)
		);
	}

	public function performAction($params) {
		if (empty($params['form']['action'])) {
			return false;
		}
		$actionsName = $params['form']['action'];
		$result =  $this->{$actionsName}($params); 

		if (is_array($result)) {
			$actionListConditions = $this->actionListConditions($actionsName, $params);

			$actionList = $this->getProceedingListOutcomes($actionListConditions, $params);

			$selected = Set::extract('/Application/institution_id', $actionList);

			$result = array_merge($result, array(
				strtolower('Institutions') => $actionList,
				'selected' => $selected
			));
		}

		return $result;
	}

//@codingStandardsIgnoreStart
	public function outcome_accept($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			/*
				Get all the conditions from the action list conditions as well, and now make new ones, based on what was selected.
				Conditions must be that of the statuses and the outcomes etc
			*/
			$HeqcMeeting = $this->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
			$HeqcMeeting = array_flip($HeqcMeeting);
			$return = false;
			$selected = Sanitize::clean($params['data']['Process']['selected']);
			$conditionData = array();

			foreach ($selected as $dateID => $instID) {
				if ($instID != 0) {
					$dateID = str_replace(substr($dateID, strpos($dateID, '_'), strlen($dateID)), '', $dateID);
					$conditionData[$instID][] = $dateID;
				}
			}

			if (!empty($conditionData)) {
				$conditions = $this->actionListConditions('outcome_accept', array());
				foreach ($conditionData as $instID => $dates) {
					$datesSelected = array();
					$conditions['Application.institution_id'] = $instID;
					$actionsPerformed = '';

					foreach ($dates as $date) {
						array_push($datesSelected, $HeqcMeeting[$date]);
						$actionsPerformed .= $date . '_' . $instID . '_' . 'outcome_accept ';
					}

					$conditions['Application.heqc_meeting_id'] = $datesSelected;

					$data = $this->Application->find('all', array(
						'fields' => array(
							'Application.id',
						),
						'conditions' => $conditions,
						'contain' => 'Institution'
					));
					$applications = Set::extract('/Application/id', $data);

					$update = array(
						'Application.outcome_accepted' => true,
						'Application.outcome_approval_date' => "NOW()",
						'Institution.actions_performed' => "'$actionsPerformed'"
					);

					if ($this->Application->updateAll($update, array('Application.id' => $applications))) {
						$return = true;
					}
				}
			}

			return $return;
		}
		return array(
			'listHeading' => __('Institutions whose outcomes will be accepted:', true)
		);
	}

	public function outcome_notify($process, $params){
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$HeqcMeeting = $this->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
			$HeqcMeeting = array_flip($HeqcMeeting);
			$return = false;
			$selected = Sanitize::clean($params['data']['Process']['selected']);
			$conditionData = array();

			foreach ($selected as $dateID => $instID) {
				if ($instID != 0) {
					$dateID = str_replace(substr($dateID, strpos($dateID, '_'), strlen($dateID)), '', $dateID);
					$conditionData[$instID][] = $dateID;
				}
			}

			if (!empty($conditionData)) {
				$conditions = $this->actionListConditions('outcome_notify', array()); //maybe call it more list conditions, then can put in conditions there coz not called in the process model
				foreach ($conditionData as $instID => $dates) {
					$datesSelected = array();
					$conditions['Application.institution_id'] = $instID;
					$actionsPerformed = '';

					foreach ($dates as $date) {
						array_push($datesSelected, $HeqcMeeting[$date]);
						$actionsPerformed .= $date . '_' . $instID . '_' . 'outcome_notify ' . $date . '_' . $instID . '_outcome_accept';
					}

					$conditions['Application.heqc_meeting_id'] = $datesSelected;

					$data = $this->Application->find('all', array(
						'fields' => array(
							'Application.id',
						),
						'conditions' => $conditions,
						'contain' => 'Institution'
					));

					$applications = Set::extract('/Application/id', $data);
					$instituions = array_unique(Set::extract('/Institution/id', $data));

					//get inst admin
					$instAdm = $this->User->find('all', array(
							'conditions' => array(
								'User.institution_id' => $instID,
							),
							'contain' => array('Role')
						)
					);

					$adminID = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $instAdm));

					//get CHE admin
					$cheAdmin = $this->User->find('all', array(
						'conditions' => array(
							'User.role_id' => '71f77998-544e-11e0-b14b-000c292ff614',
						),
					));

					$bcc = array();

					if (!empty($cheAdmin)) {
						foreach ($cheAdmin as $cheAdminUser) {
							array_push($bcc, $cheAdminUser['User']['email_address']);
						}
					}

					$update = array(
						'Application.notified' => true,
						'Institution.actions_performed' => "'$actionsPerformed'"
					);

					if ($this->Application->updateAll($update, array('Application.id' => $applications))) {
						$return = true;
					}

					/*
						Only once update done, send the email.
					*/

					//generate email contents. Send through the application id's
					$email_content = $this->generateNotifyEmail($applications, $datesSelected);

					/*
						Email
					*/
					
					if($return){
						$admin = $this->User->findById($adminID);
						$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $admin['User']['email_address'] : Configure::read('Email.debug_address');
						$data = array(
							'to' => $to,
							'subject' => Configure::read('System.email.prefix') . 'Outcomes notification',
							'from' => Configure::read('System.email.from'),
							//'bcc' => $bcc,
							'template' => 'outcome_notification',
							'sendAs' => 'text',
							'variables' => array(
								'content' => $email_content,
								'admin' => $admin
							)
						);

						//Email
						$this->generateOutcomeNotifyPdf($data);
					}
					
				}
			}
			return $return;
		}

		return array(
			'listHeading' => __('Institutions that will be notified of outcomes:', true)
		);
	}

//@codingStandardsIgnoreEnd	

	public function alterActionResults($actionResult, $params) {
		$actionResult['selected'] = $params['data']['Process']['selected'];
		return $actionResult;
	}

	public function generateNotifyEmail($applicationIds, $dates) {
		$meetings = $this->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
		$outcomes = $this->Application->Outcome->find('list');
		$results = array();
		$email = '';

		$applications = $this->Application->find('all', array(
			'conditions' => array(
				'Application.id' => $applicationIds
			)
		));

		if (!empty($applications)) {
			foreach ($applications as $application) {
				$qualification = $this->Application->HeqfQualification->find('first', array(
					'fields' => array('qualification_title'),
					'conditions' => array(
						'HeqfQualification.id' => $application['Application']['heqf_qualification_id']
					)
				));
				$results[$meetings[$application['Application']['heqc_meeting_id']]][$outcomes[$application['Application']['lkp_outcome_id']]][] = $qualification['HeqfQualification']['qualification_title'];
			}
		}

		return $results;
	}

/**
 * [_findProcess description]
 * @param  [type] $state  [description]
 * @param  [type] $query  [description]
 * @param  array  $result [description]
 * @return [type]         [description]
 * @throws  Exception If [this condition is met]
 */
	protected function _findProcess($state, $query, $result = array()) {
		if ($state == 'before') {
			$heqcMeetings = $this->Application->HeqcMeeting->find('first',
				array(
					'fields' => array(
						'HeqcMeeting.id'
					),
					'conditions' => array(
						'HeqcMeeting.date' => $query['params']['date']
					)
				)
			);

			$query['conditions'] = array(
				'Institution.id' => $query['conditions']['id']
			);

			$query['contain'] = array(
				'Application' => array(
					'conditions' => array(
						'Application.heqc_meeting_id' => $heqcMeetings['HeqcMeeting']['id']
					),
					'HeqfQualification'
				),
			);

			return $query;
		} else {
			if ($result[0]['Institution']['id'] !== Auth::get('User.institution_id')
					&& (!isset($query['skipAccess']) || $query['skipAccess'] !== true)
					&& !Auth::checkRole('che_admin') && !Auth::checkRole('che_default')
			) {
				throw new Exception(__('You do not have permission to access that application.', true));
			}

			$this->saveAll($result[0], array('validate' => 'only'));

			return $result[0];
		}
	}

/**
 * function to get institution type
 */

	public function institutionType(){
		$institutionType = Auth::get('Institution.priv_publ');
		return ($institutionType) ? $institutionType : '';
	}

}



/*
	Need to make sure that institutions that have already been notified, do not get notified again... NB!!!
	ALTER TABLE `institutions` ADD `outcome_accepted` TINYINT( 1 ) NOT NULL DEFAULT '0';
	ALTER TABLE `institutions` ADD `outcome_notified` TINYINT( 1 ) NOT NULL DEFAULT '0';

	what if for different meetings???? institution will be marked for one meeting as notified/accepted, not other etc

	For the viewing:

		Create a new process
			outcomes_view View all outcomes Institution 0


		INSERT INTO `CHE_heqf_dev`.`processes` (
		`id` ,
		`slug` ,
		`name` ,
		`main_model` ,
		`editable` ,
		`audit_level`
		)
		VALUES (
		'9', 'outcome_list_view', 'View list of outcomes', 'Institution', '0', ''
		);

		Permissions
			figure out how to give permissions for this view
*/