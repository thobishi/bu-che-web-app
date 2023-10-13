<?php

App::import('Core', 'Sanitize');

class Process extends AppModel {

	public $hasMany = array(
		'Flow' => array(
			'order' => 'order ASC'
		)
	);

/**
 * Finds the selected process and returns it
 * 
 * @param array $params Parameters from URL
 * @throws Exception Throws an exception when the process or flow is not found
 * @return array
 */
	public function getProcess($params) {
		if (empty($params['process-slug']) && empty($params['named']['process-slug'])) {
			throw new Exception('No process');
		}

		$params['process-slug'] = (empty($params['process-slug'])) ? $params['named']['process-slug'] : $params['process-slug'];

		$this->contain(array('Flow'));
		$currentProcess = $this->findBySlug($params['process-slug']);

		if ($currentProcess == false) {
			throw new Exception('Invalid process');
		}

		$flows = Set::combine($currentProcess['Flow'], '{n}.slug', '{n}');

		if (empty($params['flow-slug'])) {
			$currentFlow['Flow'] = reset($flows);
		} elseif (isset($flows[$params['flow-slug']])) {
			$currentFlow['Flow'] = $flows[$params['flow-slug']];
		} else {
			throw new Exception('Invalid flow');
		}

		return compact('currentProcess', 'currentFlow');
	}

/**
 * Finds the selected flow
 * 
 * @param string $flowSlug
 * @return array
 */
	public function getFlow($flowSlug) {
		return $this->Flow->findBySlug($flowSlug);
	}

/**
 * Starts a new process
 * 
 * @param string $process
 * @return array
 */
	public function startProcess($process) {
		$processModel = $this->__getProcessModel($process);

		return $processModel->newProcess();
	}

/**
 * Fetches data for the selected process/flow
 * 
 * @param uuid $processId
 * @param array $process
 * @param array $flow
 * @param boolean $skipAccess
 * @return array 
 */
	public function getData($processId, $process, $flow, $skipAccess = false, $params = array()) {
		return $this->__getProcessModel($process)->find('process', array('skipAccess' => $skipAccess, 'params' => $params, 'conditions' => array('id' => $processId, 'flow' => $flow['Flow']['slug'])));
	}

/**
 * Runs any flow specific methods
 * 
 * @param array $flow
 * @param array $data
 * @return array 
 */
	public function runFlow($flow, $data) {
		$flowModel = $this->__getFlowModel($flow);

		$flowMethod = Inflector::variable(str_replace(array('-'), '_', $flow['Flow']['slug']));

		if (method_exists($flowModel, $flowMethod)) {
			return $flowModel->{$flowMethod}($data);
		}
	}

/**
 * Saves the data for the current process
 * 
 * @param array $process
 * @param array $flow
 * @param array $postdata
 * @param uuid $processId
 * @throws Exception Thrown when no process id is set
 * @return boolean 
 */
	public function saveProcess($process, $flow, $postdata, $processId) {
		if (!$processId) {
			throw new Exception('Invalid process id');
		}

		if (empty($postdata)) {
			return false;
		}
		return $this->__getProcessModel($process)->saveProcess($postdata, $processId, $process, $flow);
	}

/**
 * Checks if process saving may return false
 * @param  array $process
 * @return boolean
 */
	public function mayReturnFalse($process) {
		if (!isset($this->__getProcessModel($process)->mayReturnFalse)) {
			$return = false;
		}

		$return = in_array($process['Process']['slug'], $this->__getProcessModel($process)->mayReturnFalse);
		return $return;
	}

/**
 * Checks if a user is allowed to access an action
 * 
 * @param array $process
 * @param array $params
 * @return boolean
 * @throws Exception If no action is set
 */
	public function actionPermission($process, $params) {
		$processModel = $this->__getProcessModel($process);

		if (!isset($params['form']['action'])) {
			throw new Exception('No action set');
		}

		$action = $params['form']['action'];

		return $processModel->actionPermission($action);
	}

/**
 * Runs an action for a particular process
 * 
 * @param array $process
 * @param array $params
 * @throws Exception if the action call does not exist in the process model
 * @return mixed 
 */
	public function peformAction($process, $params) {
		$processModel = $this->__getProcessModel($process);

		if (!isset($params['form']['action'])) {
			throw new Exception('No action set');
		}

		$action = $params['form']['action'];
		$actionMethod = Inflector::variable($action);

		if (!method_exists($processModel, $actionMethod)) {
			$actionMethod = $action;
		}

		if (!method_exists($processModel, $actionMethod)) {
			throw new Exception('No such action exists for this process');
		}

		$result = $processModel->{$actionMethod}($process, $params);
		if (is_array($result)) {
			$actionListConditions = $processModel->actionListConditions($action, $params);

			$actionListConditions[$processModel->alias . '.' . $processModel->primaryKey] = Set::filter($params['data']['Process']['selected']);
			$actionList = $processModel->find('all', array(
				'conditions' => $actionListConditions,
				'recursive' => 0
			));
			$log = $processModel->getDataSource()->getLog(false, false);
// 		debug($log);
// debug($actionListConditions);
			// exit;

			$selected = Set::extract('/' . $processModel->alias . '/' . $processModel->primaryKey, $actionList);

			$result = array_merge($result, array(
				strtolower(Inflector::pluralize($process['Process']['main_model'])) => $actionList,
				'selected' => $selected
			));
		}

		return $result;
	}

/**
 * Returns any lookups required for a particular flow
 * 
 * @param array $flow
 * @return mixed
 */
	public function fetchLookups($flow) {
		$Model = $this->__getFlowModel($flow);

		return $Model->fetchLookups();
	}

/**
 * Returns the model that is used by a process
 * 
 * @param array $process
 * @return Model
 */
	private function __getProcessModel($process) {
		$processModelName = $process['Process']['main_model'];
		return ClassRegistry::init($processModelName);
	}

/**
 * Returns the model that is used by a flow
 * 
 * @param array $flow
 * @return Model
 */
	private function __getFlowModel($flow) {
		$flowModelName = $flow['Flow']['model'];
		return ClassRegistry::init($flowModelName);
	}

/**
 * Filters flow data before showing to the user
 * 
 * @param array $process
 * @param array $data 
 */
	public function filterFlows(&$process, $data) {
		$ProcessModel = $this->__getProcessModel($process['currentProcess']);

		if (method_exists($ProcessModel, 'filterFlows')) {
			$ProcessModel->filterFlows($process, $data);
		}
	}

}