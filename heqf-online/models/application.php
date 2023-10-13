<?php

class Application extends AppModel {

	public $hasOne = array(
		'Evaluation' => array(
			'className' => 'Evaluation',
			'foreignKey' => 'application_id',
			'dependant' => false,
			'order' => 'Evaluation.eval_date ASC',
			'conditions'=> array('Evaluation.eval_inactive' => 0, 'Evaluation.eval_status_id' => 'New')
		),
		'Proceeding' => array(
			'className' => 'Proceeding',
			'foreignKey' => 'application_id',
			'dependant' => false,
			'order' => 'Proceeding.proc_date ASC',
			'conditions'=> array('Proceeding.proc_inactive' => 0, 'Proceeding.proc_status_id' => 'InstNew')
		),
		'SubmittedProceeding' => array(
			'className' => 'Proceeding',
			'foreignKey' => 'application_id',
			'dependant' => false,
			'order' => 'SubmittedProceeding.proc_date ASC',
			'conditions'=> array('SubmittedProceeding.proc_inactive' => 0, 'SubmittedProceeding.proc_status_id' => 'InstComplete')
		),
		'ReviewProceeding' => array(
			'className' => 'Proceeding',
			'foreignKey' => 'application_id',
			'dependant' => false,
			'order' => 'ReviewProceeding.proc_date ASC',
			'conditions'=> array('ReviewProceeding.proc_inactive' => 0, 'ReviewProceeding.proc_status_id' => 'ReviewerNew')
		),
		'LastReviewiedProceeding' => array(
			'className' => 'Proceeding',
			'foreignKey' => 'application_id',
			'dependant' => false,
			'order' => 'LastReviewiedProceeding.proc_date DESC',
			'conditions' => array(
				'LastReviewiedProceeding.proc_lkp_outcome_id >' => '',
				'LastReviewiedProceeding.proc_inactive' => 1,
				'LastReviewiedProceeding.proc_status_id' => 'ReviewerComplete',
				'LastReviewiedProceeding.proc_date !=' => '1970-01-01',
				'LastReviewiedProceeding.heqc_meeting_id' => ''
				)
		),	
		'EvaluationWithNI' => array(
			'className' => 'Evaluation',
			'foreignKey' => 'application_id',
			'dependant' => false,
			'order' => 'EvaluationWithNI.eval_date ASC',
			'conditions'=> array(
				'EvaluationWithNI.eval_inactive' => 1, 
				'EvaluationWithNI.eval_date != ' => '1970-01-01',
				'OR' => array(
					array('EvaluationWithNI.s3_curriculum_lkp_outcome_id' => 'ni'),
					array('EvaluationWithNI.s3_modules_lkp_outcome_id' => 'ni'),
					array('EvaluationWithNI.s3_assessment_lkp_outcome_id' => 'ni')
				)
			)
		)
	);

	public $belongsTo = array(
		'HeqfQualification' => array(
			'contain' => 'QualificationType'
		),
		'User' => array(
			'className' => 'OctoUsers.User'
		),
		'SubmitUser' => array(
			'className' => 'OctoUsers.User',
			'foreignKey' => 'submission_user_id',
		),
		'EvalUser' => array(
			'className' => 'OctoUsers.User',
			'foreignKey' => 'evaluation_user_id',
		),
		'ReviewUser' => array(
			'className' => 'OctoUsers.User',
			'foreignKey' => 'review_user_id',
		),
		'ChecklistUser' => array(
			'className' => 'OctoUsers.User',
			'foreignKey' => 'checklisting_user_id',
		),
		'Institution',
		'ChecklistingStatus' => array(
			'className' => 'Lookups.ChecklistingStatus',
			'foreignKey' => 'checklisting_status_id',
		),
		'AppHeqfAlign' => array(
			'className' => 'Lookups.HeqfAlign',
			'foreignKey' => 'lkp_heqf_align_id',
		),
		'Outcome' => array(
			'className' => 'Lookups.Outcome',
			'foreignKey' => 'lkp_outcome_id',
		),
		'ProceedingType' => array(
			'className' => 'Lookups.ProceedingType',
			'foreignKey' => 'lkp_proceeding_type_id',
		),
		'EvaluationStatus' => array(
			'className' => 'Lookups.EvaluationStatus',
			'foreignKey' => 'evaluation_status_id',
		),
		'ReviewStatus' => array(
			'className' => 'Lookups.ReviewStatus',
			'foreignKey' => 'review_status_id',
		),
		'ApplicationStatus' => array(
			'className' => 'Lookups.ApplicationStatus',
			'foreignKey' => 'application_status',
		),
		'HeqcMeeting'
	);

