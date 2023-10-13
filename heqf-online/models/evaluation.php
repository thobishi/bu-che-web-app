<?php
class Evaluation extends AppModel {
	var $name = 'Evaluation';

	public $belongsTo = array(
		'Application',
		'EvalUser' => array(
			'className' => 'OctoUsers.User',
			'foreignKey' => 'eval_user_id',
			'fields' => 'EvalUser.first_name, EvalUser.last_name, EvalUser.email_address'
		)
	);


public $validate = array(
		'application_correctly_categorised' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to indicate Yes or No.'
			)
		),
		'qualification_type_aligned' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to indicate Yes or No.'
			)
		),
		'total_credits_aligned' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to indicate Yes or No.'
			)
		),
		'nqf_level_aligned' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to indicate Yes or No.'
			)
		),
		'programme_correctly_titled' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to indicate Yes or No.'
			)
		),
		'eval_lkp_heqf_align_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select the HEQSF alignment category.'
			)
		),
		'eval_lkp_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to enter your recommendation for this programme.'
			)
		),
		'eval_status_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please indicate when you have completed the evaluation.'
			)
		),

		's3_curriculum_lkp_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to select one option.'
			)
		),
		's3_modules_lkp_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to select one option.'
			)
		),
		's3_assessment_lkp_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to select one option.'
			)
		),
		's3_learning_activities_lkp_outcome_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'It is required to select one option.'
			)
		),
		's3_workplace_explained_lkp_outcome_id' => array(
			'rule' => 'validateS3_has_wil',
			'message' => 'It is required to select one option.',
		),
		'request_second_evaluation_comment' => array(
			'rule' => 'validateSecondEvaluationRequest',
			'message' => 'Please indicate why you request a second evaluation',
		),
		'eval_outcome_comment' => array(
			'rule' => 'validateEvaluationComment',
			'message' => 'It is required to enter an evaluation recommendation/Suggestion',
		),
	);
	
	public function validateEvaluationComment() {	
		$return = true;

		if (($this->data['Evaluation']['eval_lkp_outcome_id'] == 'nir' || $this->data['Evaluation']['eval_lkp_outcome_id'] == 'nr') && empty($this->data['Evaluation']['eval_outcome_comment'])) {
			$return = false;
		}
		return $return;
	}

	public function validateSecondEvaluationRequest() {	
		$return = true;
		if ($this->data['Evaluation']['eval_status_id'] == 'Request' && empty($this->data['Evaluation']['request_second_evaluation_comment'])) {
			$return = false;
		}
		return $return;
	}

	function validateS3_has_wil(){
		$valWillRequired = true;
		$heqf_qualificationArr = $this->Application->find('first', array('fields' =>array('Application.heqf_qualification_id'), 'conditions'=> array('Application.id' => $this->data['Evaluation']['application_id'])));
		if(!empty($heqf_qualificationArr)){
			$heqf_qualification_id = $heqf_qualificationArr['Application']['heqf_qualification_id'];
			if($this->Application->HeqfQualification->isWillRequired($heqf_qualification_id) && empty($this->data['Evaluation']['s3_workplace_explained_lkp_outcome_id'])){
				$valWillRequired = false;
			}
		}
        return $valWillRequired;		
	}	

/**
 * Finding the maximum order of an Evaluation for a particular application.
 * The value returned is used to indicate the order that evaluations for an application take place.
 * @param  string $application_id [description]
 * @return int          [maximum order for the application]
 */	
	public function lastEvaluation($application_id){
		$eval_order = 0;
		$this->virtualFields['max_order'] = 'MAX(Evaluation.eval_order)';
		$last = $this->find('all', array('conditions' => array('Evaluation.application_id' => $application_id/*, 'Evaluation.eval_inactive' => 1*/), 'fields' => array('max_order')));

		if($last[0]['Evaluation']['max_order'] != 'null'){

			$eval_order = $last[0]['Evaluation']['max_order'];
		}
		unset($this->virtualFields['max_order']);
		return intval($eval_order);
	}

	public function fetchLookups() {
		$lookups = array();

		foreach ($this->belongsTo as $alias => $config) {
			$varName = Inflector::tableize($alias);
			$lookups[$varName] = $this->{$alias}->find('list');
		}
		$lookups['QuestionOutcome'] = $this->Application->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc'), 'conditions' => array('Outcome.id' => array('a', 'ni', 'n'))));
		$lookups['FinalOutcome'] = $this->Application->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc'), 'conditions' => array('Outcome.id' => array('a', 'nir', 'nr'))));
		$lookups['EvaluationStatus'] = $this->Application->EvaluationStatus->find('list', array('fields' => array('EvaluationStatus.id', 'EvaluationStatus.description')));
		$lookups['NqfLevel'] = $this->Application->HeqfQualification->NqfLevel->find('list');
		$lookups['ModuleAction'] = $this->Application->HeqfQualification->HeqfQualificationModule->ModuleAction->find('list', array('fields' => array('ModuleAction.id', 'ModuleAction.action')));
		$lookups['DeliveryMode'] = $this->Application->HeqfQualification->DeliveryMode->find('list');
		$lookups['QualificationType'] = $this->Application->HeqfQualification->QualificationType->find('list');
		$lookups['ProfessionalClass'] = $this->Application->HeqfQualification->ProfessionalClass->find('list');
		$lookups['Cesm3Code'] = $this->Application->HeqfQualification->Cesm3Code->find('list');
		$lookups['Cesm1Code'] = $this->Application->HeqfQualification->Cesm1Code->find('list');
		$lookups['Cesm2Code'] = $this->Application->HeqfQualification->Cesm2Code->find('list');
		$lookups['Institution'] = $this->Application->Institution->find('list');
		$lookups['CesmCode'] = $this->Application->HeqfQualification->CesmCode->find('list');
		$lookups['HemisQualifier'] = $this->Application->HeqfQualification->HemisQualifier->find('list');
		$lookups['HemisHeqfQualificationType'] = $this->Application->HeqfQualification->HemisHeqfQualificationType->find('list');
		$lookups['S1HemisQualificationType'] = $this->Application->HeqfQualification->S1HemisQualificationType->find('list');
		$lookups['HemisFundingLevel'] = $this->Application->HeqfQualification->HemisFundingLevel->find('list');
		$lookups['HeqcMeeting'] = $this->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));		
		$lookups['Designator'] = $this->Application->HeqfQualification->Designator->find('list');
		$lookups['AppHeqfAlign'] = $this->Application->AppHeqfAlign->find('list', array('fields' => array('AppHeqfAlign.id', 'AppHeqfAlign.heqf_align_desc')));
		return $lookups;
	}
}