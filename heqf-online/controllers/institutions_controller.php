<?php
class InstitutionsController extends AppController {

	public $helpers = array('Html', 'Javascript', 'Ajax', 'Session');

	public $components = array(
		'Search.Prg'
	);

	public function beforeFilter() {
		parent::beforeFilter();
	}

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->mapController('outcome', 'process');
		$this->Auth->mapAction('listProceedingOutcomes', 'read');
		$this->Auth->mapAction('perform_action', 'update');
		$this->Auth->mapAction('view', 'read');
	}

	public function listProceedingOutcomes() {
		set_time_limit(0);
		$conditions = array();
		if ($this->RequestHandler->isPost() && !isset($this->params['setAction'])) {
			if (isset($this->data['Institution']['search'])) {
				if (isset($this->data['Institution']['search']['institution']) && !empty($this->data['Institution']['search']['institution'])) {
					$instId = $this->data['Institution']['search']['institution'];
					$conditions['Application.institution_id'] = "$instId";
				}
				if (isset($this->data['Institution']['search']['meeting_date']) && !empty($this->data['Institution']['search']['meeting_date'])) {
					$meeting_date = $this->data['Institution']['search']['meeting_date'];
					$conditions['HeqcMeeting.date'] = "$meeting_date";
				}
			}
		}
		
		$query = $this->Institution->getProceedingListOutcomes($conditions);
		$heqcMeetingList = $this->Institution->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
		$institutionList = $this->Institution->find('list');
		$this->set('list', $query);
		$this->set('institutionList', $institutionList);
		$this->set('heqcMeetingList', $heqcMeetingList);
	}

	public function perform_action() {	
		try {

			if (!empty($this->params['data']['Institution']['selected']) && !is_array($this->params['data']['Institution']['selected'])) {
				$this->params['data']['Institution']['selected'] = Set::reverse(json_decode($this->params['data']['Institution']['selected']));
			}

			$actionResult = $this->Institution->performAction($this->params);
			if ($actionResult === true) {
				$this->Session->setFlash('The action was successfully performed on the selected items.');
				if ($this->RequestHandler->isAjax()) {
					$this->params['setAction'] = true;
					$this->setAction('listProceedingOutcomes');
				} else {
					$this->redirect(
						array_merge($this->params['named'], array('action' => 'listProceedingOutcomes'))
					);
				}
			} elseif (is_array($actionResult)) {
				$this->set($actionResult);
				return;
			} elseif ($actionResult === false) {
				$this->redirect($this->referer());
			}

		} catch (Exception $e) {
			$this->_triggerError($e);
		}
	}

	public function view() {
		try {

			if (empty($this->params['named']) || 
				empty($this->params['named']['id']) || 
				empty($this->params['named']['date']) || 
				empty($this->params['named']['procType'])) {
				$this->Session->setFlash('Cannot find the Institution');
			}
			$this->loadModel('Proceeding');

			$date = $this->params['named']['date'];
			$procType = $this->params['named']['procType'];
			$instID = $this->params['named']['id'];
			$instData = $this->Institution->find('first', array(
				'fields' => array('hei_code', 'hei_name'),
				'conditions' => array('Institution.id' => $instID)
			));
			if(!$instData) {
				$this->Session->setFlash('Cannot find the Institution');
			}
			$outcomes = $this->Institution->Application->Outcome->find('list');
			$conditions = array(
				'ProcHeqcMeeting.date' => $date,
				'Proceeding.proceeding_type_id' => $procType,
				'Proceeding.proc_status_id' => 'ReviewerComplete',
				'Proceeding.proc_date !=' => '1970-01-01',
				'Application.institution_id' => $instID,
			);
			$processData = $this->Proceeding->getHeqcProceedings($conditions);
			$this->set('processData', $processData);
			$this->set('instData', $instData);
			$this->set('outcomes', $outcomes);
			$this->set('sidebar', false);
		} catch (Exception $e) {
			$this->_triggerError($e);
		}
	}
	
}