	public $validate = array(
		'heqc_meeting' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select a meeting date.'
			)
		),
		'review_comments' => array(
			'rule' => 'validateReviewComent',
			'message' => 'It is required to fill in the comment field'
		),
		'review_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select a Review oucome'
			)
		)

	);

	public $status = array(
			'New' => 'New',
			'Submitted' => 'Submitted',
			'Submitted (after checklisting corrections)' => 'Submitted (after checklisting corrections)',
			'In checklisting' => 'In checklisting',
			'Checklisted' => 'Checklisted',
			'Checklisted (return)' => 'Checklisted (return)',
			'In evaluation' => 'In evaluation',
			'Evaluated' => 'Evaluated',
			'In review' => 'In review',
			'Reviewed' => 'Reviewed',
			'Reviewed (return)' => 'Reviewed (return)',
			'Re-submitted (after review)' => 'Re-submitted (after review)',
			'Representation (Institution)' => 'Representation (Institution)',
			'Deferral (Institution)' => 'Deferral (Institution)',
			'Representation (Submitted)' => 'Representation (Submitted)',
			'Deferral (Submitted)' => 'Deferral (Submitted)',
			'Representation (Reviewer)' => 'Representation (Reviewer)',
			'Deferral (Reviewer)' => 'Deferral (Reviewer)',
			'Representation (Processed)' => 'Representation (Processed)',
			'Deferral (Processed)' => 'Deferral (Processed)',
				//'Inactive' => 'Inactive'
		);

	public $actsAs = array(
		'Search.Searchable',
		'OctoLog.AuditLog' => array(
			'userModel' => 'OctoUsers.User'
		)
	);

	public $presetVars = array(
		'app_alignment_report' => array(
			array('field' => 's1_qualification_reference_no', 'type' => 'value', 'encode' => true),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
			array('field' => 'archived', 'type' => 'value'),
			array('field' => 'lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'status', 'type' => 'value'),
			array('field' => 'qualification_title', 'type' => 'value'),
			array('field' => 's1_qualification_title', 'type' => 'value'),
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_qualification_type_id', 'type' => 'value'),
			array('field' => 's1_lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'heqc_meeting_id', 'type' => 'value'),
			array('field' => 'submission_from_date', 'type' => 'value'),
			array('field' => 'submission_to_date', 'type' => 'value'),
			array('field' => 'lkp_cesm1_code_id', 'type' => 'value'),
			array('field' => 'keyword', 'type' => 'value'),
			array('field' => 'lkp_outcome_id', 'type' => 'value'),
			array('field' => 'lkp_proceeding_type_id', 'type' => 'value'),
			array('field' => 'proceeding_meeting_date', 'type' => 'value'),
		),
		'outcome_summary_report' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'heqc_meeting_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'outcome_alignment_applications' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'list_outcomes_report' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'heqc_meeting_id', 'type' => 'value'),
			array('field' => 's1_lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'lkp_outcome_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'institution_offerings' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'institution_submissions' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'application_totals' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'reminderReport' => array(
			array('field' => 's1_lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'qualification_title', 'type' => 'value'),
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'status', 'type' => 'value'),
			array('field' => 'currentUser', 'type' => 'value'),
		)
	);

	public $filterArgs = array(
		array('name' => 'lkp_proceeding_type_id', 'type' => 'value', 'field' => 'Application.lkp_proceeding_type_id'),
		array('name' => 'lkp_heqf_align_id', 'type' => 'value'),
		array('name' => 'lkp_outcome_id', 'type' => 'query', 'method' => 'searchOutcome'),
		array('name' => 's1_qualification_title', 'type' => 'query', 'method' => 'searchSOneQualTitle'),
		array('name' => 'qualification_title', 'type' => 'query', 'method' => 'searchQualTitle'),
		array('name' => 'status', 'type' => 'query', 'method' => 'searchStatus'),
		array('name' => 's1_lkp_heqf_align_id', 'type' => 'query', 'method' => 'searchAlignCat'),

		array('name' => 'lkp_cesm1_code_id', 'type' => 'query', 'method' => 'searchCesm'),
		array('name' => 'lkp_delivery_mode_id', 'type' => 'query', 'method' => 'searchModeOfDelivery'),
		array('name' => 'keyword', 'type' => 'query', 'method' => 'searchKeyword'),

		array('name' => 'institution_id', 'type' => 'value'),
		array('name' => 'heqc_meeting_id', 'type' => 'value'),
		array('name' => 'lkp_qualification_type_id', 'type' => 'query', 'method' => 'searchQualType'),
		array('name' => 'submission_from_date', 'type' => 'query', 'method' => 'searchSubmissionDate'),
		array('name' => 'submission_to_date', 'type' => 'query', 'method' => 'searchSubmissionDate'),

		array('name' => 'basic', 'type' => 'query', 'method' => 'searchBasic'),
		array('name' => 'categoryInst', 'type' => 'value', 'field' => 'HeqfQualification.s1_lkp_heqf_align_id'),
		array('name' => 'categoryChe', 'type' => 'value', 'field' => 'Application.lkp_heqf_align_id'),
		array('name' => 'institution', 'type' => 'value', 'field' => 'Institution.id'),
		array('name' => 'qual_type', 'type' => 'value', 'field' => 'HeqfQualification.lkp_qualification_type_id'),
		// array('name' => 'evaluator', 'type' => 'value', 'field' => 'Application.evaluation_user_id'),
		array('name' => 'evaluator', 'type' => 'query', 'method' => 'searchEvaluator'),
		array('name' => 'meeting_date', 'type' => 'value', 'field' => 'Application.heqc_meeting_id'),
		array('name' => 'currentUser', 'type' => 'value', 'field' => 'Application.user_id'),
		array('name' => 'cesm', 'type' => 'value', 'field' => 'HeqfQualification.lkp_cesm1_code_id'),
		array('name' => 's1_qualification_reference_no', 'type' => 'query', 'method' => 'searchQualRef'),
		array('name' => 'proceeding_meeting_date', 'type' => 'query', 'method' => 'searchProcMeetingDate'),
		array('name' => 'archived', 'type' => 'query', 'method' => 'searchArchived'),
		
	);
	public $mayReturnFalse = array(
		'upload-proceeding-document',
		'review'
	);
	public $reviewPaginateFields = array(
		'Application.id',
		'Application.institution_id',
		'Application.heqf_qualification_id',
		'Application.evaluation_status_id',
		'Application.user_id',
		'Application.lkp_heqf_align_id',
		'Application.application_status',
		'Application.lkp_outcome_id',
		'Outcome.outcome_desc',
		'CompletedEvaluations.application_correctly_categorised',
		'CompletedEvaluations.qualification_type_aligned',
		'CompletedEvaluations.nqf_level_aligned',
		'CompletedEvaluations.total_credits_aligned',
		'CompletedEvaluations.programme_correctly_titled',
		'CompletedEvaluations.application_id',
		'CompletedEvaluations.eval_comments',
		'CompletedEvaluations.eval_lkp_outcome_id',
		'CompletedEvaluations.eval_date',
		'CompletedEvaluations.s3_curriculum_comment',
		'CompletedEvaluations.s3_module_comment',
		'CompletedEvaluations.s3_assessment_comment',
		'CompletedEvaluations.s3_learning_activities_comment',
		'CompletedEvaluations.s3_workplace_comment',
		'CompletedEvaluations.request_second_evaluation_comment',
		'CompletedEvaluations.eval_outcome_comment',
		'CompletedEvaluations.s3_curriculum_lkp_outcome_id',
		'CompletedEvaluations.s3_modules_lkp_outcome_id',
		'CompletedEvaluations.s3_assessment_lkp_outcome_id',
		'CompletedEvaluations.s3_learning_activities_lkp_outcome_id',
		'CompletedEvaluations.s3_workplace_explained_lkp_outcome_id'
	);
	
	public function searchProcMeetingDate($data) {
		$this->bindModel(
            array('hasMany' => array(
                    'HeqcProceedings' => array(
                        'className' => 'Proceeding',
                        'foreignKey' => 'application_id',
                        'conditions' => array(
                            'HeqcProceedings.heqc_meeting_id !=' => ''
                        )
                    )
                )
            )
        );

		$proceedings = $this->HeqcProceedings->find('all', array(
			'fields' => array('HeqcProceedings.application_id'),
			'conditions' => array('HeqcProceedings.heqc_meeting_id' => $data['proceeding_meeting_date']),
		));
		$applicationIds = Set::extract('/HeqcProceedings/application_id', $proceedings);

        return array(
			'Application.id' => $applicationIds
		);
	}

	public function searchStatus($data) {
		if (isset($this->status[$data['status']])) {
			return $this->statusConditions($this->status[$data['status']]);
		}
	}

	public function searchEvaluator($data) {
		$this->bindModel(
            array('hasMany' => array(
                    'CompletedEvaluations' => array(
                        'className' => 'Evaluation',
                        'foreignKey' => 'application_id',
                        'conditions' => array(
                            'CompletedEvaluations.eval_status_id' => array('Complete', 'Request'),
                            'CompletedEvaluations.eval_date !=' => '1970-01-01'
                        )
                    )
                )
            )
        );

        return array(
			'CompletedEvaluations.eval_user_id' => $data['evaluator']
		);
	}
	
	public function searchArchived($data) {
		return array(
			'Application.archived' => $data['archived']
		);
	}

	public function searchOutcome($data) {
		return array(
			'Application.lkp_outcome_id' => $data['lkp_outcome_id'],
			'Application.user_id' => ''
		);
	}
	
	public function searchQualRef($data) {
		return array(
			'HeqfQualification.s1_qualification_reference_no LIKE' =>  $data["s1_qualification_reference_no"]
		);
	}
	public function searchCesm($data) {
		return array(
			'HeqfQualification.lkp_cesm1_code_id' => $data['lkp_cesm1_code_id']
		);
	}

	public function searchModeOfDelivery($data) {
		return array(
			'HeqfQualification.lkp_delivery_mode_id' => $data['lkp_delivery_mode_id']
		);
	}
	public function searchBasic($data, $field) {
		$search = $data[$field['name']];
		return array(
			'OR' => array(
				'HeqfQualification.qualification_title LIKE' => '%' . $search . '%',
				'HeqfQualification.qualification_reference_no LIKE' => '%' . $search . '%'
			)
		);
	}

	public function searchKeyword($data) {
		return array(
			'OR' => array(
				'HeqfQualification.qualification_title LIKE' => '%' . $data['keyword'] . '%',
				'HeqfQualification.s1_qualification_title LIKE' => '%' . $data['keyword'] . '%',
			)
		);
	}

	public function searchSOneQualTitle($data) {
		return array(
			'HeqfQualification.s1_qualification_title LIKE' => '%' . $data['s1_qualification_title'] . '%'
		);
	}

	public function searchQualTitle($data) {
		return array(
			'HeqfQualification.qualification_title LIKE' => '%' . $data['qualification_title'] . '%'
		);
	}

	public function searchAlignCat($data) {
		return array(
			'HeqfQualification.s1_lkp_heqf_align_id' => $data['s1_lkp_heqf_align_id']
		);
	}

	public function searchQualType($data) {
		return array(
			'HeqfQualification.lkp_qualification_type_id' => $data['lkp_qualification_type_id']
		);
	}

	public function searchSubmissionDate($data) {
		$conditions = array();

		if (isset($data['submission_from_date'])) {
			$conditions['Application.submission_date >='] = $data['submission_from_date'];
		}

		if (isset($data['submission_to_date'])) {
			$conditions['Application.submission_date <='] = $data['submission_to_date'];
		}

		return $conditions;
	}

	public function validateReviewComent() {
		if (!empty($this->data['Application']['review_outcome_id']) && ($this->data['Application']['review_outcome_id'] == 'ni' || $this->data['Application']['review_outcome_id'] == 'nr') && empty($this->data['Application']['review_comments'])) {		
			return false;
		}

		return true;
	}

public function statusConditions($status) {
		$conditions = array();

		switch ($status) {
			case 'New':
				$conditions = array(
					'Application.submission_date' => '1970-01-01',
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.checklisting_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01'
				);
				break;
			case 'Submitted':
				$conditions = array(
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.checklisting_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_status_id' => null,
					'Application.returned_from_checklisting' => '0'
				);
				break;
			case 'Submitted (after checklisting corrections)':
				$conditions = array(
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.checklisting_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_status_id' => null,
					'Application.returned_from_checklisting' => '1'
				);
				break;
			case 'In checklisting':
				$conditions = array(
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.checklisting_status_id' => 'New',
					'Application.submission_date !=' => '1970-01-01'
				);
				break;
			case 'Checklisted':
				$conditions = array(
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => '',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01'
				);
				break;
			case 'Checklisted (return)':
				$conditions = array(
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.checklisting_status_id' => 'Return',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.evaluation_status_id' => '',
				);
				break;
			case 'In evaluation':
				$conditions = array(
					//'Application.evaluation_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'New',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01'
				);
				break;
			case 'Evaluated':
				$conditions = array(
					'Application.review_date' => '1970-01-01',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					// 'Application.evaluation_date !=' => '1970-01-01',
					'Application.review_status_id' => null
				);
				break;
			case 'In review':
				$conditions = array(
					'Application.review_date' => '1970-01-01',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'New',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01'//,
					// 'Application.evaluation_date !=' => '1970-01-01'
				);
				break;
			case 'Reviewed':
				$conditions = array(
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.application_status' => 'Review',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					// 'Application.evaluation_date !=' => '1970-01-01',
					'Application.review_date !=' => '1970-01-01'
				);
				break;
			case 'Representation (Institution)':
				$conditions = array(
					'Application.user_id !=' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'InstNew',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'r'
				);
				break;
			case 'Deferral (Institution)':
				$conditions = array(
					'Application.user_id !=' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'InstNew',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'd'
				);
				break;
			case 'Representation (Submitted)':
				$conditions = array(
					'Application.user_id' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'InstComplete',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'r'
				);
				break;
			case 'Deferral (Submitted)':
				$conditions = array(
					'Application.user_id' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'InstComplete',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'd'
				);
				break;
			case 'Representation (Reviewer)':
				$conditions = array(
					'Application.user_id !=' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'ReviewerNew',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'r'
				);
				break;
			case 'Deferral (Reviewer)':
				$conditions = array(
					'Application.user_id !=' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'ReviewerNew',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'd'
				);
				break;
			case 'Representation (Processed)':
				$conditions = array(
					'Application.user_id' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'ReviewerComplete',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'r'
				);
				break;
			case 'Deferral (Processed)':
				$conditions = array(
					'Application.user_id' => '',
					'Application.application_status' => 'Proceeding',
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Reviewed',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					'Application.proceeding_status_id' => 'ReviewerComplete',
					'Application.review_date !=' => '1970-01-01',
					'Application.lkp_proceeding_type_id' => 'd'
				);
				break;

			case 'Reviewed (return)':
				$conditions = array(
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Return',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					// 'Application.evaluation_date !=' => '1970-01-01',
					'Application.review_date !=' => '1970-01-01'
				);
				break;
			case 'Inactive':
				$conditions = array(
					'Application.application_status' => 'Inactive'
				);
				break;
			case 'Re-submitted (after review)':
				$conditions = array(
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Returned',
					'Application.submission_date !=' => '1970-01-01',
					'Application.resubmission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					// 'Application.evaluation_date !=' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.application_status' => 'RenewEdited',
					'Application.review_error' => '0'
				);
				break;
		}

		return $conditions;
	}	

	private function __getLookupFields() {
		$fields = array();

		$fields['status'] = $this->status;
		$fields['evaluator'] = array();

		$this->User->Role->bindModel(array(
			'hasAndBelongsToMany' => array(
				'UserMany' => array(
					'className' => 'OctoUsers.User',
					'joinTable' => 'roles_users'
				)
			)
		));
		 $userRoles = $this->User->Role->find('first', array(
		 	'conditions' => array(
		 		'Role.id' => '98dbb5f8-e36c-11e0-a1b9-000c292ff614'
		 	),
			'fields' => array(
				'Role.id',
			),
			'contain' => array(
				'UserMany'
			)
		));
		$fields['evaluator'] = Set::combine($userRoles, 'UserMany.{n}.id', 'UserMany.{n}.name');
		$currentUserCondition = (Auth::checkRole('che_admin')) ? $this->User->find('list') : $this->User->find('list', array(
			'conditions' => array(
			'User.institution_id' => Auth::get('User.institution_id')
			)
			)
		);

		$fields['currentUser'] = $currentUserCondition;

		return $fields;
	}

	public function viewVariables($view, $params) {		
		$fields = $this->__getLookupFields();
		$applicationsInformation = $this->__getApplicationsInformation($params);		
		return compact('fields', 'applicationsInformation');
	}

	public function standardContains($view, $params) {
		$contain = array(
			'HeqfQualification' => array(
				'fields' => array(
					'HeqfQualification.s1_qualification_title',
					'HeqfQualification.qualification_title',
					'HeqfQualification.qualification_title_orig',
					'HeqfQualification.s1_lkp_heqf_align_id',
					'HeqfQualification.qualification_reference_no',
					'HeqfQualification.s1_qualification_reference_no',
					'HeqfQualification.disable_delete',
					'HeqfQualification.lkp_qualification_type_id',
					'HeqfQualification.heqf_reference_no',
					'HeqfQualification.s1_credits_total',
					'HeqfQualification.lkp_cesm1_code_id'
				),
				'QualificationType'
			),
			'User' => array(
				'fields' => array(
					'User.first_name',
					'User.last_name',
					'User.email_address'
				)
			)						 
		);

		

		if (Auth::checkRole('che_admin') || Auth::checkRole('che_default') || Auth::checkRole('evaluator') || Auth::checkRole('checklister') || Auth::checkRole('reviewer')) {
			$contain['Institution'] = array(
				'fields' => array(
					'Institution.hei_name',
					'Institution.hei_code'
				)
			);
			$contain['SubmitUser'] = array(
				'fields' => array(
					'SubmitUser.email_address'
				)
			);
			$contain[] = 'ReviewUser';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.s1_error';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.s2_error';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.s3_error';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.apx_B';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.modified';
			$contain[] = 'Outcome';			
		}
		 else {
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.s1_error';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.s2_error';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.s3_error';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.apx_B';
			$contain['HeqfQualification']['fields'][] = 'HeqfQualification.modified';
			$contain[] = 'Outcome';
		}

		if (Auth::checkRole('inst_admin') && isset($params["process-slug"]) && $params["process-slug"] == 'upload-proceeding-document') {
			$contain[] = 'Proceeding';		
		}

		if((Auth::checkRole('reviewer') && isset($params["process-slug"]) && $params["process-slug"] == 'review')){
			$contain[] = 'ReviewProceeding';
		}

		return $contain;
	}

	public function paginateParams($view, $paginate, $params) {
		if(Auth::checkRole('reviewer') && isset($params["process-slug"]) && $params["process-slug"] == 'review'){
			$join = array(
				array('table' => 'evaluations',
					'alias' => 'CompletedEvaluations',
					'type'=> 'Left',
					'conditions' => array(
						'Application.id = CompletedEvaluations.application_id'
					)
				)
            );

			$paginate['joins'] = $join;
	        $paginate['conditions']['CompletedEvaluations.eval_status_id'] = array('Complete', 'Request');
	        $paginate['conditions']['NOT']['CompletedEvaluations.eval_date'] = '1970-01-01';
	        $paginate['group'] = array('Application.id');
	       
	        $paginate['order'] = array(
	        	"Institution.hei_name",
				"FIELD(CompletedEvaluations.s3_curriculum_lkp_outcome_id, 'ni') DESC",
				"FIELD(CompletedEvaluations.s3_modules_lkp_outcome_id, 'ni') DESC",
				"FIELD(CompletedEvaluations.s3_assessment_lkp_outcome_id, 'ni') DESC"
				
			);
		}

		return $paginate;
	}

	public function standardConditions($view, $params) {
		if (!isset($params['process-slug'])) {
			$conditions['Application.application_status'] = 'None';
			return $conditions;
		}



		set_time_limit(0);
		$conditions = array();
		$conditions['Application.inactive'] = 0;
		// $conditions['Application.archived'] = 0;
		// A user will need to access applications according to more than 1 role e.g. CHE admin and reviewer, CHE user and checklister.
		// che_admin and che_default role relate to applications.
		switch ($params["process-slug"]) {
			case 'application-cat-b':
			case 'appendix':
			case 'application-requirements':
			case 'application':
				if (!Auth::checkRole('che_admin') && !Auth::checkRole('che_default')) {
					if (!Auth::checkRole('inst_admin')) {
						$conditions['Application.user_id'] = Auth::get('User.id');
					}

					if (Auth::get('User.institution_id') !== 0) {
						$conditions['Application.institution_id'] = Auth::get('User.institution_id');
					}
				} else {// che user or administrator
					$conditions['not']['Application.application_status'] = array('New'); //Want to add - just not sure of what 'OR' is yet
					$conditions['Application.submission_date !='] = '1970-01-01';
					$conditions['Application.review_error'] = '0';
					//$conditions['Application.application_status'] = 'Reviewed';

				}
				break;
			case 'checklist':
				//In order to checklist, a user must have the checklister role, and applications that are in 'Checklisting' must be assigned to them.
				if (Auth::checkRole('checklister')) {
					$conditions['Application.user_id'] = Auth::get('User.id');
					$conditions['Application.application_status'] = 'Checklisting';
				} else {
					// No status 'None'. Don't display any applications by default.
					$conditions['Application.application_status'] = 'None';
				}
				break;
			case 'evaluate':
				//In order to evaluate, a user must have the evaluator role, and applications that are in 'Evaluation' must be assigned to them.
				if (Auth::checkRole('evaluator')) {
					//$conditions['Application.user_id'] = Auth::get('User.id');
					$conditions['Application.application_status'] = 'Evaluation';
					$conditions['Application.user_id'] = Auth::get('User.id');
					$conditions['Application.evaluation_status_id'] = 'New';										
					// $conditions['Evaluation.eval_user_id'] = Auth::get('User.id');
					// $conditions['Evaluation.eval_status_id'] = 'New';
				} else {
					// No status 'None'. Don't display any applications by default.
					$conditions['Application.application_status'] = 'None';
				}
				break;
			case 'review':
				if (Auth::checkRole('reviewer')) {
					$initApp['Application.user_id'] = Auth::get('User.id');
					$initApp['Application.application_status'] = array('Review');

					$procApp['Application.user_id'] = Auth::get('User.id');
					$procApp['Application.application_status'] = 'Proceeding';
					$procApp['Application.proceeding_status_id'] = 'ReviewerNew';

					$conditions['OR'] = array($initApp, $procApp);

				} else {
					$conditions['Application.application_status'] = 'None';
				}
				break;
			case 'upload-proceeding-document':
				if (Auth::checkRole('inst_admin')) {
					$conditions['Application.user_id'] = Auth::get('User.id');
					$conditions['Application.application_status'] = 'Proceeding';
					$conditions['Application.proceeding_status_id'] = 'InstNew';
					$conditions['Application.lkp_proceeding_type_id'] = array('r', 'd');
				} else {
					$conditions['Application.application_status'] = 'None';
				}
				break;
			default:
				// No status 'None'. Don't display any applications by default.
				$conditions['Application.application_status'] = 'None';
				break;
		}
		
		if (isset($params['named']['error']) && isset($params['named']['status']) && $params['named']['error'] == true && $params['named']['status'] == 'New') {
			$conditions['OR']['HeqfQualification.s1_error'] = true;
			$conditions['OR']['HeqfQualification.s2_error'] = true;
			$conditions['OR']['HeqfQualification.s3_error'] = true;
			$conditions['Application.application_status'] = 'New';
		} elseif (isset($params['named']['status']) && $params['named']['status'] == 'New') {
			$conditions['HeqfQualification.s1_error'] = false;
			$conditions['HeqfQualification.s2_error'] = false;
			$conditions['Application.application_status'] = 'New';
		} elseif (isset($params['named']['status']) && $params['named']['status'] == 'Submitted') {
			$conditions['Application.submission_date !='] = '1970-01-01';
			$conditions['Application.application_status !='] = 'RenewEdited';
			$conditions['OR']['Application.review_status_id !='] = 'Returned';
			$conditions['OR']['Application.review_status_id'] = null;
		} elseif (isset($params['named']['status']) && $params['named']['status'] == 'Requirements') {
			$conditions['Application.submission_date !='] = '1970-01-01';
			$conditions['Application.application_status'] = 'RenewEdited';
			$conditions['Application.review_status_id'] = 'Returned';
		} elseif (isset($params['named']['status']) && $params['named']['status'] == 'AppendixB') {
			$conditions['HeqfQualification.apx_B'] = true;
		}

		return $conditions;
	}

	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
	    $parameters = compact('conditions');
	    $this->recursive = $recursive;
	    $count = $this->find('count', array_merge($parameters, $extra));
	    if (isset($extra['group'])) {
	        $count = $this->getAffectedRows();
	    }
	    return $count;
	}

	public function listSearchParams($params) {
		$presetVars = array(
			array('field' => 's1_qualification_reference_no', 'type' => 'value', 'encode' => true),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
			array('field' => 'archived', 'type' => 'value'),
			array('field' => 'basic', 'type' => 'value'),
			array('field' => 'categoryInst', 'type' => 'value'),
			array('field' => 'categoryChe', 'type' => 'value'),
			array('field' => 'status', 'type' => 'value'),
			array('field' => 'institution', 'type' => 'value'),
			array('field' => 'lkp_proceeding_type_id', 'type' => 'value'),
			array('field' => 'proceeding_meeting_date', 'type' => 'value'),
			array('field' => 'qual_type', 'type' => 'value'),
			array('field' => 'evaluator', 'type' => 'value'),
			array('field' => 'meeting_date', 'type' => 'value'),
			array('field' => 'submission_from_date', 'type' => 'value'),
			array('field' => 'submission_to_date', 'type' => 'value'),
			array('field' => 'currentUser', 'type' => 'value'),
			array('field' => 'cesm', 'type' => 'value'),
			array('field' => 'keyword', 'type' => 'value'),
			array('field' => 'lkp_outcome_id', 'type' => 'value')
		);

		return $presetVars;
	}

	private function __getHeqcMeetings() {
		$meetings = $this->HeqcMeeting->find('list');

		$return = array();
		foreach ($meetings as $id => $date) {
			$return['meeting-' . $date] = array(
				'Application.heqc_meeting_id' => $id
			);
		}
		return $return;
	}

	private function __getApplicationsInformation($params) {
		$validProcesses = array(
			'application-cat-b',
			'appendix',
			'application-requirements',
			'application',
		);
		if (!isset($params['process-slug']) || !in_array($params['process-slug'], $validProcesses) || !(Auth::checkRole('che_admin') || Auth::checkRole('che_default'))) {
			return null;
		}

		$return = array();
		$sumFields = array(
			'Total' => array(
				'Application.archived' => array(0, 1),
			),
			'New' => array(
				'Application.application_status' => 'New',
			),
			'Archived' => array(
				'Application.archived' => 1,
			),
			'Submitted' => array(
				'Application.submission_date >' => '1970-01-01'
			),
			'Submitted (after checklisting corrections)' => array(
				'Application.submission_date >' => '1970-01-01',				
				'Application.returned_from_checklisting' => '1',
				'Application.checklisting_status_id' => null,
			),

			'To be check-listed' => array(
				'Application.application_status' => 'Submitted',
			),
			'In check-listing' => array(
				'Application.application_status' => 'Checklisting',
				'Application.checklisting_status_id' => 'New',
			),
			'Return check' => array(
				'Application.application_status' => 'Checklisting',
				'Application.checklisting_status_id' => 'Return',
			),
			'Complete check' => array(
				'Application.checklisting_status_id' => 'Evaluate',
			),

			'To be evaluated' => array(
				'Application.application_status' => 'Checklisting',
				'Application.checklisting_status_id' => 'Evaluate',
			),

			'In Evaluation' => array(
				'Application.evaluation_status_id' => 'New',
				'Application.checklisting_status_id' => 'Evaluate',
			),
			'Evaluated' => array(
				'Application.evaluation_status_id' => 'Complete',
			),

			'To be reviewed' => array(
				'Application.application_status' => 'Evaluation',
				'Application.evaluation_status_id' => 'Complete',
			),
			'In review' => array(
				'Application.application_status' => 'Review',
				'Application.review_status_id' => 'New',
			),
			'Return review' => array(
				'Application.application_status' => 'Review',
				'Application.review_status_id' => 'Return',
			),
			'Complete review' => array(
				'Application.application_status' => 'Review',
				'Application.review_status_id' => 'Reviewed',
			),
			'Institution review' => array(
				'Application.application_status' => 'RenewEdited',
				'Application.user_id !=' => '',
			),
			'Re-submitted (after review)' => array(
				'Application.review_status_id' => 'Returned',
				'Application.application_status' => 'RenewEdited',
				'Application.user_id' => '',
			),
			'Representation (Institution)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'InstNew',
				'Application.lkp_proceeding_type_id' => 'r',
			),
			'Deferral (Institution)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'InstNew',
				'Application.lkp_proceeding_type_id' => 'd',
			),
			'Representation (Submitted)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'InstComplete',
				'Application.lkp_proceeding_type_id' => 'r',
			),
			'Deferral (Submitted)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'InstComplete',
				'Application.lkp_proceeding_type_id' => 'd',
			),
			'Representation (Reviewer)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'ReviewerNew',
				'Application.lkp_proceeding_type_id' => 'r',
			),
			'Deferral (Reviewer)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'ReviewerNew',
				'Application.lkp_proceeding_type_id' => 'd',
			),
			'Representation (Processed)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'ReviewerComplete',
				'Application.lkp_proceeding_type_id' => 'r',
			),
			'Deferral (Processed)' => array(
				'Application.application_status' => 'Proceeding',
				'Application.review_status_id' => 'Reviewed',
				'Application.proceeding_status_id' => 'ReviewerComplete',
				'Application.lkp_proceeding_type_id' => 'd',
			)
		);
		$sumFields = array_merge($sumFields, $this->__getHeqcMeetings());
		$sumFields = array_merge($sumFields, array(
			'Outcome Accepted' => array(
				'Application.outcome_accepted' => 1,
			),
			'Inst Notified' => array(
				'Application.notified' => 1,
			),

			'Inactive' => array(
				'Application.inactive' => 1,
			),
		));

		$this->virtualFields = array();
		$this->__buildVirtualSumFields($sumFields);

		$fields = array_keys($this->virtualFields);

		$return = $this->find('all', array(
			'fields' => $fields,
			'contain' => array(
				'HeqfQualification' => array(
					'fields' => array(
						's1_lkp_heqf_align_id'
					)
				),
				'Institution'
			),
			'conditions' => array(
				'Application.archived' => array(0, 1),
				'Application.inactive' => array(0, 1),
			),
			'group' => 'HeqfQualification.s1_lkp_heqf_align_id',
			'order' => 'HeqfQualification.s1_lkp_heqf_align_id'
		));

		$this->virtualFields = array();
		return $return;
	}

	/*protected function _getApplicationStatusSql($data){
		$query = $this->getQuery('all', array(
            'conditions' => $data,
            'fields' => array('Evaluation.application_id'),
            'contain' => array('Evaluation')
		 ));

		 return $query;		
	}*/

/**
 * [_findProcess description]
 * @param  [type] $state  [description]
 * @param  [type] $query  [description]
 * @param  array  $result [description]
 * @return [type]         [description]
 * @throws Exception
 */
	protected function _findProcess($state, $query, $result = array()) {
		if ($state == 'before') {
			if (isset($query['conditions']['flow'])) {
				switch ($query['conditions']['flow']) {
					case 'checklist_form' :
						$query['skipAccess'] = (Auth::checkRole('checklister')) ? true : false;
						break;
					case 'evaluate_form' :
					case 'evaluate_form_cat_b':
						$query['skipAccess'] = (Auth::checkRole('evaluator')) ? true : false;
						break;
					case 'section-1':
						$query['skipAccess'] = (Auth::checkRole('evaluator')) || (Auth::checkRole('reviewer'))  ? true : false;
						break;
					case 'view_application' :
					case 'review_form':
						$query['skipAccess'] = (Auth::checkRole('reviewer')) ? true : false;
						break;
				}
			}

	

			$query['conditions'] = array(
				'Application.id' => $query['conditions']['id']
			);

			$query['contain'] = array(
				'HeqfQualification' => array(
					'S1QualificationSite',
					'HeqfQualificationSite',
					'HeqfQualificationModule' => array(
						'InstitutionModule',
						'order' => array(
							'HeqfQualificationModule.year',
							'HeqfQualificationModule.compulsory' => 'DESC'
						)
					),
					'ProgrammeAssessmentApproach'
				),
				'Institution' => array(
					'order' => array(
						'Institution.hei_name'
					)
				)
			);
			if (Auth::checkRole('che_admin')) {
				$query['contain'][]	= 'ReviewProceeding';
			}

			if ((Auth::checkRole('evaluator') || Auth::checkRole('che_admin'))) { //only append evaluator array when role is Evaluator
				$query['contain'][]	= 'Evaluation';
			}
			if ((Auth::checkRole('inst_admin'))) { //only append Proceeding array when role is institutional administrator
				$query['contain'][]	= 'Proceeding';
			}
			
			if (Auth::checkRole('reviewer')) {
				$this->bindModel(
	                array(
	                	'hasMany' => array(
	                        'CompletedEvaluations' => array(
	                            'className' => 'Evaluation',
	                            'foreignKey' => 'application_id',
	                            'conditions' => array(
	                                'CompletedEvaluations.eval_status_id' => array('Complete', 'Request'),
	                                'CompletedEvaluations.eval_date !=' => '1970-01-01'
	                            )
	                        ),
	                        'CompletedReviews' => array(
	                            'className' => 'Proceeding',
	                            'foreignKey' => 'application_id',
	                            'conditions' => array(
	                                'CompletedReviews.proc_status_id' => 'ReviewerComplete',
	                                'CompletedReviews.proc_date !=' => '1970-01-01'
	                            )
	                        )
	                    )
	                )
	            );
	            $query['contain'][]	= 'ReviewProceeding';
				$query['contain'][]	= 'CompletedEvaluations';
				$query['contain'][]	= 'CompletedReviews';
			}
			return $query;
		} else {
			if ($result[0]['Application']['institution_id'] !== Auth::get('User.institution_id')
					&& (!isset($query['skipAccess']) || $query['skipAccess'] !== true)
					&& !Auth::checkRole('che_admin') && !Auth::checkRole('che_default')
			) {
				throw new Exception(__('You do not have permission to access that application.', true));
			}

			$this->saveAll($result[0], array('validate' => 'only'));

			if (isset($result[0]['HeqfQualification']['s1_lkp_heqf_align_id']) && $result[0]['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B') {
				if (empty($result[0]['HeqfQualification']['qualification_reference_no'])) {
					$result[0]['HeqfQualification']['qualification_reference_no'] = $result[0]['HeqfQualification']['s1_qualification_reference_no'];
				}
			}

			$result[0] = $this->multipleValuesExtract(
				$result[0],
				'HeqfQualification',
				array(
					's1_lkp_hemis_qualifier_id',
					'hemis_lkp_cesm3_code_id',
					'lkp_cesm1_code_id',
					'replace_qual'
				)
			);

			return $result[0];
		}
	}

	public function saveProcess($data, $id, $processInfo = array(), $flowInfo = array()) {
		/*
		  NB
		  Do not save the inst id (evaluate, checklist) coz the user might not be part of that particular inst
		*/
		switch ($processInfo['Process']['slug']) {
			case 'application-requirements':
			case 'alignment':
			case 'application':
			case 'application-cat-b':
				$data['Application']['institution_id'] = Auth::get('User.institution_id');

				if (!empty($data['ProgrammeAssessmentApproach'])) {
						$this->HeqfQualification->deleteAssociatedData(
							array(
								// 'ProgrammeDesignDetail' => $data['HeqfQualification']['id'],
								'ProgrammeAssessmentApproach' => $data['HeqfQualification']['id'],
							)
						);					
					$data['HeqfQualification']['ProgrammeAssessmentApproach'] = $data['ProgrammeAssessmentApproach'];
					unset($data['ProgrammeAssessmentApproach']);
				}

				$data = $this->multipleValuesExtract(
					$data,
					'HeqfQualification',
					array(
						's1_lkp_hemis_qualifier_id',
						'hemis_lkp_cesm3_code_id',
						'lkp_cesm1_code_id'
					)
				);
				$data = $this->runValidationFunctions($data);
				$data['HeqfQualification']['edited_online'] = true;

				if($this->saveAll($data, array('validate' => false))){
					$savedData = $this->HeqfQualification->find('first', array(
						'conditions' => array(
								'HeqfQualification.id' => $data['HeqfQualification']['id']
							),
						'contain' => array('ProgrammeAssessmentApproach', 'HeqfQualificationModule')
					));					
				} else {
					return false;
				}

				$valid = !empty($savedData) ? $this->HeqfQualification->saveAll($savedData, array('validate' => 'only', 'deep' => true)) : false;
				$institutionType = $this->Institution->institutionType();
				$fieldsArr = $this->_getCategoryCFields($institutionType);

				$this->HeqfQualification->id = $data['HeqfQualification']['id'];
				switch ($flowInfo['Flow']['slug']) {
					case 'section-1':
						if (!empty($savedData) && $savedData['HeqfQualification']['s1_lkp_heqf_align_id'] == 'C') {
							$valid = $this->HeqfQualification->saveAll($savedData, array('validate' => 'only', 'fieldList' => $fieldsArr));	
						}
						$this->HeqfQualification->saveField('s1_error', !$valid);
						break;
					case 'section-1-B':
						$this->HeqfQualification->saveField('s1_error', !$valid);
						break;
					case 'section-2':
					case 'section-2-B':
					case 'requirements-section-2':
					case 'appendix_b':
						$this->HeqfQualification->saveField('s2_error', !$valid);
						break;
					case 'section-3-B':
					case 'section-3-modules':
						$this->HeqfQualification->saveField('s3_error', !$valid);
					break;
				}
				
				/*	if (!empty($data['ProgrammeDesignDetail'])) {
					$data['HeqfQualification']['ProgrammeDesignDetail'] = $data['ProgrammeDesignDetail'];
					unset($data['ProgrammeDesignDetail']);
				}*/

				return true;
				break;
			case 'section-2-correction':
				$data = $this->multipleValuesExtract(
					$data,
					'HeqfQualification',
					array(
						'hemis_lkp_cesm3_code_id',
						'lkp_cesm1_code_id'
					)
				);
				$data = $this->runValidationFunctions($data);
				return $this->saveAll($data, array('validate' => false));
			break;
			case 'checklist' :
				$data['Application']['user_id'] = $this->__checklistingStatus($data);
				return ($this->save($data, array('validate' => false))) ? true : false;
				break;
			case 'evaluate' :
			case 'evaluate-cat-b' :
				$valBool = false;	
				
				// this will update the any time the user was in the record and it was marked as evaluated.  Could change evaluation date by accident?											
				// $evaluationId = $this->Evaluation->find('first', array('fields' => array('Evaluation.id'), 'conditions'=> array('Evaluation.eval_status_id' => 'New', 'Evaluation.eval_user_id' => Auth::get('User.id'), 'Evaluation.application_id' => $data['Application']['id'])));							
						// $data['Evaluation']['id'] = $evaluationId['Evaluation']['id'];
						if ($data['Evaluation']['eval_status_id'] == 'Complete' || $data['Evaluation']['eval_status_id'] == 'Request') {
							$data['Evaluation']['eval_inactive'] = 1;
							$data['Evaluation']['eval_date'] = date('Y-m-d', time());
							$data['Application']['user_id'] = '';
							if ($data['Evaluation']['eval_status_id'] == 'Request') {
								$data['Evaluation']['request_second_evaluation'] = 1;
							}
							$data['Application']['evaluation_status_id'] = 'Complete';						
							$valBool = true;
						} else {
							$data['Application']['evaluation_status_id'] = 'New';
							$data['Application']['user_id'] = Auth::get('User.id');
							$data['Evaluation']['request_second_evaluation'] = 0;
						}
				return $this->saveAll($data, array('validate' => $valBool));
				break;
			case 'review' :
				$applicationInfo = $this->find('first', array(
						'fields' => array('Application.id', 'application_status'),
						'conditions' => array('Application.id' => $data['Application']['id'])
					));
				$isProceeding = $applicationInfo['Application']['application_status'] == 'Proceeding' ? true : false;
				if ($isProceeding) {
					$this->ReviewProceeding->set($data);
					$valBool = $data['ReviewProceeding']['proc_lkp_outcome_id'] > '' ? true : false;

				} else {
					$valBool = $data['Application']['review_outcome_id'] > '' ? true : false;
					if($data['Application']['review_outcome_id'] == 'nr'){
						$data['Application']['lkp_heqf_align_id'] = 'C';
					}
					$data['Application']['lkp_outcome_id'] = $data['Application']['review_outcome_id'];
					// return ($this->save($data, array('validate' => $valBool))) ? true : false;
				}
				return $this->saveAll($data, array('validate' => $valBool)) ? true : false;
				
			break;

			case 'edit-due-date':
				return $this->saveAll($data, array('validate' => false));
			break;
			case 'upload-proceeding-document':
			
				$valBool = isset($data['Proceeding']['proc_document']['tmp_name']) && $data['Proceeding']['proc_document']['tmp_name'] > '' ? true : false;
								
				if ($valBool) {
					$tempName = $data['Proceeding']['proc_document']['tmp_name'];
					$this->Proceeding->set($data);
					$isValidUpload = $this->Proceeding->validates(array('fieldList' => array('proc_document'))) ? true : false;
					
					if (!$isValidUpload) {
						return false;
					}

					$fileParts = pathinfo($data['Proceeding']['proc_document']["name"]);
					$extension = $fileParts['extension'];
					$applicationInfo = $this->find('first', array(
						'fields' => array('Application.id', 'Institution.hei_code', 'HeqfQualification.s1_qualification_reference_no'),
						'contain' => array('Institution', 'HeqfQualification'),
						'conditions' => array('Application.id' => $data['Application']['id'])
					));
					
					$qual_ref = str_replace('/', '_',$applicationInfo['HeqfQualification']['s1_qualification_reference_no']);
					//$data['Proceeding']['proc_document'] = urlencode($data['Proceeding']['proc_document']['name']);
					
					$proceeding = $this->Proceeding->findById($data['Proceeding']['id']);
					$proceedingTypeDesc = $this->Proceeding->getProceedingTypeDesc($proceeding['Proceeding']['proceeding_type_id']);
					$proceedingOrder = $proceeding['Proceeding']['proc_order'];
					$fileName = $proceedingOrder . '-' . $proceedingTypeDesc . '-' . $qual_ref ;
					$data['Proceeding']['proc_document'] = $fileName . '.'. $extension;
					$hei_code = $applicationInfo['Institution']['hei_code'];
					$destinationPath = WWW_ROOT . 'Documents/' . $hei_code . '/Applications';
					
					if ($this->saveAll($data, array('validate' => false))) {
						if (!file_exists($destinationPath)) {
							mkdir($destinationPath, 0777, true);
						}
						$this->Proceeding->deleteExistingProceedingFile($destinationPath, $fileName);
						$fileCreated = move_uploaded_file($tempName, $destinationPath . '/' . $data['Proceeding']['proc_document']);
						
						return $fileCreated;
					} else {						
						return false;
					}
				} else {
					return true;
				}

				
				
			break;
		}
	}

	public function actionListConditions($action, $params) {
		$conditions['Application.inactive'] = 0;
		$conditions['Application.archived'] = 0;

		switch ($action) {
			case 'send_back':
			case 'capture_outcome':
				break;
			case 'assign':
				if (Auth::get('User.institution_id') !== 0) {
					$conditions['Application.institution_id'] = Auth::get('User.institution_id');
				}
				$conditions['Application.application_status'] = array('New', 'RenewEdited');
				break;
			case 'archive':
				if (Auth::get('User.institution_id') !== 0) {
					$conditions['Application.institution_id'] = Auth::get('User.institution_id');
				}
				$conditions['Application.submission_date'] = '1970-01-01';
				$conditions['HeqfQualification.disable_delete'] = false;
				break;
			case 'return_inst_review':
				/*
					Conditions for the applications -> all of them etc
					Using the review returned condition
				*/
				$conditions = array(
					'Application.checklisting_status_id' => 'Evaluate',
					'Application.evaluation_status_id' => 'Complete',
					'Application.review_status_id' => 'Return',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_date !=' => '1970-01-01',
					// 'Application.evaluation_date !=' => '1970-01-01',
					'Application.review_date !=' => '1970-01-01'
				);
				break;
			case 'return_inst':
				/*
					Only submitted applications can be returned
					Also checklisting/checklisted

					original:

					'Application.application_status' => 'Submitted',
					'Application.evaluation_date' => '1970-01-01',
					'Application.checklisting_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01',
					'Application.submission_date !=' => '1970-01-01',
					'Application.checklisting_status_id' => null

					therefore
				*/
				$conditions = array(
					'Application.application_status' => array('Submitted', 'Checklisting'),
					'Application.submission_date !=' => '1970-01-01',
					'Application.evaluation_status_id' => '',
					// 'Application.evaluation_date' => '1970-01-01',
					'Application.review_date' => '1970-01-01'
				);
				break;
			case 'assign_checklister':
				$conditions['Application.application_status'] = 'Submitted';
				break;
			case 'assign_evaluator':
				// Need to add the condition that checklisting is complete.
				$conditions['Application.application_status'] = array('Checklisting', 'Evaluation');
				$conditions['Application.checklisting_date !='] = '1970-01-01';
				$conditions['Application.checklisting_status_id'] = 'Evaluate';
				$conditions['Application.evaluation_status_id !='] = 'New';
				break;
			case 'return_evaluation':
				$conditions['Application.application_status'] = 'Evaluation';
				break;
			case 'assign_reviewer':
				$conditions['Application.application_status'] = array('Evaluation', 'RenewEdited');
				$conditions['Application.review_error'] = '0';
				// $conditions['Application.evaluation_date !='] = '1970-01-01';
				$conditions['Application.review_date'] = '1970-01-01';
				$conditions['Application.evaluation_status_id'] = 'Complete';
				/*
					Need to be able to assign to reviewer those apps that have been re-submitted
				*/
				break;
			case 'return_review':
				$conditions['Application.application_status'] = 'Review';
				$conditions['Application.checklisting_status_id'] = 'Evaluate';
				$conditions['Application.evaluation_status_id'] = 'Complete';
				$conditions['Application.user_id'] = Auth::get('User.id');
				break;
			case 'set_review_outcome':
				$initApp['Application.application_status'] = 'Review';
				$initApp['Application.checklisting_status_id'] = 'Evaluate';
				$initApp['Application.evaluation_status_id'] = 'Complete';
				$initApp['Application.user_id'] = Auth::get('User.id');
				$initApp['Application.review_outcome_id'] = '';
				$initApp['EvaluationWithNI.id'] = null;

				$procApp['Application.application_status'] = 'Proceeding';
				$procApp['Application.user_id'] = Auth::get('User.id');
				$procApp['ReviewProceeding.proc_lkp_outcome_id'] = '';
				$conditions['OR'] = array($initApp, $procApp);
				break;
			case 'return_without_review':
				$initApp['Application.application_status'] = 'Review';
				$initApp['Application.review_status_id'] = 'New';
				$initApp['Application.checklisting_status_id'] = 'Evaluate';
				$initApp['Application.evaluation_status_id'] = 'Complete';
				$initApp['Application.user_id'] = Auth::get('User.id');
				$initApp['Application.review_outcome_id'] = '';

				$procApp['Application.application_status'] = 'Proceeding';
				$procApp['Application.user_id'] = Auth::get('User.id');
				$procApp['ReviewProceeding.proc_lkp_outcome_id'] = '';
				$conditions['OR'] = array($initApp, $procApp);
				break;
			case 'return_for_representation':
				$conditions['Application.application_status'] = array('Review', 'Proceeding');
				$conditions['Application.checklisting_status_id'] = 'Evaluate';
				$conditions['Application.evaluation_status_id'] = 'Complete';
				$conditions['Application.review_status_id'] = 'Reviewed';
				$conditions['Application.user_id'] = '';
				// $conditions['Application.review_outcome_id'] = 'nr';
				$conditions['Application.proceeding_status_id NOT'] = array('InstNew', 'InstComplete', 'ReviewerNew');
				$conditions['Application.outcome_accepted'] = 1;
				$conditions['Application.notified'] = 1;
				$conditions['Application.heqc_meeting_id >'] = '';
				$conditions['OR'] = array(
					array('Application.review_outcome_id' => 'nr'),
					array('Application.lkp_outcome_id' => 'nr')
				);
				break;
			case 'assign_heqc_meeting':
			//Processing of cat C bypasses all processing before assigning to HEQC meeting
				$catAB['HeqfQualification.s1_lkp_heqf_align_id'] = array('A','B');
				$catAB['Application.application_status'] = 'Review';
				$catAB['Application.review_status_id'] = 'Reviewed';
				$catAB['Application.checklisting_status_id'] = 'Evaluate';
				$catAB['Application.evaluation_status_id'] = 'Complete';
				$catAB['Application.lkp_outcome_id !='] = '';
				$catAB['Application.user_id'] = '';
				$catAB['Application.outcome_accepted'] = 0;
				$catC['HeqfQualification.s1_lkp_heqf_align_id'] = 'C';
				$catC['Application.application_status'] = array('Submitted','Checklisting');
				$catC['Application.lkp_outcome_id !='] = '';
				$catC['Application.outcome_accepted'] = 0;
		
				$conditions['OR'] = array($catC, $catAB);
				break;
			case 'return_for_deferral':
				$conditions['Application.application_status'] = array('Review', 'Proceeding');
				$conditions['Application.checklisting_status_id'] = 'Evaluate';
				$conditions['Application.evaluation_status_id'] = 'Complete';
				$conditions['Application.review_status_id'] = 'Reviewed';
				$conditions['Application.user_id'] = '';
				$conditions['Application.review_outcome_id'] = 'ni';
				$conditions['Application.proceeding_status_id NOT'] = array('InstNew', 'InstComplete', 'ReviewerNew');
				$conditions['Application.outcome_accepted'] = 1;
				$conditions['Application.notified'] = 1;
				$conditions['Application.heqc_meeting_id >'] = '';
				break;
			case 'assign_representation_reviewer':
				$conditions['Application.application_status'] = 'Proceeding';
				$conditions['Application.checklisting_status_id'] = 'Evaluate';
				$conditions['Application.evaluation_status_id'] = 'Complete';
				$conditions['Application.review_status_id'] = 'Reviewed';
				$conditions['Application.user_id'] = '';
				// $conditions['Application.review_outcome_id'] = 'nr';
				$conditions['Application.proceeding_status_id'] = 'InstComplete';
				$conditions['OR'] = array(
					array('Application.review_outcome_id' => 'nr'),
					array('Application.lkp_outcome_id' => 'nr')
				);
				break;
			case 'assign_deferral_reviewer':
				$conditions['Application.application_status'] = 'Proceeding';
				$conditions['Application.checklisting_status_id'] = 'Evaluate';
				$conditions['Application.evaluation_status_id'] = 'Complete';
				$conditions['Application.review_status_id'] = 'Reviewed';
				$conditions['Application.user_id'] = '';
				$conditions['Application.review_outcome_id'] = 'ni';
				$conditions['Application.proceeding_status_id'] = 'InstComplete';
				break;
			case 'assign_proc_heqc_meeting':
				$conditions['LastReviewiedProceeding.id !='] = null;
				$conditions['Application.review_status_id'] = 'Reviewed';
				$conditions['Application.user_id'] = '';
				$conditions['Application.application_status'] = 'Proceeding';
				$conditions['Application.proceeding_status_id'] = 'ReviewerComplete';
				break;
			case 'mark_reviewed':
				$initApp['Application.application_status'] = 'Review';
				$initApp['Application.review_status_id !='] = 'Reviewed';
				$initApp['Application.checklisting_status_id'] = 'Evaluate';
				$initApp['Application.evaluation_status_id'] = 'Complete';
				$initApp['Application.review_outcome_id !='] = '';
				$initApp['Application.user_id'] = Auth::get('User.id');

				$procApp['Application.application_status'] = 'Proceeding';
				$procApp['Application.proceeding_status_id !='] = 'ReviewerComplete';
				$procApp['ReviewProceeding.proc_lkp_outcome_id !='] = '';
				$procApp['Application.user_id'] = Auth::get('User.id');
				$conditions['OR'] = array($initApp, $procApp);
				break;
			case 'inst_submit_proceeding':
				$conditions['Application.application_status'] = 'Proceeding';
				$conditions['Application.proceeding_status_id'] = 'InstNew';
				$conditions['Application.user_id'] = Auth::get('User.id');
				$conditions['Application.lkp_proceeding_type_id'] = array('r', 'd');
				$conditions['Proceeding.proc_document !='] = '';
				$conditions['Proceeding.proc_status_id'] = 'InstNew';
				break;
			case 're_submit':
				$conditions['Application.institution_id'] = Auth::get('User.institution_id');
				$conditions['Application.application_status'] = 'RenewEdited';
				$conditions['Application.review_error'] = '1';
				$conditions['HeqfQualification.s1_error'] = 0;
				$conditions['HeqfQualification.s2_error'] = 0;
				break;
			case 'submit':
				$conditions['Application.institution_id'] = Auth::get('User.institution_id');
				//$conditions['Application.application_status !='] = 'Submitted';
				$conditions['Application.application_status'] = 'New';

				$conditions['HeqfQualification.s1_error'] = 0;
				$conditions['HeqfQualification.s2_error'] = 0;
				$conditions['HeqfQualification.s3_error'] = 0;
				break;
			case 'take_back':
				$conditions['Application.institution_id'] = Auth::get('User.institution_id');
				//$conditions['Application.application_status !='] = 'Submitted';
				$conditions['Application.application_status'] = array('New', 'RenewEdited');

				$conditions['Application.user_id !='] = Auth::get('User.id');
				break;
			case 're_categorise_to_c':
				$conditions['Application.heqc_meeting_id >'] = '';
				$conditions['Application.outcome_accepted'] = 1;
				$conditions['Application.notified'] = 1;
				$conditions['Application.review_status_id'] = 'Reviewed';
				$conditions['Application.user_id'] = '';
				$conditions['Application.lkp_outcome_id'] = array('nr', 'n');
				$conditions['HeqfQualification.s1_lkp_heqf_align_id !='] = 'C';
				break;
		}

		return $conditions;
	}

	public function archive($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);

			$conditions = $this->actionListConditions('archive', array());
			$conditions['Application.id'] = $applications;

			$qualifications = $this->find('all', array(
				'fields' => array(
					'Application.heqf_qualification_id'
				),
				'conditions' => $conditions,
				'contain' => 'HeqfQualification'
			));

			$qualificationIds = Set::extract('/Application/heqf_qualification_id', $qualifications);

			$applicationConditions = array('Application.heqf_qualification_id' => $qualificationIds);
			$qualificationConditions = array('HeqfQualification.id' => $qualificationIds);

			$applicationUpdate = array(
				'Application.archived' => 1,
				'Application.archive_date' => 'NOW()',
				'Application.archived_by' => "'" . Sanitize::escape(Auth::get('User.id')) . "'"
			);
			$qualificationUpdate = array(
				'HeqfQualification.archived' => 1,
				'HeqfQualification.archive_date' => 'NOW()',
				'HeqfQualification.archived_by' => "'" . Sanitize::escape(Auth::get('User.id')) . "'"
			);

			$currentData = $this->find('all', array('conditions' => $applicationConditions));
			if ($this->updateAll($applicationUpdate, $applicationConditions) && $this->updateAll($qualificationUpdate, $qualificationConditions)) {
				$updatedData = $this->find('all', array('conditions' => $applicationConditions));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}
			}

			return true;
		}

		return array(
			'listHeading' => __('Applications that will be deleted:', true)
		);
	}

	public function assign($process, $params) {
		if (empty($params['data'])) {
			return false;
		}
		if (isset($params['data']['Application']['user_id'])) {
			$userId = Sanitize::escape($params['data']['Application']['user_id']);
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('assign', array());
			$conditions['Application.id'] = $applications;

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array('Application.user_id' => "'" . $userId . "'");

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				return true;
			}
		}

		$this->User->virtualFields['name'] = 'CONCAT(User.first_name, " ", User.last_name, " (", User.email_address, ")")';
		return array(
			'users' => $this->User->find('list', array(
				'fields' => 'User.name',
				'conditions' => array(
					'User.institution_id' => Auth::get('User.institution_id')
				)
			)),
			'listHeading' => __('Applications that will be assigned to the selected user:', true)
		);
	}

	public function submit($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$conditions = $this->actionListConditions('submit', array());
			$conditions['Application.id'] = $params['data']['Process']['selected'];

			$applicationList = $this->find('all', array(
				'fields' => array('Application.id', 'HeqfQualification.id'),
				'conditions' => $conditions,
				'contain' => 'HeqfQualification'
					));
			$applications = Set::extract('/Application/id', $applicationList);
			$qualifications = Set::extract('/HeqfQualification/id', $applicationList);

			// Default alignment category on application (which will be the evaluated and reviewed category) to category that the user suggested.
			$update = array(
				'Application.application_status' => "'Submitted'",
				'Application.submission_date' => 'NOW()',
				'Application.submission_user_id' => "'" . Sanitize::clean(Auth::get('User.id')) . "'",
				'Application.lkp_heqf_align_id' => "HeqfQualification.s1_lkp_heqf_align_id",
				'Application.checklisting_comments' => "null", //resetting the checklisting comments
				'Application.user_id' => "''"				
			);

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				$heqfRef = array(
					Auth::get('Institution.hei_code'),
					0,
					'HEQSF'
				);
				$Setting = ClassRegistry::init('Setting');
				$Setting->cacheQueries = false;

				foreach ($qualifications as $qualification) {
					$lastNumber = $Setting->findById('heqf.ref');
					$number = (int)$lastNumber['Setting']['value'] + 1;
					$heqfRef[1] = str_pad($number, 4, '0', STR_PAD_LEFT);

					$this->HeqfQualification->id = $qualification;
					$this->HeqfQualification->saveField('heqf_reference_no', strtoupper(implode('/', $heqfRef)));

					$Setting->id = 'heqf.ref';
					$Setting->saveField('value', $number);
				}
				return true;
			}
		}

		return array(
			'listHeading' => __('Applications that will be submitted to the CHE:', true)
		);
	}

	public function reSubmit($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$conditions = $this->actionListConditions('re_submit', array());
			$conditions['Application.id'] = $params['data']['Process']['selected'];

			$applicationList = $this->find('all', array(
				'fields' => array('Application.id', 'HeqfQualification.id'),
				'conditions' => $conditions,
				'contain' => 'HeqfQualification'
					));
			$applications = Set::extract('/Application/id', $applicationList);
			$qualifications = Set::extract('/HeqfQualification/id', $applicationList);

			// Default alignment category on application (which will be the evaluated and reviewed category) to category that the user suggested.
			$update = array(
				'Application.modified' => 'NOW()',
				'Application.submission_user_id' => "'" . Sanitize::clean(Auth::get('User.id')) . "'",
				'Application.user_id' => "''",
				'Application.review_error' => "'0'",
				'Application.resubmission_date' => 'NOW()',
				'Application.checklisting_comments' => "null" //resetting the comments field
			);

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				$heqfRef = array(
					Auth::get('Institution.hei_code'),
					0,
					'HEQF'
				);
				$Setting = ClassRegistry::init('Setting');
				$Setting->cacheQueries = false;

				foreach ($qualifications as $qualification) {
					$lastNumber = $Setting->findById('heqf.ref');
					$number = (int)$lastNumber['Setting']['value'] + 1;
					$heqfRef[1] = str_pad($number, 4, '0', STR_PAD_LEFT);

					$this->HeqfQualification->id = $qualification;
					$this->HeqfQualification->saveField('heqf_reference_no', strtoupper(implode('/', $heqfRef)));

					$Setting->id = 'heqf.ref';
					$Setting->saveField('value', $number);
				}
				return true;
			}
		}

		return array(
			'listHeading' => __('Applications that will be re-submitted to the CHE:', true)
		);
	}

	public function takeBack($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('take_back', array());
			$conditions['Application.id'] = $applications;

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));

			if ($this->updateAll(array('Application.user_id' => "'" . Auth::get('User.id') . "'"), $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				return true;
			}
		}

		return array(
			'listHeading' => __('Applications that will be taken back:', true)
		);
	}

	public function sendBack($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('send_back', array());
			$conditions['Application.id'] = $applications;

			$users = $this->User->find('all', array(
				'conditions' => array(
					'User.institution_id' => Auth::get('User.institution_id')
				),
				'contain' => array(
					'Role'
				)
			));

			$adminId = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $users));

			$admin = $this->User->findById($adminId);

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));

			if ($this->updateAll(array('Application.user_id' => "'" . $admin['User']['id'] . "'"), $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				return true;
			}
		}

		return array(
			'listHeading' => __('Applications that will be sent back to your institutional administrator:', true)
		);
	}

	public function newProcess() {
		$data = array(
			'Application' => array(
				'institution_id' => Auth::get('User.institution_id'),
				'user_id' => Auth::get('User.id'),
				'application_status' => 'New'
			),
			'HeqfQualification' => array(
				'institution_id' => Auth::get('User.institution_id'),
				's1_error' => true,
				's2_error' => true
			)
		);

		$this->saveAll($data, array('validate' => false));

		return $this->id;
	}

/**
 * A new application must be inserted every time an application is sent to an institution.  This way we preserve the history of an application.
 * The current application must be set to inactive.  Inactive applications cannot be processed again.
 * @param  string $process [description]
 * @param  array $params  [description]
 * @return mixed          [description]
 */
	public function returnInst($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$conditions = $this->actionListConditions('return_inst', array());
			$conditions['Application.id'] = $params['data']['Process']['selected'];
			$sendMail = false;
			$emailData= array();
			// get fields that must be populated on the new application record
			// User must be set back to the institutional administrator (current at the time)
			$applicationList = $this->find('all', array(
				'fields' => array('Application.id', 'Application.institution_id', 'Application.heqf_qualification_id', 'Application.submission_user_id'),
				'conditions' => $conditions
			));

			$applications = Set::extract('/Application/id', $applicationList);

			$newApps['Application'] = array();

			$updateCount = 0;
			$errorMessage = '<div class="ui-state-error message">Applications were not returned for the following institutions because they do not have administrators.<ul><li>';
			$displayErrorMessage = false;
			$institutionsNotFound = array();

			foreach ($applicationList as $app) {
				// get the current Institutional administrator for the institution (specific role_id) - 4d51175f-a924-4ee4-ad67-0358c0a80305
				// if there is more than one (there shouldn't be) then take the first one. Record the user who the application was returned to.

				$institutionName = $this->Institution->find('first', array(
						'fields' => array('Institution.hei_name'),
						'conditions' => array(
							'Institution.id' => $app['Application']['institution_id'],
						)
					)
				);

				$institutionName = ($institutionName) ? $institutionName['Institution']['hei_name'] : 'ID: ' . $app['Application']['institution_id'];

				$instAdm = $this->User->find('all', array(
						'conditions' => array(
							'User.institution_id' => $app['Application']['institution_id'],
							'active' => 1
						),
						'contain' => array('Role')
					)
				);

				$adminID = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $instAdm));
				if (!$adminID) {
					// Want to return the message that an institutional administrator for an institution does not exist.
					$displayErrorMessage = true;
					array_push($institutionsNotFound, $institutionName);
				} else {
					/*
						need to change the other data here if catering for in checklisting status
					*/

					$isCatB = $this->checkCatB($app);

					$update = array(
						"Application.user_id" => "'$adminID'",
						"Application.submission_date" => "'1970-01-01'",
						"Application.application_status" => "'New'", //new status
						"Application.returnedto_user_id" => "'$adminID'",
						"Application.modified" => "NOW()",
						"Application.checklisting_date" => "'1970-01-01'",
						"Application.checklisting_user_id" => "''",
						"Application.checklisting_status_id" => "null",
						// "Application.checklisting_comments" => "null", //leaving comments available for institution
						//Disable section 1 fields when an application is returned
						"HeqfQualification.disable_section1" => true,
						"HeqfQualification.disable_delete" => true,
					);

					if ($isCatB) {
						$update["HeqfQualification.s2_error"] = "'1'";
						$update["HeqfQualification.s3_error"] = "'1'";
						$update["HeqfQualification.qualification_reference_no"] = "HeqfQualification.s1_qualification_reference_no";
					}

					$updateConditions['Application.id'] = $app['Application']['id'];

					$currentData = $this->find('all', array('conditions' => array('Application.id' => $app['Application']['id'])));

					$applicationInfo = $this->find('first', array(
						'fields' => array('Application.checklisting_comments', 'Application.application_status', 'Application.checklisting_status_id', 'HeqfQualification.qualification_title', 'HeqfQualification.s1_qualification_reference_no'),
						'conditions' => array(
							'Application.id' => $app['Application']['id']
							),
						'contain' => 'HeqfQualification'
					));	
					if($applicationInfo['Application']['checklisting_status_id'] == 'Return' && $applicationInfo['Application']['application_status'] =='Checklisting'){
						$update["Application.returned_from_checklisting"] = "'1'";
					}else{
						$update["Application.returned_from_checklisting"] = "'0'"; //reset returned from checklisting index
					}				

					if ($this->updateAll($update, $updateConditions)) {
						$sendMail = true;
						$updatedData = $this->find('all', array('conditions' => array('Application.id' => $app['Application']['id'])));						
						foreach ($currentData as $currentDataItem) {
							$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

							$this->saveDiff($currentDataItem, $updatedDataItem);
						}											

					} else {
						$updateCount++;
					}

					if(!$updateCount){
						$sendMail =true;

						//Send Email to institution administrator when applications are returned
						$instAdm = $this->User->findById($adminID);
						$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $instAdm['User']['email_address'] : Configure::read('Email.debug_address');
						
						if (empty($emailData[$adminID])) {
							$emailData[$adminID] = array(
								'to' => $to,
								'subject' => Configure::read('System.email.prefix') . 'Notifications: applications returned',
								'from' => Configure::read('System.email.from'),
								'bcc' => Configure::read('System.email.bcc'),
								'template' => 'return_inst',
								'sendAs' => 'text',
								'variables' => array(
									'admin' => $instAdm,
									'current' => array($applicationInfo)
								)
							);
						} else {
							$emailData[$adminID]['variables']['current'][] = $applicationInfo;
						}				
												
					}
				}
			}

			if ($sendMail && !empty($emailData)) {
				foreach ($emailData as $id => $data) {
					$this->sendEmail($data);
				}
			}

			if (!empty($institutionsNotFound)) {
				$institutionsNotFound = array_unique($institutionsNotFound);
				$institutionsNotFound = implode('</li><li>', $institutionsNotFound);
			}
			$errorMessage .= $institutionsNotFound . '</li></ul></div>';
			echo ($displayErrorMessage) ? $errorMessage : '';
			return ($updateCount) ? false : true;
		}

		return array(
			'listHeading' => __('Applications that will be sent back to their institution:', true)
		);
	}

	public function returnInstReview($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm'])) {
			$conditions = $this->actionListConditions('return_inst_review', array());

			/*
				Need to make the sending and the saving now
				Also need to add a status
				Set the status
				Set the user, just like returning to inst, just new statuses.
			*/

			$conditions['Application.id'] = $params['data']['Process']['selected'];

			// get fields that must be populated on the new application record
			// User must be set back to the institutional administrator (current at the time)
			$applicationList = $this->find('all', array(
				'fields' => array('Application.id', 'Application.institution_id', 'Application.heqf_qualification_id', 'Application.submission_user_id', 'Application.review_user_id'),
				'conditions' => $conditions
					));

			$applications = Set::extract('/Application/id', $applicationList);

			$newApps['Application'] = array();
			$updateTrue = false;
			$updateCount = 0;
			$errorMessage = '<div class="ui-state-error message">Applications were not returned for the following institutions because they do not have administrators.<ul><li>';
			$displayErrorMessage = false;
			$institutionsNotFound = array();
			$instAdm = '';
			$data = array();
			$sendMail = false;

			foreach ($applicationList as $app) {
				// get the current Institutional administrator for the institution (specific role_id) - 4d51175f-a924-4ee4-ad67-0358c0a80305
				// if there is more than one (there shouldn't be) then take the first one. Record the user who the application was returned to.

				$reviewUser = $this->User->find('first', array(
					'fields' => array('User.first_name', 'User.last_name', 'User.id'),
					'conditions' => array(
						'User.id' => $app['Application']['review_user_id'],
					)
						)
				);

				$institutionName = $this->Institution->find('first', array(
					'fields' => array('Institution.hei_name'),
					'conditions' => array(
						'Institution.id' => $app['Application']['institution_id'],
					)
						)
				);

				$institutionName = ($institutionName) ? $institutionName['Institution']['hei_name'] : 'ID: ' . $app['Application']['institution_id'];

				$instAdm = $this->User->find('all', array(
						'conditions' => array(
							'User.institution_id' => $app['Application']['institution_id'],
						),
						'contain' => array('Role')
					)
				);

				$adminID = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $instAdm));

				if (!$adminID) {
					// Want to return the message that an institutional administrator for an institution does not exist.
					$displayErrorMessage = true;
					array_push($institutionsNotFound, $institutionName);
				} else {
					$reviewUserData = $reviewUser['User']['first_name'] . ' ' . $reviewUser['User']['last_name'];

					$update = array(
						"Application.review_history" => "CONCAT(review_history, review_date, ' Reviewed by: ', ' $reviewUserData', ' Recommended: ', review_status_id, ' _|_ ')",
						"Application.user_id" => "'$adminID'",
						"Application.review_date" => "'1970-01-01'",
						"Application.review_status_id" => "'Returned'",
						"Application.application_status" => "'RenewEdited'", //new status
						"Application.returnedto_user_id" => "'$adminID'",
						"Application.review_error" => "'1'",
						"Application.modified" => "NOW()",
						"HeqfQualification.s2_error" => "'1'"
					);

					$updateConditions['Application.id'] = $app['Application']['id'];

					$currentData = $this->find('all', array('conditions' => array('Application.id' => $app['Application']['id'])));

					if ($this->updateAll($update, $updateConditions)) {
						$updatedData = $this->find('all', array('conditions' => array('Application.id' => $app['Application']['id'])));
						foreach ($currentData as $currentDataItem) {
							$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

							$this->saveDiff($currentDataItem, $updatedDataItem);
						}
					} else {
						$updateCount++;
					}

					/*
						Email
					*/
					if (!$updateCount) {
						$sendMail = true;

						$instAdm = $this->User->findById($adminID);

						$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $admin['User']['email_address'] : Configure::read('Email.debug_address');

						$data[$adminID] = array(
							'to' => $to,
							'subject' => Configure::read('Email.prefix') . 'Notifications: Reviewed applications returned',
							'from' => Configure::read('Email.from'),
							'bcc' => Configure::read('Email.bcc'),
							'template' => 'review_return_alert',
							'sendAs' => 'text',
							'variables' => array(
								'admin' => $instAdm
							)
						);
					}
				}

			}

			if ($sendMail && !empty($data)) {
				foreach ($data as $id => $emailData) {
					$this->sendEmail($emailData);
				}
			}

			if (!empty($institutionsNotFound)) {
				$institutionsNotFound = array_unique($institutionsNotFound);
				$institutionsNotFound = implode('</li><li>', $institutionsNotFound);
			}
			$errorMessage .= $institutionsNotFound . '</li></ul></div>';
			echo ($displayErrorMessage) ? $errorMessage : '';
			return ($updateCount) ? false : true;
		}

		return array(
			'listHeading' => __('Applications that will be sent back to their institution after review:', true)
		);
	}

	public function assignChecklister($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Application']['user_id'])) {
			$userId = Sanitize::escape($params['data']['Application']['user_id']);
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('assign_checklister', array());
			$conditions['Application.id'] = $applications;

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array('Application.user_id' => "'" . $userId . "'", 'Application.application_status' => "'Checklisting'", 'Application.checklisting_status_id' => "'New'");

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				return true;
			}
		}

		return array(
			'users' => $this->User->listByRole('98dbb3be-e36c-11e0-a1b9-000c292ff614'),
			'listHeading' => __('Applications that will be assigned to the selected checklister:', true)
		);
	}

	protected function _calculateDuedate($action) {
		$setting = ClassRegistry::init('Setting');
		switch ($action) {
			case 'assign_reviewer':
			case 'assign_representation_reviewer':
			case 'assign_deferral_reviewer':
				$field = 'review_due_date_period';
				break;
			case 'assign_evaluator':
				$field = 'evaluation_due_date_period';
				break;
		}

		$dueDateSetting = $setting->find('first', array('conditions' => array('id' => $field)));
		$dueDatePeriod = '+'. $dueDateSetting['Setting']['value'] . ' days';
		$dueDate = Date('Y-m-d', strtotime($dueDatePeriod));
		
		return $dueDate;

	}

	public function assignEvaluator($process, $params) {
		if (empty($params['data'])) {
			return false;
		}
		if (isset($params['data']['Application']['user_id'])) {
			$userId = Sanitize::escape($params['data']['Application']['user_id']);
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('assign_evaluator', array());
			$applications = array_unique($applications); //make sure we do notcreate duplicate data
			$conditions['Application.id'] = $applications;
			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$evaluationDueDate =  $this->_calculateDuedate($params['form']['action']);
			$update = array(
				'Application.user_id' => "'" . $userId . "'", 
				'Application.application_status' => "'Evaluation'" , 
				'Application.evaluation_status_id' => "'New'"
			);
			$evaluatorArr = $this->User->findById($userId);
			$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $evaluatorArr['User']['email_address'] : Configure::read('Email.debug_address');
			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications), 'contain' => array('HeqfQualification', 'Institution')));
				$variableData =  Set::combine($updatedData, '{n}.Application.id', '{n}', '{n}.Institution.hei_name');
				$emailData = array(
					'to' => $to,
					'subject' => Configure::read('System.email.prefix') . 'Notifications: Applications evaluation',
					'from' => Configure::read('System.email.from'),
					'bcc' => Configure::read('System.email.bcc'),
					'template' => 'assign_evaluator',
					'sendAs' => 'text',
					'variables' => array(
						'evaluator' => $evaluatorArr,
						'data' => $variableData,
						'numberOfApplications' => count($applications),
						'evaluationDueDate' => $evaluationDueDate
					)
				);

				foreach($applications as $applicationId){
					$application_id = Sanitize::escape($applicationId);
					$lastEvaluationOrder = $this->Evaluation->lastEvaluation($application_id);
					$newEvaluationRow ['Evaluation']['eval_status_id'] = "New";
					$newEvaluationRow ['Evaluation']['application_id'] = $application_id;
					$newEvaluationRow ['Evaluation']['eval_user_id'] =  $userId;
					$newEvaluationRow ['Evaluation']['evaluation_assign_date'] = date('Y-m-d', time());
					$newEvaluationRow ['Evaluation']['evaluation_due_date'] = $evaluationDueDate;
					$newEvaluationRow ['Evaluation']['eval_order'] =  $lastEvaluationOrder + 1;
					$this->Evaluation->create();
					$this->Evaluation->save($newEvaluationRow, array('validate' => false));
				}				
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));
					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				$this->sendEmail($emailData);
				return true;
			}
		}
		// Find users with the role of evaluator
		return array(
			'users' => $this->User->listByRole('98dbb5f8-e36c-11e0-a1b9-000c292ff614'),
			'listHeading' => __('Applications that will be assigned to the selected evaluator:', true)
		);
	}

	protected function _getProceedingByAction($action){
		switch ($action) {
			case 'return_for_deferral':
				$proceedingType = 'd';
				break;
			case 'return_for_representation':
				$proceedingType = 'r';
				break;
			default:
				$proceedingType = 'r';
				break;
		}
		return $proceedingType;
	}

	public function returnInstProceeding($process, $params) {
		$action = $params['form']['action'];
		$proceedingType = $this->_getProceedingByAction($action);
		$proceedingTypeDesc = $this->Proceeding->getProceedingTypeDesc($proceedingType);

		if (isset($params['data']['Process']['confirm'])) {
			$conditions = $this->actionListConditions($action, array());
			$conditions['Application.id'] = $params['data']['Process']['selected'];
			$sendMail = false;
			$emailData= array();

			$applicationList = $this->find('all', array(
				'fields' => array('Application.id', 'Application.institution_id'),
				'conditions' => $conditions
			));

			$applications = Set::extract('/Application/id', $applicationList);
			$updateCount = 0;
			$errorMessage = '<div class="ui-state-error message">Applications were not returned for the following institutions because they do not have administrators.<ul><li>';
			$displayErrorMessage = false;
			$institutionsNotFound = array();

			foreach ($applicationList as $app) {
				$institutionName = $this->Institution->find('first', array(
						'fields' => array('Institution.hei_name'),
						'conditions' => array(
							'Institution.id' => $app['Application']['institution_id'],
						)
					)
				);
				$institutionName = ($institutionName) ? $institutionName['Institution']['hei_name'] : 'ID: ' . $app['Application']['institution_id'];

				$instAdm = $this->User->find('all', array(
						'conditions' => array(
							'User.institution_id' => $app['Application']['institution_id'],
							'active' => 1
						),
						'contain' => array('Role')
					)
				);

				$adminID = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $instAdm));

				if (!$adminID) {
					// Want to return the message that an institutional administrator for an institution does not exist.
					$displayErrorMessage = true;
					array_push($institutionsNotFound, $institutionName);
				} else {
					$currentData = $this->find('all', array('conditions' => array('Application.id' => $app['Application']['id'])));
					$applicationInfo = $this->find('first', array(
						'fields' => array('Application.review_comments', 'Application.application_status', 'Application.checklisting_status_id', 'HeqfQualification.qualification_title', 'HeqfQualification.s1_qualification_reference_no'),
						'conditions' => array(
							'Application.id' => $app['Application']['id']
							),
						'contain' => 'HeqfQualification'
					));

					$update = array(
						"Application.user_id" => "'$adminID'",
						"Application.application_status" => "'Proceeding'",
						"Application.lkp_proceeding_type_id" => "'$proceedingType'",
						"Application.proceeding_status_id" => "'InstNew'",
					);
					$updateConditions['Application.id'] = $app['Application']['id'];

					if ($this->updateAll($update, $updateConditions)) {
						$lastProceedingOrder = $this->Proceeding->lastProceeding($app['Application']['id']);
						$newProceedingRow ['Proceeding']['application_id'] = $app['Application']['id'];
						$newProceedingRow ['Proceeding']['proceeding_type_id'] =  $proceedingType;
						$newProceedingRow ['Proceeding']['proc_status_id'] = 'InstNew';
						$newProceedingRow ['Proceeding']['proc_order'] =  $lastProceedingOrder + 1;
						$this->Proceeding->create();
						$this->Proceeding->save($newProceedingRow, array('validate' => false));

						$sendMail = true;
						$updatedData = $this->find('all', array('conditions' => array('Application.id' => $app['Application']['id'])));
						foreach ($currentData as $currentDataItem) {
							$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

							$this->saveDiff($currentDataItem, $updatedDataItem);
						}
					} else {
						$updateCount++;
					}

					if(!$updateCount){
						$sendMail =true;

						//Send Email to institution administrator when applications are returned
						$instAdm = $this->User->findById($adminID);
						$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $instAdm['User']['email_address'] : Configure::read('Email.debug_address');
						
						if (empty($emailData[$adminID])) {
							$emailData[$adminID] = array(
								'to' => $to,
								'subject' => Configure::read('System.email.prefix') . 'Notifications: Applications returned for ' . $proceedingTypeDesc ,
								'from' => Configure::read('System.email.from'),
								'bcc' => Configure::read('System.email.bcc'),
								'template' => 'return_inst_proceeding',
								'sendAs' => 'text',
								'variables' => array(
									'admin' => $instAdm,
									'current' => array($applicationInfo)
								)
							);
						} else {
							$emailData[$adminID]['variables']['current'][] = $applicationInfo;
						}						
					}
				} //else end
			}
			if ($sendMail && !empty($emailData)) {
				foreach ($emailData as $id => $data) {
					$this->sendEmail($data);
				}
			}

			if (!empty($institutionsNotFound)) {
				$institutionsNotFound = array_unique($institutionsNotFound);
				$institutionsNotFound = implode('</li><li>', $institutionsNotFound);
			}
			$errorMessage .= $institutionsNotFound . '</li></ul></div>';
			echo ($displayErrorMessage) ? $errorMessage : '';
			return ($updateCount) ? false : true;
		}
		return array(
			'listHeading' => __('Applications that will be returned to the institution for ' . $proceedingTypeDesc . ':' , true)
		);

	}

	public function returnForRepresentation($process, $params) {
		if (empty($params['data'])) {
			return false;
		}
		
		return $this->returnInstProceeding($process, $params);
		
	}

	public function returnForDeferral($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		return $this->returnInstProceeding($process, $params);
	}

	public function assignDeferralReviewer($process, $params) {
		if (empty($params['data'])) {
			return false;
		}
		
		return $this->assignProceedingToReviewer($process, $params);
	}

	public function assignRepresentationReviewer($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		return $this->assignProceedingToReviewer($process, $params);
	}

	public function assignProceedingToReviewer($process, $params) {
		$action = $params['form']['action'];
		$proceedingType = $this->_getProceedingByAction($action);
		$proceedingTypeDesc = $this->Proceeding->getProceedingTypeDesc($proceedingType);

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$userId = Sanitize::escape($params['data']['Application']['user_id']);
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions($action, array());
			$conditions['Application.id'] = $applications;

			$proceedingDueDate =  $this->_calculateDuedate($action);
			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array (
				'Application.user_id' => "'" . $userId . "'", 
				'Application.proceeding_status_id' => "'ReviewerNew'",
				'SubmittedProceeding.proc_status_id' => "'ReviewerNew'",
				'SubmittedProceeding.proc_user_id' => "'" . $userId . "'",
				'SubmittedProceeding.proc_due_date' => "'" . $proceedingDueDate . "'",
				'SubmittedProceeding.proc_assign_date' => "NOW()"

			);
			$reviewerArr = $this->User->findById($userId);
			$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $reviewerArr['User']['email_address'] : Configure::read('Email.debug_address');

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications), 'contain' => array('HeqfQualification', 'Institution')));
				$variableData =  Set::combine($updatedData, '{n}.Application.id', '{n}', '{n}.Institution.hei_name');
				$emailData = array(
					'to' => $to,
					'subject' => Configure::read('System.email.prefix') . 'Notifications: '. $proceedingTypeDesc . '(s) review',
					'from' => Configure::read('System.email.from'),
					'bcc' => Configure::read('System.email.bcc'),
					'template' => 'assign_proceeding_reviewer',
					'sendAs' => 'text',
					'variables' => array(
						'reviewer' => $reviewerArr,
						'data' => $variableData,
						'numberOfApplications' => count($applications),
						'proceedingDueDate' => $proceedingDueDate,
						'proceedingDesc' => $proceedingTypeDesc
					)
				);

				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}
				$this->sendEmail($emailData);
				return true;
			} else {
				$error = 'The requested action could not be performed.';
				throw new Exception(__($error, true));
			}
		}

		return array(
			'users' => $this->User->listByRole('d4674b78-e36c-11e0-a1b9-000c292ff614'),
			'listHeading' => __($proceedingTypeDesc . ' that will be assigned to the selected Reviewer:', true)
		);
	}

	public function returnEvaluation($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('return_evaluation', array());
			$conditions['Application.id'] = $applications;
			$allEvaluations = $this->Evaluation->find('all', array('fields' => array('Evaluation.id'), 'conditions'=> array('Evaluation.eval_inactive' => 0, 'Evaluation.eval_status_id' => 'New', 'Evaluation.eval_user_id' => Auth::get('User.id'), 'Evaluation.application_id' => $applications)));
			$evaluationId = Set::extract('/Evaluation/id', $allEvaluations);
			$conditions['Evaluation.id'] = $evaluationId;
			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array('Application.user_id' => "''", 'Application.evaluation_status_id' => "''", 'Evaluation.eval_inactive' => 1);

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));
					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				return true;
			}
		}

		return array(
			'listHeading' => __('Applications that will be returned to the CHE administrator:', true)
		);
	}

	public function assignReviewer($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Application']['user_id'])) {
			$userId = Sanitize::escape($params['data']['Application']['user_id']);
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('assign_reviewer', array());
			$conditions['Application.id'] = $applications;

			$reviewDueDate =  $this->_calculateDuedate($params['form']['action']);
			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array (
				'Application.user_id' => "'" . $userId . "'", 
				'Application.application_status' => "'Review'", 
				'Application.review_status_id' => "'New'",
				'Application.review_due_date' => "'" . $reviewDueDate . "'",
				'Application.review_assign_date' => "NOW()"

			);
			$reviewerArr = $this->User->findById($userId);
			$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $evaluatorArr['User']['email_address'] : Configure::read('Email.debug_address');

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications), 'contain' => array('HeqfQualification', 'Institution')));
				$variableData =  Set::combine($updatedData, '{n}.Application.id', '{n}', '{n}.Institution.hei_name');
				$emailData = array(
					'to' => $to,
					'subject' => Configure::read('System.email.prefix') . 'Notifications: Applications review',
					'from' => Configure::read('System.email.from'),
					'bcc' => Configure::read('System.email.bcc'),
					'template' => 'assign_reviewer',
					'sendAs' => 'text',
					'variables' => array(
						'reviewer' => $reviewerArr,
						'data' => $variableData,
						'numberOfApplications' => count($applications),
						'reviewDueDate' => $reviewDueDate
					)
				);

				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}
				$this->sendEmail($emailData);
				return true;
			}
		}

		// Find users with the role of evaluator
		return array(
			'users' => $this->User->listByRole('d4674b78-e36c-11e0-a1b9-000c292ff614'),
			'listHeading' => __('Applications that will be assigned to the selected Reviewer:', true)
		);
	}

	public function assignProcHeqcMeeting($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['LastReviewiedProceeding']['heqc_meeting_id']) && $params['data']['Process']['confirm'] == 1) {
			if (empty($params['data']['LastReviewiedProceeding']['heqc_meeting_id'])) {
				$error = 'Please select a meeting date.';
				throw new Exception(__($error, true));
			}

			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$meetingId = Sanitize::clean($params['data']['LastReviewiedProceeding']['heqc_meeting_id']);
			$conditions = $this->actionListConditions('assign_proc_heqc_meeting', array());
			$conditions['Application.id'] = $applications;

			$data['Application']['id'] = $applications;
			$data['LastReviewiedProceeding']['heqc_meeting_id'] = $meetingId;
		
			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array('LastReviewiedProceeding.heqc_meeting_id' => '\'' . $meetingId . '\'');

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));
					$this->saveDiff($currentDataItem, $updatedDataItem);
				}
				return true;
			} else {
				$error = 'The application could not be saved.';
				throw new Exception(__($error, true));
			}
		}

		return array(
			'HeqcMeeting' => $this->HeqcMeeting->find('list', array(
				'fields' => array('HeqcMeeting.id', 'HeqcMeeting.date'),
				'order' => array('HeqcMeeting.date')
				)
			),
			'listHeading' => __('Proceedings that will be assigned to the selected HEQC meeting:', true)
		);
	}

	function validateDate($date) {
		return (bool)strtotime($date);
	}

	public function reCategoriseToC($process, $params){
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['HeqfQualification']['s1_teachout_date']) && $params['data']['Process']['confirm'] == 1) {
			if (empty($params['data']['HeqfQualification']['s1_teachout_date'])) {
				$error = 'Please enter a Teach-out date.';
				throw new Exception(__($error, true));
			}
			$teachOutDate = $params['data']['HeqfQualification']['s1_teachout_date'];

			if (!$this->validateDate($teachOutDate)) {
				$error = 'Please enter a valid Teach-out date in the format yyyy-mm-dd.';
				throw new Exception(__($error, true));
			}

			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('re_categorise_to_c', array());
			$conditions['Application.id'] = $params['data']['Process']['selected'];

			$update = array(
				"HeqfQualification.s1_lkp_heqf_align_id" => "'C'",
				"HeqfQualification.catg_B_to_C_ind" => "'1'",
				"HeqfQualification.s1_error" => "0",
				"HeqfQualification.s2_error" => "0",
				"HeqfQualification.s3_error" => "0",
				"HeqfQualification.s1_teachout_date" => "'$teachOutDate'",
				"Application.archived" => "1",
				"Application.archive_date" => "NOW()",
				"Application.archived_by" => '\'' . Auth::get('User.id') . '\'',
				"Application.archive_reason" => "'Result of outcome: recat to C. Cat C application will be created.'"
			);

			$applicationList = $this->find('all', array(
				'fields' => array('Application.id', 'Application.institution_id', 'Application.heqf_qualification_id', 'Application.submission_user_id', 'Application.heqc_meeting_id'),
				'conditions' => $conditions,
				'contain' => array('HeqfQualification')
			));
			if ($this->updateAll($update, $conditions)) {
				foreach($applicationList as $applicationData) {
					$newRow = array(
						'heqf_qualification_id' => Sanitize::escape($applicationData['Application']['heqf_qualification_id']),
						'institution_id' => $applicationData['Application']['institution_id'],
						'submission_date' => date('Y-m-d'),
						'submission_user_id' => Sanitize::escape($applicationData['Application']['submission_user_id']),
						'heqc_meeting_id' => Sanitize::escape($applicationData['Application']['heqc_meeting_id']),
						'user_id' => '',
						'application_status' => "Submitted",
						'review_outcome_id' => "n",
						'lkp_outcome_id' => "n",
						'lkp_heqf_align_id' => "C",
						'outcome_accepted' => 1,
						'notified' => 1,
					);

					$this->create();
					$this->save($newRow, array('validate' => false));
				}
				return true;
			}
		}

		return array(
			'listHeading' => __('Application(s) that will be recategorised to C:', true)
		);
	}

/**
 * [markReviewed description]
 * @param  [type] $process [description]
 * @param  [type] $params  [description]
 * @return [type]          [description]
 * @throws Exception If Could not save
 */
	public function assignHeqcMeeting($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Application']['heqc_meeting'])) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$meetingDate = Sanitize::clean($params['data']['Application']['heqc_meeting']);
			$conditions = $this->actionListConditions('assign_heqc_meeting', array());
			$conditions['Application.id'] = $applications;

			$data['Application']['id'] = $applications;
			$data['Application']['heqc_meeting'] = $meetingDate;

			if ($this->saveAll($data, array('validate' => 'only'))) {
				$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				$update = array('Application.heqc_meeting_id' => '\'' . $meetingDate . '\'');

				if ($this->updateAll($update, $conditions)) {
					$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
					foreach ($currentData as $currentDataItem) {
						$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

						$this->saveDiff($currentDataItem, $updatedDataItem);
					}

					return true;
				}
			} else {
				$error = (empty($params['data']['Application']['heqc_meeting'])) ? 'Please select a meeting date.' : 'The application could not be saved.';
				throw new Exception(__($error, true));
			}
		}

		//get dates
		return array(
			'HeqcMeeting' => $this->HeqcMeeting->find('list', array(
				'fields' => array('HeqcMeeting.id', 'HeqcMeeting.date'),
				'order' => array('HeqcMeeting.date')
				)
			),
			'listHeading' => __('Applications that will be assigned to the selected HEQC meeting:', true)
		);
	}


	public function returnReview($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('return_review', array());
			$conditions['Application.id'] = $applications;

			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array('Application.user_id' => "''", 'Application.application_status' => "'Review'", 'Application.review_status_id' => "'Return'", 'Application.review_date' => "NOW()", 'Application.review_user_id' => '\'' . Auth::get('User.id') . '\'');

			if ($this->updateAll($update, $conditions)) {
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}

				return true;
			}
		}

		return array(
			'listHeading' => __('Applications that will be returned to the CHE administrator:', true)
		);
	}

	protected function _isProceeding($applicationId) {
		$applicationInfo = $this->find('first', array(
						'fields' => array('Application.id', 'application_status'),
						'conditions' => array('Application.id' => $applicationId)
					));
		return $applicationInfo['Application']['application_status'] == 'Proceeding' ? true : false;
	}

	public function markReviewed ($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$applications = array_unique(Sanitize::clean($params['data']['Process']['selected']));
			$conditions = $this->actionListConditions('mark_reviewed', array());

			$procUpdate = array('ReviewProceeding.proc_date' => "NOW()", 
				'ReviewProceeding.proc_inactive' => "'1'", 
				'ReviewProceeding.proc_status_id' => "'ReviewerComplete'",
				'Application.proceeding_status_id' => "'ReviewerComplete'",
				'Application.user_id' => "''",
			);
			$procData = array();
			$procConditions = array();
			$dataConditions = array();
			foreach ($applications as $applicationId) {
				if($this->_isProceeding($applicationId)){
					$procData['Application']['id'][] = $applicationId;
					$procConditions[] = $applicationId;
				} else {
					$data['Application']['id'][] =  $applicationId;
					$data['Application']['user_id'] = '';
					$data['Application']['application_status'] = 'Review';
					$data['Application']['review_status_id'] = 'Reviewed';
					$data['Application']['review_date'] = date('Y-m-d', time());
					$data['Application']['review_user_id'] = Auth::get('User.id');
					$dataConditions[] = $applicationId;
				}

			}

			if (!empty($procData) && !empty($procConditions)) { //case proceeding data
				$conditions['Application.id'] = $procConditions;
				$reviewProceeding = $this->ReviewProceeding->find('all', array('fields' => array('ReviewProceeding.id'), 'conditions'=> array('ReviewProceeding.proc_user_id' => Auth::get('User.id'), 'ReviewProceeding.application_id' => $procData['Application']['id'])));
				$reviewProceedingId = Set::extract('/ReviewProceeding/id', $reviewProceeding);
				$conditions['ReviewProceeding.id'] = $reviewProceedingId;
				$procCurrentData = $this->find('all', array('conditions' => array('Application.id' => $procData['Application']['id'])));
				if ($this->updateAll($procUpdate, $conditions)) {
					$procUpdatedData = $this->find('all', array('conditions' => array('Application.id' => $procData['Application']['id'])));
					foreach ($procCurrentData as $currentDataItem) {
						$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $procUpdatedData));

						$this->saveDiff($currentDataItem, $updatedDataItem);
					}

					return true;
				}
			}

			if (isset($data['Application']['id']) && !empty($data['Application']['id']) && !empty($dataConditions)) { //case review only data
				if(isset($conditions['Application.id'])){
					unset($conditions['Application.id']);
				}
				if(isset($conditions['ReviewProceeding.id'])){
					unset($conditions['ReviewProceeding.id']);
				}
				$conditions['Application.id'] = $dataConditions;

				if ($this->saveAll($data, array('validate' => 'only'))) {
					$currentData = $this->find('all', array('conditions' => array('Application.id' => $data['Application']['id'])));
					$update = array('Application.user_id' => "''", 'Application.application_status' => "'Review'", 'Application.review_status_id' => "'Reviewed'", 'Application.review_date' => "NOW()", 'Application.review_user_id' => '\'' . Auth::get('User.id') . '\'');

					if ($this->updateAll($update, $conditions)) {
						$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
						foreach ($currentData as $currentDataItem) {
							$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

							$this->saveDiff($currentDataItem, $updatedDataItem);
						}

						return true;
					}
				} else {
					$error = 'The application could not be saved.';
					throw new Exception(__($error, true));
				}
			}
		}

		return array(
			'listHeading' => __('Applications that will be marked as reviewed:', true)
		);
	}

	public function instSubmitProceeding($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$applications = Sanitize::clean($params['data']['Process']['selected']);
			$conditions = $this->actionListConditions('inst_submit_proceeding', array());
			$conditions['Application.id'] = $applications;
			
			$currentData = $this->find('all', array('conditions' => array('Application.id' => $applications)));
			$update = array(
				'Application.user_id' => "''",
				'Application.proceeding_status_id' => "'InstComplete'", 
				'Proceeding.proc_status_id' => "'InstComplete'", 
				'Proceeding.proc_submission_date' => "NOW()", 
				'Proceeding.proc_submission_user_id' => '\'' . Auth::get('User.id') . '\''
			);

			if ($this->updateAll($update, $conditions)) {
				$to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? Configure::read('System.email.che') : Configure::read('Email.debug_address');
				$updatedData = $this->find('all', array('conditions' => array('Application.id' => $applications), 'contain' => array('HeqfQualification', 'Institution')));
				$emailVariable =  Set::combine($updatedData, '{n}.Application.id', '{n}', '{n}.Institution.hei_name');
				foreach ($currentData as $currentDataItem) {
					$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

					$this->saveDiff($currentDataItem, $updatedDataItem);
				}
				$emailData = array(
					'to' => $to,
					'subject' => Configure::read('System.email.prefix') . 'Notifications: Submitted Representations/Deferrals',
					'from' => Configure::read('System.email.from'),
					'bcc' => Configure::read('System.email.bcc'),
					'template' => 'inst_submit_proceeding',
					'sendAs' => 'text',
					'variables' => array(
						'data' => $emailVariable,
						'numberOfApplications' => count($applications),
						
					)
				);
				$this->sendEmail($emailData);
				return true;
			} else {
				$error = 'The request changes could not be saved.';
				throw new Exception(__($error, true));
			}
		}

		return array(
			'listHeading' => __('Representations/Deferrals that will be submitted to CHE:', true)
		);
	}

/**
 * Set review outcome to aligned
 * @param [type] $process [description]
 * @param [type] $params  [description]
 */
	public function setReviewOutcome($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$applications = array_unique(Sanitize::clean($params['data']['Process']['selected']));
			$conditions = $this->actionListConditions('set_review_outcome', array());
			$procData = array();
			$data = array();
			$procConditions = array();
			$dataConditions = array();

			foreach ($applications as $applicationId) {
				if($this->_isProceeding($applicationId)){
					$procData['Application']['id'][] = $applicationId;
					$procConditions[] = $applicationId;
				} else {
					$data['Application']['id'][] =  $applicationId;
					$dataConditions[] = $applicationId;
				}

			}

			if (!empty($procData) && !empty($procConditions)) { //case proceeding data
				$conditions['Application.id'] = $procConditions;
				$reviewProceeding = $this->ReviewProceeding->find('all', array('fields' => array('ReviewProceeding.id'), 'conditions'=> array('ReviewProceeding.proc_user_id' => Auth::get('User.id'), 'ReviewProceeding.application_id' => $procData['Application']['id'])));
				$reviewProceedingId = Set::extract('/ReviewProceeding/id', $reviewProceeding);
				$conditions['ReviewProceeding.id'] = $reviewProceedingId;
				$procCurrentData = $this->find('all', array('conditions' => array('Application.id' => $procData['Application']['id'])));
				$procUpdate = array('ReviewProceeding.proc_lkp_outcome_id' => "'a'", 'Application.lkp_outcome_id' => "'a'");
				if ($this->updateAll($procUpdate, $conditions)) {
					$procUpdatedData = $this->find('all', array('conditions' => array('Application.id' => $procData['Application']['id'])));
					foreach ($procCurrentData as $currentDataItem) {
						$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $procUpdatedData));

						$this->saveDiff($currentDataItem, $updatedDataItem);
					}

					return true;
				}
			}

			if (isset($data['Application']['id']) && !empty($data['Application']['id']) && !empty($dataConditions)) { //case review only data
				if(isset($conditions['Application.id'])){
					unset($conditions['Application.id']);
				}
				if(isset($conditions['ReviewProceeding.id'])){
					unset($conditions['ReviewProceeding.id']);
				}
				$conditions['Application.id'] = $dataConditions;

				$currentData = $this->find('all', array('conditions' => array('Application.id' => $data['Application']['id'])));
				$update = array('Application.review_outcome_id' => "'a'", 'Application.lkp_outcome_id' => "'a'");

				if ($this->updateAll($update, $conditions)) {
					$updatedData = $this->find('all', array('conditions' => array('Application.id' => $data['Application']['id'])));
					foreach ($currentData as $currentDataItem) {
						$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

						$this->saveDiff($currentDataItem, $updatedDataItem);
					}

					return true;
				}
			}

			
		}

		return array(
			'listHeading' => __('Applications that will be set as aligned:', true)
		);
	}

	public function returnWithoutReview($process, $params) {
		if (empty($params['data'])) {
			return false;
		}

		if (isset($params['data']['Process']['confirm']) && $params['data']['Process']['confirm'] == 1) {
			$applications = array_unique(Sanitize::clean($params['data']['Process']['selected']));
			$conditions = $this->actionListConditions('return_without_review', array());
			$procUpdate = array(
				'Application.proceeding_status_id' => "'InstComplete'", 
				'Application.user_id' => "''",			
				'ReviewProceeding.proc_status_id' => "'InstComplete'",
				'ReviewProceeding.proc_user_id' => "''",
				'ReviewProceeding.proc_comments' => "''",
				'ReviewProceeding.proc_due_date' => "'1970-01-01'",
				'ReviewProceeding.proc_assign_date' => "'1970-01-01'"
			);

			$update = array(
				'Application.application_status' => "'Evaluation'", 
				'Application.evaluation_status_id' => "'Complete'", 
				'Application.user_id' => "''",
				'Application.review_status_id' => NUll
			);

			$procData = array();
			$procConditions = array();
			$dataConditions = array();
			foreach ($applications as $applicationId) {
				if($this->_isProceeding($applicationId)){
					$procData['Application']['id'][] = $applicationId;
					$procConditions[] = $applicationId;
				} else {
					$data['Application']['id'][] =  $applicationId;
					$dataConditions[] = $applicationId;
				}
			}

			if (!empty($procData) && !empty($procConditions)) { //case proceeding data
				$conditions['Application.id'] = $procConditions;
				$reviewProceeding = $this->ReviewProceeding->find('all', array('fields' => array('ReviewProceeding.id'), 'conditions'=> array('ReviewProceeding.proc_user_id' => Auth::get('User.id'), 'ReviewProceeding.application_id' => $procData['Application']['id'])));
				$reviewProceedingId = Set::extract('/ReviewProceeding/id', $reviewProceeding);
				$conditions['ReviewProceeding.id'] = $reviewProceedingId;
				$procCurrentData = $this->find('all', array('conditions' => array('Application.id' => $procData['Application']['id'])));
				if ($this->updateAll($procUpdate, $conditions)) {
					$procUpdatedData = $this->find('all', array('conditions' => array('Application.id' => $procData['Application']['id'])));
					foreach ($procCurrentData as $currentDataItem) {
						$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $procUpdatedData));

						$this->saveDiff($currentDataItem, $updatedDataItem);
					}

					return true;
				}
			}

			if (isset($data['Application']['id']) && !empty($data['Application']['id']) && !empty($dataConditions)) { //case review only data
				if(isset($conditions['Application.id'])){
					unset($conditions['Application.id']);
				}
				if(isset($conditions['ReviewProceeding.id'])){
					unset($conditions['ReviewProceeding.id']);
				}
				$conditions['Application.id'] = $dataConditions;

				$currentData = $this->find('all', array('conditions' => array('Application.id' => $data['Application']['id'])));
				if ($this->updateAll($update, $conditions)) {
					$updatedData = $this->find('all', array('conditions' => array('Application.id' => $data['Application']['id'])));
					foreach ($currentData as $currentDataItem) {
						$updatedDataItem = end(Set::extract('/Application[id=' . $currentDataItem['Application']['id'] . ']', $updatedData));

						$this->saveDiff($currentDataItem, $updatedDataItem);
					}

					return true;
				}
			}

		}

		return array(
			'listHeading' => __('Applications that will be returned to the administrator without being reviewed:', true)
		);
	}

	public function captureOutcome() {
		return array(
			'listHeading' => __('Applications for which to capture an outcome:', true)
		);
	}

	public function actionPermission($action) {
		switch ($action) {
			case 'archive':
				return 'delete';
			case 'send_back':
			case 'return_evaluation':
			case 'mark_reviewed':
			case 'return_review':
			case 'set_review_outcome':
			case 'return_without_review':
			case 'inst_submit_proceeding':
				return 'update';
			case 'assign':
			case 're_submit':
			case 'submit':
			case 'take_back':
				return 'inst_admin';
			case 'return_inst':
			case 'return_inst_review':
			case 'assign_checklister':
			case 'assign_evaluator':
			case 'assign_reviewer':
			case 'capture_outcome':
			case 'assign_heqc_meeting':
			case 'assign_proc_heqc_meeting':
			case 'return_for_representation':
			case 'return_for_deferral':
			case 'assign_representation_reviewer':
			case 'assign_deferral_reviewer':
			case 're_categorise_to_c':
				return 'admin';
		}
	}

	public function fetchLookups() {
		$lookups = array();

		$lookups['ChecklistingStatus'] = $this->ChecklistingStatus->find('list', array('fields' => array('ChecklistingStatus.id', 'ChecklistingStatus.description')));
		$lookups['EvaluationStatus'] = $this->EvaluationStatus->find('list', array('fields' => array('EvaluationStatus.id', 'EvaluationStatus.description'), 'conditions' => array('EvaluationStatus.id' => array('New', 'Complete'))));
		$lookups['AppHeqfAlign'] = $this->AppHeqfAlign->find('list', array('fields' => array('AppHeqfAlign.id', 'AppHeqfAlign.heqf_align_desc')));
		$lookups['Outcome'] = $this->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc'), 'conditions' => array('Outcome.id' => array('a', 'r', 'n'))));
		$lookups['ProceedingType'] = $this->ProceedingType->find('list');
		$lookups['ReviewOutcome'] = $this->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc'), 'conditions' => array('Outcome.id' => array('ni', 'nr', 'a'))));
		$lookups['AllOutcome'] = $this->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc')));
		$lookups['QualificationType'] = $this->HeqfQualification->QualificationType->find('list');
		$lookups['Cesm1Code'] = $this->HeqfQualification->Cesm1Code->find('list');
		$lookups['Cesm2Code'] = $this->HeqfQualification->Cesm2Code->find('list');
		$lookups['NqfLevel'] = $this->HeqfQualification->NqfLevel->find('list');
		$lookups['Designator'] = $this->HeqfQualification->Designator->find('list');
		$lookups['DeliveryMode'] = $this->HeqfQualification->DeliveryMode->find('list');
		$lookups['ProfessionalClass'] = $this->HeqfQualification->ProfessionalClass->find('list');
		$lookups['Institution'] = $this->Institution->find('list');
		$lookups['Cesm3Code'] = $this->HeqfQualification->Cesm3Code->find('list');
		$lookups['CesmCode'] = $this->HeqfQualification->CesmCode->find('list');
		$lookups['HemisQualifier'] = $this->HeqfQualification->HemisQualifier->find('list');
		$lookups['HemisHeqfQualificationType'] = $this->HeqfQualification->HemisHeqfQualificationType->find('list');
		$lookups['S1HemisQualificationType'] = $this->HeqfQualification->S1HemisQualificationType->find('list');
		$lookups['HemisFundingLevel'] = $this->HeqfQualification->HemisFundingLevel->find('list');
		$lookups['HeqcMeeting'] = $this->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
		$lookups['Status'] = $this->status;
		$lookups['CurrentUser'] = (Auth::checkRole('che_admin')) ? 
				$this->User->find('list', array('order'=>array('User.first_name'=>'ASC'))) : 
				$this->User->find('list', 
					array(
					'conditions' => array(
						'User.institution_id' => Auth::get('User.institution_id')
						),
					'order'=>array('User.first_name'=>'ASC')
					)
				);
		//$lookups['ReviewUser'] = (Auth::checkRole('che_admin')) ? $this->User->find('list',array('order'=>array('User.first_name'=>'ASC'))) : array();
		$lookups['ReviewUser'] = $this->User->listByRole('d4674b78-e36c-11e0-a1b9-000c292ff614');
		$lookups['ModuleAction'] = $this->HeqfQualification->HeqfQualificationModule->ModuleAction->find('list', array('fields' => array('ModuleAction.id', 'ModuleAction.action')));
		return $lookups;
	}

	public function filterFlows(&$process, $data) {
		if (!empty($data['HeqfQualification'])) {
			if (($data['HeqfQualification']['s1_lkp_heqf_align_id'] != 'B') && ((isset($data['HeqfQualification']['s1_lkp_heqf_align_id']) && ($data['HeqfQualification']['s1_lkp_heqf_align_id'] == 'C')) || ($data['HeqfQualification']['qualification_reference_no'] == ''))) {
				unset($process['currentProcess']['Flow'][1]);
				unset($process['currentProcess']['Flow'][3]);
			}
		}
	}

	private function __checklistingStatus($data) {
		$return = $data['Application']['checklisting_user_id'];

		if ($data['Application']['checklisting_status_id'] != 'New') {
			$return = '';
		}

		return $return;
	}

	public function appAlignmentReport($conditions) {
		return array(
			'contain' => array(
				'HeqfQualification',
				'User',
				'EvalUser',
				'Institution',
				'ReviewUser',
				'ChecklistUser',
				'AppHeqfAlign',
				'Outcome',
				'HeqcMeeting' => array(
					'fields' => array(
						'id',
						'date'
					)
				)
			),
			'order' => array(
				'Institution.hei_name',
				'HeqfQualification.s1_qualification_title',
				'HeqfQualification.lkp_qualification_type_id',
			),
			'conditions' => array(
				'Application.submission_date !=' => '1970-01-01',
				'Application.archived' => '0'
			)
		);
	}

	public function outcomeSummaryReport($conditions) {
		$sumFields = array(
			'total' => array(
				'Application.archived' => array(0, 1)
			),
			'category_A_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'accredited_A_A_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'A',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'accredited_A_B_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'B',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'accredited_A_C_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'C',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'category_A_B_accredited_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
				'Application.lkp_heqf_align_id' => 'B',
				'Application.lkp_outcome_id' => 'a',
			),
			'category_A_C_accredited_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
				'Application.lkp_heqf_align_id' => 'C',
				'Application.lkp_outcome_id' => 'a',
			),
			're_categorised_A_A' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'A',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			're_categorised_A_B' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'B',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			're_categorised_A_C' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'C',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'not_aligned_A' => array(
				'Application.lkp_outcome_id' => 'n',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'no_outcome_A' => array(
				'Application.lkp_outcome_id' => '',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			'archived_A' => array(
				'Application.archived' => 1,
				'HeqfQualification.s1_lkp_heqf_align_id' => 'A',
			),
			/*---------A---------*/
			/*---------B---------*/
			'category_B_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			'accredited_B_B_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'B',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			'accredited_B_A_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'A',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			'accredited_B_C_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'C',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			'category_B_A_accredited_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
				'Application.lkp_heqf_align_id' => 'A',
				'Application.lkp_outcome_id' => 'a',
			),
			'category_B_C_accredited_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
				'Application.lkp_heqf_align_id' => 'C',
				'Application.lkp_outcome_id' => 'a',
			),
			're_categorised_B_A' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'A',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			're_categorised_B_B' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'B',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			're_categorised_B_C' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'C',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			'not_aligned_B' => array(
				'Application.lkp_outcome_id' => 'n',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'no_outcome_B' => array(
				'Application.lkp_outcome_id' => '',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			'archived_B' => array(
				'Application.archived' => 1,
				'HeqfQualification.s1_lkp_heqf_align_id' => 'B',
			),
			/*---------B---------*/
			/*---------C---------*/
			'category_C_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'accredited_C_C_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'C',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'accredited_C_A_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'A',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'accredited_C_B_total' => array(
				'Application.lkp_outcome_id' => 'a',
				'Application.lkp_heqf_align_id' => 'B',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'category_C_A_accredited_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
				'Application.lkp_heqf_align_id' => 'A',
				'Application.lkp_outcome_id' => 'a',
			),
			'category_C_B_accredited_total' => array(
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
				'Application.lkp_heqf_align_id' => 'B',
				'Application.lkp_outcome_id' => 'a',
			),
			're_categorised_C_A' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'A',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			're_categorised_C_B' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'B',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			're_categorised_C_C' => array(
				'Application.lkp_outcome_id' => 'r',
				'Application.lkp_heqf_align_id' => 'C',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'not_aligned_C' => array(
				'Application.lkp_outcome_id' => 'n',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'no_outcome_C' => array(
				'Application.lkp_outcome_id' => '',
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
			'archived_C' => array(
				'Application.archived' => 1,
				'HeqfQualification.s1_lkp_heqf_align_id' => 'C',
			),
		);
		$this->virtualFields = array();
		$this->__buildVirtualSumFields($sumFields);

		$fields = array_keys($this->virtualFields);

		$conditions['Application.archived'] = array(0, 1);

		$return = $this->find('all',
			array(
				'fields' => $fields,
				'contain' => array(
					'HeqfQualification' => array('fields' => array('HeqfQualification.s1_qualification_title', 'HeqfQualification.s1_lkp_heqf_align_id')),
					'Institution' => array('fields' => array('Institution.hei_name', 'Institution.hei_code')),
					'AppHeqfAlign',
					'Outcome'
				),
				'order' => array(
					'Institution.hei_name',
					'HeqfQualification.s1_qualification_title',
					'HeqfQualification.lkp_qualification_type_id',
				),
				'conditions' => $conditions,
				'group' => 'Institution.hei_name',
			)
		);

		return $return;
	}

	public function outcomeAlignmentApplications($conditions) {
		$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.hei_code') : '';
		return $this->getOutcomeApplicationsCat($institution, $conditions);
	}

	public function listOutcomesReport($conditions) {
		return $this->getOutcomeApplicationsList($conditions);
	}

	public function getOutcomeApplicationsCat($institution, $conditions) {
		ini_set('memory_limit', -1);
		$conditionsInst = array();
		$conditionsQual = array();
		if (isset($conditions['Application.institution_id'])) {
			$conditionsInst['Institution.id'] = $conditions['Application.institution_id'];
			unset($conditions['Application.institution_id']);
		}
		if (!empty($institution)) {
			$conditionsInst['Institution.hei_code'] = $institution;
		}
		if(isset($conditions['HeqfQualification.lkp_delivery_mode_id'])){
			$conditionsQual['HeqfQualification.lkp_delivery_mode_id'] = $conditions['HeqfQualification.lkp_delivery_mode_id'];
			unset($conditions['HeqfQualification.lkp_delivery_mode_id']);
		}

		$return = $this->Institution->find('all',
			array(
				'conditions' => $conditionsInst,
				'contain' => array(
					'Application' => array(
						'HeqfQualification' => array(
							'fields' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
								'HeqfQualification.s1_lkp_heqf_align_id',
								'HeqfQualification.heqf_reference_no',
								'HeqfQualification.s1_qualification_reference_no',
								'HeqfQualification.s1_lkp_delivery_mode_id',
								'HeqfQualification.lkp_delivery_mode_id',
								'HeqfQualification.saqa_qualification_id',
								'HeqfQualification.s1_lkp_nqf_level_id',
								'HeqfQualification.lkp_nqf_level_id',
								'HeqfQualification.s1_credits_total',
								'HeqfQualification.credits_total'
							),
							'order' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
							)
						),
						'AppHeqfAlign',
						'Outcome',
						'fields' => array(
							'Application.lkp_heqf_align_id',
						),
						'conditions' => array(
							'Application.submission_date !=' => '1970-01-01',
							'Application.outcome_accepted' => true,
							'Application.notified' => true
						)
					)
				),
				'order' => array(
					'Institution.hei_name',
				),
				'fields' => array(
					'Institution.hei_name',
					'Institution.hei_code'
				)
			)
		);

		$finalData = array();

		if (!empty($return)) {
			$count = 0;
			foreach ($return as $info) {
				if (!empty($info['Application'])) {
					if(!empty($conditionsQual)){
						foreach ($info['Application'] as $key => $value) {
							if(isset($value['HeqfQualification']['lkp_delivery_mode_id']) && ($value['HeqfQualification']['lkp_delivery_mode_id'] != $conditionsQual['HeqfQualification.lkp_delivery_mode_id'])){
								unset($info['Application'][$key]);								
							}
						}
					}
									
					foreach ($info['Application'] as $application) {											
						if (!empty($application['Outcome'])) {
							$keyName = $info['Institution']['hei_name'] . ' (' . $info['Institution']['hei_code'] . ')';
							$keyOutome = $application['Outcome']['outcome_desc'];
							$category = $application['lkp_heqf_align_id'];						
								$finalData[$keyName][$keyOutome][$category][$count]['Existing qualification name'] = $application['HeqfQualification']['s1_qualification_title'];
								$finalData[$keyName][$keyOutome][$category][$count]['HEQSF reference number'] = $application['HeqfQualification']['heqf_reference_no'];
								$finalData[$keyName][$keyOutome][$category][$count]['Qualification reference number'] = $application['HeqfQualification']['s1_qualification_reference_no'];
								$finalData[$keyName][$keyOutome][$category][$count]['SAQA qualification ID'] = $application['HeqfQualification']['saqa_qualification_id'];
							if ($category == 'C'){
								$finalData[$keyName][$keyOutome][$category][$count]['Aligned qualification name'] = '';
								$finalData[$keyName][$keyOutome][$category][$count]['NQF'] = isset($application['HeqfQualification']['s1_lkp_nqf_level_id']) ? $application['HeqfQualification']['s1_lkp_nqf_level_id'] : '';
								$finalData[$keyName][$keyOutome][$category][$count]['Total credits'] = $application['HeqfQualification']['s1_credits_total'];
							} else {
								$finalData[$keyName][$keyOutome][$category][$count]['Aligned qualification name'] = $application['HeqfQualification']['qualification_title'];
								$finalData[$keyName][$keyOutome][$category][$count]['NQF'] = isset($application['HeqfQualification']['lkp_nqf_level_id']) ? $application['HeqfQualification']['lkp_nqf_level_id'] : '';
								$finalData[$keyName][$keyOutome][$category][$count]['Total credits'] = $application['HeqfQualification']['credits_total'];
							}
						} else {
							$keyName = $info['Institution']['hei_name'] . ' (' . $info['Institution']['hei_code'] . ')';
							$category = '';
							$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['Existing qualification name'] = isset($application['HeqfQualification']['s1_qualification_title']) ? $application['HeqfQualification']['s1_qualification_title'] : '';
							$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['HEQSF reference number'] = isset($application['HeqfQualification']['heqf_reference_no']) ? $application['HeqfQualification']['heqf_reference_no'] : '';
							$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['Qualification reference number'] = isset($application['HeqfQualification']['s1_qualification_reference_no']) ? $application['HeqfQualification']['s1_qualification_reference_no'] : '';
							$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['SAQA qualification ID'] = isset($application['HeqfQualification']['saqa_qualification_id']) ? $application['HeqfQualification']['saqa_qualification_id'] : '';
							if ($category == 'C'){
								$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['Aligned qualification name'] = '';
								$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['NQF'] = isset($application['HeqfQualification']['s1_lkp_nqf_level_id']) ? $application['HeqfQualification']['s1_lkp_nqf_level_id'] : '';
								$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['Total credits'] = isset($application['HeqfQualification']['s1_credits_total']) ? $application['HeqfQualification']['s1_credits_total'] : '';
							} else {
								$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['Aligned qualification name'] = isset($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] : '';
								$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['NQF'] = isset($application['HeqfQualification']['lkp_nqf_level_id']) ? $application['HeqfQualification']['lkp_nqf_level_id'] : '';
								$finalData[$keyName]['No outcome (not yet processed)'][$category][$count]['Total credits'] = isset($application['HeqfQualification']['credits_total']) ? $application['HeqfQualification']['credits_total'] : '';
							}

						}
						$count++;
					}
				}
			}
		}

		return $finalData;
	}

	public function getOutcomeApplicationsList($conditions) {
		$conditionsInst = array();
		$conditionsQual = array();
		if (isset($conditions['Application.institution_id'])) {
			$conditionsInst['Institution.id'] = $conditions['Application.institution_id'];
		}
		if (isset($conditions['HeqfQualification.s1_lkp_heqf_align_id'])) {
			$conditionsQual['HeqfQualification.s1_lkp_heqf_align_id'] = $conditions['HeqfQualification.s1_lkp_heqf_align_id'];
			unset($conditions['HeqfQualification.s1_lkp_heqf_align_id']);
		}
		if (isset($conditions['HeqfQualification.lkp_delivery_mode_id'])) {
			$conditionsQual['HeqfQualification.lkp_delivery_mode_id'] = $conditions['HeqfQualification.lkp_delivery_mode_id'];
			unset($conditions['HeqfQualification.lkp_delivery_mode_id']);
		}
		$return = $this->Institution->find('all',
			array(
				'conditions' => $conditionsInst,
				'contain' => array(
					'Application' => array(
						'HeqfQualification' => array(
							'fields' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.lkp_delivery_mode_id',
								'HeqfQualification.qualification_title',
								'HeqfQualification.s1_lkp_heqf_align_id',
								'HeqfQualification.lkp_cesm1_code_id',
								'HeqfQualification.hemis_lkp_cesm3_code_id',
								'HeqfQualification.qualification_title_short',
								'HeqfQualification.saqa_qualification_id',
								'HeqfQualification.lkp_nqf_level_id',
								'HeqfQualification.credits_total'
							),
							'order' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
							),
							'conditions' => $conditionsQual
						),
						'AppHeqfAlign',
						'Outcome',
						'fields' => array(
							'Application.lkp_heqf_align_id'
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
				)
			)
		);

		$finalData = array();
		if (!empty($return)) {
			$count = 0;
			foreach ($return as $info) {
				if (!empty($info['Application'])) {
					foreach ($info['Application'] as $application) {
						if (!empty($application['Outcome']) && !empty($application['HeqfQualification'])) {
							$keyName = $info['Institution']['hei_name'] . ' (' . $info['Institution']['hei_code'] . ')';
							$keyOutome = $application['Outcome']['outcome_desc'];
							$finalData[$keyName][$keyOutome][$count]['Existing qualification name'] = isset($application['HeqfQualification']['s1_qualification_title']) ? $application['HeqfQualification']['s1_qualification_title'] : '';
							$finalData[$keyName][$keyOutome][$count]['Aligned qualification name'] = isset($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] : '';
							$finalData[$keyName][$keyOutome][$count]['Category'] = $application['HeqfQualification']['s1_lkp_heqf_align_id'];
							$finalData[$keyName][$keyOutome][$count]['CESM'] = isset($application['HeqfQualification']['lkp_cesm1_code_id']) ? $application['HeqfQualification']['lkp_cesm1_code_id'] : '';
							$finalData[$keyName][$keyOutome][$count]['Mode of delivery'] = isset($application['HeqfQualification']['lkp_delivery_mode_id']) ? $application['HeqfQualification']['lkp_delivery_mode_id'] : '';
							$finalData[$keyName][$keyOutome][$count]['Major field of study'] = isset($application['HeqfQualification']['hemis_lkp_cesm3_code_id']) ? $application['HeqfQualification']['hemis_lkp_cesm3_code_id'] : '';
							$finalData[$keyName][$keyOutome][$count]['Qualification title abbreviation'] = $application['HeqfQualification']['qualification_title_short'];
							$finalData[$keyName][$keyOutome][$count]['SAQA qualification ID'] = $application['HeqfQualification']['saqa_qualification_id'];
							$finalData[$keyName][$keyOutome][$count]['NQF'] = isset($application['HeqfQualification']['lkp_nqf_level_id']) ? $application['HeqfQualification']['lkp_nqf_level_id'] : '';
							$finalData[$keyName][$keyOutome][$count]['Total credits'] = $application['HeqfQualification']['credits_total'];
							$count++;
						}
					}
				}
			}
		}

		return $finalData;
	}

	public function institutionOfferings($conditions) {
		$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.id') : '';
		$conditionsFinal['Institution.id'] = $institution;
		$conditionsQual = array();
		if (isset($conditions['Application.institution_id'])) {
			$conditionsFinal['Institution.id'] = $conditions['Application.institution_id'];
		}

		if (isset($conditions['HeqfQualification.lkp_delivery_mode_id'])) {
			$conditionsQual['HeqfQualification.lkp_delivery_mode_id'] = $conditions['HeqfQualification.lkp_delivery_mode_id'];
		}
		$return = $this->Institution->find('all',
			array(
				'conditions' => $conditionsFinal,
				'contain' => array(
					'Application' => array(
						'HeqfQualification' => array(
							'fields' => array(
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
								'HeqfQualification.qualification_reference_no',
								'HeqfQualification.lkp_qualification_type_id',
								'HeqfQualification.qualification_title_short',
								'HeqfQualification.lkp_designator_id',
								'HeqfQualification.other_designator',
								'HeqfQualification.first_qualifier',
								'HeqfQualification.lkp_cesm2_code_id',
								'HeqfQualification.second_qualifier',
								'HeqfQualification.lkp_cesm3_code_id',
								'HeqfQualification.hemis_lkp_cesm3_code_id',
								'HeqfQualification.lkp_nqf_level_id',
								'HeqfQualification.credits_total',
								'HeqfQualification.wil_el_credits',
								'HeqfQualification.research_credits',
								'HeqfQualification.hemis_total_subsidy_units',
								'HeqfQualification.lkp_hemis_funding_level_id',
								'HeqfQualification.lkp_delivery_mode_id',
								'HeqfQualification.heqf_reference_no',
								'HeqfQualification.saqa_qualification_id'

							)
						),
						'AppHeqfAlign',
						'Outcome',
						'fields' => array(
							'Application.lkp_heqf_align_id',
							'Application.outcome_approval_date'
						),
						'conditions' => array(
							'Application.submission_date !=' => '1970-01-01',
							'Application.lkp_outcome_id' => 'a',
							'Application.outcome_accepted' => true,
							'Application.notified' => true
						)
					),
				),
				'order' => array(
					'Institution.hei_name',
				),
				'fields' => array(
					'Institution.hei_name',
					'Institution.hei_code'
				)
			)
		);

		$finalReturn = array();
		if (!empty($return)) {
			if(!empty($conditionsQual)){
				foreach ($return as $key => $value) {
					foreach ($value['Application'] as $appIndex => $appArr) {	
						if(isset($appArr['HeqfQualification']['lkp_delivery_mode_id']) && ($appArr['HeqfQualification']['lkp_delivery_mode_id'] != $conditionsQual['HeqfQualification.lkp_delivery_mode_id'])){
							unset($return[$key]['Application'][$appIndex]);								
						}
					}
				}
			}
			foreach ($return as $data) {
				foreach ($data['Application'] as $application) {
					$application['HeqfQualification']['outcome_approval_date'] = $application['outcome_approval_date'];
					$finalReturn[$application['HeqfQualification']['lkp_qualification_type_id']][] = $application['HeqfQualification'];
				}
			}
		}

		$this->aasort($finalReturn, "qualification_reference_no");

		return $finalReturn;
	}

	public function institutionSubmissions($conditions) {
		$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.id') : '';
		$conditionsFinal['Institution.id'] = $institution;
		$conditionsQual = array();
		if (isset($conditions['Application.institution_id'])) {
			$conditionsFinal['Institution.id'] = $conditions['Application.institution_id'];
		}

		if (isset($conditions['HeqfQualification.lkp_delivery_mode_id'])) {
			$conditionsQual['HeqfQualification.lkp_delivery_mode_id'] = $conditions['HeqfQualification.lkp_delivery_mode_id'];
		}
		$return = $this->Institution->find('all',
			array(
				'conditions' => $conditionsFinal,
				'contain' => array(
					'Application' => array(
						'HeqfQualification' => array(
							'fields' => array(
								'HeqfQualification.s1_lkp_heqf_align_id',
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
								'HeqfQualification.s1_qualification_reference_no',
								'HeqfQualification.qualification_reference_no',
								'HeqfQualification.lkp_qualification_type_id',
								'HeqfQualification.qualification_title_short',
								'HeqfQualification.lkp_designator_id',
								'HeqfQualification.other_designator',
								'HeqfQualification.first_qualifier',
								'HeqfQualification.lkp_cesm2_code_id',
								'HeqfQualification.second_qualifier',
								'HeqfQualification.lkp_cesm3_code_id',
								'HeqfQualification.hemis_lkp_cesm3_code_id',
								'HeqfQualification.lkp_nqf_level_id',
								'HeqfQualification.s1_lkp_nqf_level_id',
								'HeqfQualification.credits_total',
								'HeqfQualification.s1_credits_total',
								'HeqfQualification.wil_el_credits',
								'HeqfQualification.research_credits',
								'HeqfQualification.hemis_total_subsidy_units',
								'HeqfQualification.s1_hemis_total_subsidy_units',
								'HeqfQualification.lkp_hemis_funding_level_id',
								'HeqfQualification.s1_lkp_hemis_funding_level_id',
								'HeqfQualification.lkp_delivery_mode_id',
								'HeqfQualification.s1_lkp_delivery_mode_id',
								'HeqfQualification.heqf_reference_no',
								'HeqfQualification.s1_teachout_date',
								'HeqfQualification.saqa_qualification_id'
							),
						),
						'AppHeqfAlign',
						'Outcome',
						'fields' => array(
							'Application.lkp_heqf_align_id',
							'Application.outcome_approval_date'
						),
						'conditions' => array(
							'Application.submission_date !=' => '1970-01-01',
							'Application.archived' => '0'
						)
					),
				),
				'order' => array(
					'Institution.hei_name',
				),
				'fields' => array(
					'Institution.hei_name',
					'Institution.hei_code'
				)
			)
		);

		$finalReturn = array();
		if (!empty($return)) {
			if(!empty($conditionsQual)){
				foreach ($return as $key => $value) {
					foreach ($value['Application'] as $appIndex => $appArr) {
						if(!($appArr['HeqfQualification']['lkp_delivery_mode_id']) || (isset($appArr['HeqfQualification']['lkp_delivery_mode_id']) && ($appArr['HeqfQualification']['lkp_delivery_mode_id'] != $conditionsQual['HeqfQualification.lkp_delivery_mode_id']))){
							unset($return[$key]['Application'][$appIndex]);								
						}
					}
				}
			}
			foreach ($return as $data) {
				foreach ($data['Application'] as $application) {
					$application['HeqfQualification']['outcome_approval_date'] = $application['outcome_approval_date'];
					$finalReturn[$application['HeqfQualification']['lkp_qualification_type_id']][] = $application['HeqfQualification'];
				}
			}
		}

		$this->aasort($finalReturn, "qualification_reference_no");

		return $finalReturn;
	}

	public function institutionAll($conditions) {
		$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.id') : '';
		$conditionsFinal['Institution.id'] = $institution;
		$conditionsQual = array();
		if (isset($conditions['Application.institution_id'])) {
			$conditionsFinal['Institution.id'] = $conditions['Application.institution_id'];
		}

		if (isset($conditions['HeqfQualification.lkp_delivery_mode_id'])) {
			$conditionsQual['HeqfQualification.lkp_delivery_mode_id'] = $conditions['HeqfQualification.lkp_delivery_mode_id'];
		}
		$return = $this->Institution->find('all',
			array(
				'conditions' => $conditionsFinal,
				'contain' => array(
					'Application' => array(
						'HeqfQualification' => array(
							'fields' => array(
								'HeqfQualification.s1_lkp_heqf_align_id',
								'HeqfQualification.s1_qualification_title',
								'HeqfQualification.qualification_title',
								'HeqfQualification.s1_qualification_reference_no',
								'HeqfQualification.qualification_reference_no',
								'HeqfQualification.lkp_qualification_type_id',
								'HeqfQualification.qualification_title_short',
								'HeqfQualification.lkp_designator_id',
								'HeqfQualification.other_designator',
								'HeqfQualification.first_qualifier',
								'HeqfQualification.lkp_cesm2_code_id',
								'HeqfQualification.second_qualifier',
								'HeqfQualification.lkp_cesm3_code_id',
								'HeqfQualification.hemis_lkp_cesm3_code_id',
								'HeqfQualification.lkp_nqf_level_id',
								'HeqfQualification.s1_lkp_nqf_level_id',
								'HeqfQualification.credits_total',
								'HeqfQualification.s1_credits_total',
								'HeqfQualification.wil_el_credits',
								'HeqfQualification.research_credits',
								'HeqfQualification.hemis_total_subsidy_units',
								'HeqfQualification.s1_hemis_total_subsidy_units',
								'HeqfQualification.lkp_hemis_funding_level_id',
								'HeqfQualification.s1_lkp_hemis_funding_level_id',
								'HeqfQualification.lkp_delivery_mode_id',
								'HeqfQualification.s1_lkp_delivery_mode_id',
								'HeqfQualification.heqf_reference_no',
								'HeqfQualification.s1_teachout_date',
								'HeqfQualification.saqa_qualification_id'
							),
						),
						'AppHeqfAlign',
						'Outcome',
						'fields' => array(
							'Application.lkp_heqf_align_id',
							'Application.outcome_approval_date'
						),
						'conditions' => array(
						)
					),
				),
				'order' => array(
					'Institution.hei_name',
				),
				'fields' => array(
					'Institution.hei_name',
					'Institution.hei_code'
				)
			)
		);

		$finalReturn = array();
		if (!empty($return)) {
			if(!empty($conditionsQual)){
				foreach ($return as $key => $value) {
					foreach ($value['Application'] as $appIndex => $appArr) {
						if(!($appArr['HeqfQualification']['lkp_delivery_mode_id']) || (isset($appArr['HeqfQualification']['lkp_delivery_mode_id']) && ($appArr['HeqfQualification']['lkp_delivery_mode_id'] != $conditionsQual['HeqfQualification.lkp_delivery_mode_id']))){
							unset($return[$key]['Application'][$appIndex]);								
						}
					}
				}
			}
			foreach ($return as $data) {
				foreach ($data['Application'] as $application) {
					$application['HeqfQualification']['outcome_approval_date'] = $application['outcome_approval_date'];
					$finalReturn[$application['HeqfQualification']['lkp_qualification_type_id']][] = $application['HeqfQualification'];
				}
			}
		}

		$this->aasort($finalReturn, "qualification_reference_no");

		return $finalReturn;
	}

	public function aasort(&$array, $key) {
		$sorter = array();
		$ret = array();
		reset($array);
		foreach ($array as $levelOne => $arrayOne) {
			foreach ($arrayOne as $levelTwo => $arrayTwo) {
				$sorter[$levelOne][$levelTwo] = $arrayTwo[$key];
			}
		}
		asort($sorter);
		foreach ($sorter as $levelOne => $arrayOne) {
			foreach ($arrayOne as $levelTwo => $arrayTwo) {
				if (isset($arrayTwo[$key])) {
					$sorter[$levelOne][$levelTwo] = $arrayTwo[$key];
				}
				$ret[$levelOne][$levelTwo] = $array[$levelOne][$levelTwo];
			}
		}
		$array = $ret;
	}

	public function outcomeNotificationsLetter($conditions) {
		$docData = array();

		if (!empty($conditions)) {
			$docData = $this->find('all', array(
				'fields' => array(
					'Application.institution_id',
					'Application.heqc_meeting_id'
				),
				'contain' => array(
					'Outcome' => array(
						'fields' => array(
							'id',
							'outcome_desc'
						)
					),
					'HeqcMeeting' => array(
						'fields' => array(
							'id',
							'date'
						)
					),
					'HeqfQualification' => array(
						'fields' => array(
							'qualification_title',
							'qualification_reference_no',
							's1_qualification_title',
							's1_lkp_heqf_align_id',
							's1_qualification_reference_no'
						)
					),
					'Institution'
				),
				'conditions' => array(
					'HeqcMeeting.date' => $conditions['date'],
					'Application.institution_id' => $conditions['id'],
				)
			));
		}

		return $docData;
	}

	public function proceedingOutcomeNotificationsLetter($conditions) {
		$docData = array();

		if (!empty($conditions)) {
			$docData = $this->Proceeding->getHeqcProceedings($conditions);
		}

		return $docData;
	}

	public function checkCatB($app) {
		$return = false;

		if (!empty($app)) {
			$qualification = $this->HeqfQualification->findById($app['Application']['heqf_qualification_id']);
			if (!empty($qualification)) {
				$return = ($qualification['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B') ? true : false;
			}
		}

		return $return;
	}

	public function runValidationFunctions($data) {
		if (isset($this->data['HeqfQualification']['lkp_cesm1_code_id'])) {
			$data['HeqfQualification']['lkp_cesm1_code_id'] = $this->HeqfQualification->runValidationFunctions();
		}

		return $data;
	}

	public function applicationTotals($conditions) {
		$return = array();
		$qualCond = array();
		if (isset($conditions['Application.institution_id'])) {
			$qualCond['HeqfQualification.institution_id'] = $conditions['Application.institution_id'];
		}
		if (isset($conditions['HeqfQualification.lkp_delivery_mode_id'])) {
			$qualCond['HeqfQualification.lkp_delivery_mode_id'] = $conditions['HeqfQualification.lkp_delivery_mode_id'];
		}

		$sumFields = array(
			'Total' => array(),
			'appA' => array(
				'HeqfQualification.apx_A' => 1,
			),
			'appB' => array(
				'HeqfQualification.apx_B' => 1,
			),
			'appReview' => array(
				'HeqfQualification.apx_A' => 0,
				'HeqfQualification.apx_B' => 0,
				'Application.review_date' => '1970-01-01',
			),
			'appNot' => array(
				'HeqfQualification.apx_A' => 0,
				'HeqfQualification.apx_B' => 0,
				'review_date !=' => '1970-01-01',
			),
			'new' => array(
				'Application.application_status' => 'New',
			),
			'submitted' => array(
				'Application.submission_date >' => '1970-01-01',
			),
			'clTB' => array(
				'Application.application_status' => 'Submitted'
			),
			'clIn' => array(
				'Application.application_status' => 'Checklisting',
				'Application.checklisting_status_id' => 'New',
			),
			'clRet' => array(
				'Application.application_status' => 'Checklisting',
				'Application.checklisting_status_id' => 'Return',
			),
			'clCom' => array(
				'Application.checklisting_status_id' => 'Evaluate',
			),
			'evalTB' => array(
				'Application.application_status' => 'Checklisting',
				'Application.checklisting_status_id' => 'Evaluate',
			),
			'evalIn' => array(
				'Application.evaluation_status_id' => 'New',				
			),
			'eval' => array(
				'Application.evaluation_status_id' => 'Complete',
			),
			'revTB' => array(
				'Application.application_status' => 'Evaluation',
				'Application.evaluation_status_id' => 'Complete',
			),
			'revIn' => array(
				'Application.application_status' => 'Review',
				'Application.review_status_id' => 'New',
			),
			'revRet' => array(
				'Application.application_status' => 'Review',
				'Application.review_status_id' => 'Return',
			),
			'revCom' => array(
				'Application.application_status' => 'Review',
				'Application.review_status_id' => 'Reviewed',
			),
			'revInst' => array(
				'Application.application_status' => 'RenewEdited',
				'Application.user_id !=' => '',
			),
			'reSub' => array(
				'Application.review_status_id' => 'Returned',
				'Application.application_status' => 'RenewEdited',
				'Application.user_id' => '',
			),
			'accred' => array(
				'Application.lkp_outcome_id' => 'a',
			),
			'recat' => array(
				'Application.lkp_outcome_id' => 'r',
			),
			'notAccred' => array(
				'Application.lkp_outcome_id' => 'n',
			),
			'noOutcome' => array(
				'Application.lkp_outcome_id' => '',
			),
			'outAccepted' => array(
				'Application.outcome_accepted' => 1,
			),
			'notified' => array(
				'Application.notified' => 1,
			),
			'archived' => array(
				'Application.archived' => 1
			)
		);

		$this->virtualFields = array();
		$this->__buildVirtualSumFields($sumFields);

		$return['A'] = $this->generateReturnTotals('A', $qualCond);
		$return['B'] = $this->generateReturnTotals('B', $qualCond);
		$return['C'] = $this->generateReturnTotals('C', $qualCond);

		$this->virtualFields = array();

		return $return;
	}

	public function generateReturnTotals($category, $qualCond) {
		$return = array();
		$fields = array();

		$qualCond['HeqfQualification.s1_lkp_heqf_align_id'] = $category;
		$quals = $this->HeqfQualification->find('all', array(
			'fields' => array(
				'HeqfQualification.id'
			),
			'conditions' => $qualCond
		));
		$quals = Set::extract('/HeqfQualification/id', $quals);

		$conditions['Application.archived'] = array(0, 1);
		$conditions['Application.heqf_qualification_id'] = $quals;

		switch($category) {
			case 'A':
			case 'B':
			case 'C':
				$fields = array(
					'Application.id',
					'Application.Total',
					'Application.appA',
					'Application.appB',
					'Application.appReview',
					'Application.appNot',
					'Application.accred',
					'Application.recat',
					'Application.notAccred',
					'Application.noOutcome',
					'Application.outAccepted',
					'Application.notified',
					'Application.new',
					'Application.archived',
					'Application.submitted',
					'Application.clTB',
					'Application.clIn',
					'Application.clRet',
					'Application.clCom',
					'Application.evalTB',
					'Application.evalIn',
					'Application.eval',
					'Application.revTB',
					'Application.revIn',
					'Application.revRet',
					'Application.revCom',
					'Application.revInst',
					'Application.reSub',
				);
				break;
			/*case 'B':
			case 'C':
				$fields = array(
					'Application.id',
					'Application.Total',
					'Application.archived'
				);
				break;*/

		}

		$return = $this->find('all', array(
			'fields' => $fields,
			'conditions' => $conditions,
			'contain' => array(
				'HeqfQualification' => array(
					'fields' => array(
						'lkp_qualification_type_id'
					)
				)
			),
			'group' => 'HeqfQualification.lkp_qualification_type_id'
		));

		return $return;
	}

	public function multipleValuesExtract($data, $alias, $fields) {
		foreach ($fields as $field) {
			if (!empty($data[$alias]) && isset($data[$alias][$field])) {
				if (is_array($data[$alias][$field])) {
					$data[$alias][$field] = implode(',', $data[$alias][$field]);
				} else {
					$data[$alias][$field] = (!empty($data[$alias][$field])) ? explode(',', $data[$alias][$field]) : '';
				}
			}
		}

		return $data;
	}

	public function beforeFind(array $query) {
		if (!isset($query['conditions']['Application.inactive'])) {
			$query['conditions']['Application.inactive'] = false;
		}
		if (!isset($query['conditions']['Application.archived'])) {
			$query['conditions']['Application.archived'] = false;
		}
		return $query;
	}

	private function __buildVirtualSumFields($sumFields) {
		$dbo = $this->getDataSource();
		foreach ($sumFields as $fieldName => $fieldConditions) {
			if (!isset($fieldConditions['Application.inactive'])) {
				$fieldConditions['Application.inactive'] = 0;
			}
			if (!isset($fieldConditions['Application.archived'])) {
				$fieldConditions['Application.archived'] = 0;
			}
			$this->virtualFields[$fieldName] = 'SUM(IF(' . $dbo->conditions($fieldConditions, true, false) . ', 1, 0))';
		}
	}

/**
 * [_getCategoryCFields description]
 * @param  string $institutionType Institution type
 * @return array fields array
 */
	private function _getCategoryCFields($institutionType) {
		$fieldsArr = array(
			's1_qualification_reference_no',
			's1_qualification_title_short',
			's1_qualification_title',
			's1_saqa_qualification_id',
			's1_lkp_delivery_mode_id',
			's1_lkp_nqf_level_id',
			's1_minimum_years_full',
			's1_minimum_years_part',
			's1_credits_total',
			's1_minimum_admission_requirements',
			's1_lkp_heqf_align_id',
			's1_teachout_date');
		if ($institutionType == '2') {
			array_push($fieldsArr, 's1_lkp_hemis_qualifier_id', 's1_lkp_hemis_qualification_type_id', 's1_hemis_minimum_exp_time', 's1_hemis_total_subsidy_units', 's1_lkp_hemis_funding_level_id');
		}

		return $fieldsArr;
	}

	public function reminderReport($conditions) {
		return array(
			'contain' => array(
				'HeqfQualification',
				'User',
				'Evaluation' => array(
					'EvalUser'
				),
				'ReviewProceeding' => array(
					'ProcUser'
				),
				'Institution',
			),
			'conditions' => array(
				'Application.submission_date !=' => '1970-01-01',
				'Application.archived' => '0',
				array( 'OR' =>  array(
						'Application.evaluation_status_id' => 'New',
						'Application.review_status_id' => 'New',
						'Application.proceeding_status_id' => 'ReviewerNew'
					)
				)
			)
		);
	}

}
