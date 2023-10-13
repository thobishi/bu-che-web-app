<?php

class ProcessController extends AppController {

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->allow('*');
	}

	public $components = array(
		'Search.Prg'
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->__parseParams();
	}

	public function form() {
	
		try {
			$process = $this->Process->getProcess($this->params);
			extract($process);

			$permission = array(
				'controller' => 'process.' . $currentProcess['Process']['slug']
			);
			if (!$this->Session->read('process.id')) {
				$permission['crud'] = 'create';
				if ($this->Auth->userPermission($permission)) {
					$processId = $this->Process->startProcess($currentProcess);
					$this->Session->write('process.id', $processId);
				} else {
					$this->Auth->authException();
				}
			} else {
				$processId = $this->Session->read('process.id');
			}

			$permission['crud'] = 'read';
			if ($this->Auth->userPermission($permission)) {
				if (empty($this->data)) {
					$this->data = $this->Process->getData($processId, $currentProcess, $currentFlow);
	
					if ($this->Session->check('form-data')) {
						$this->data = Set::merge($this->data, $this->Session->read('form-data'));					
					}
					$this->Process->filterFlows($process, $this->data);
				} else {
					if (isset($this->params['to-flow'])) {
						$nextFlow = $this->Process->getFlow($this->params['to-flow']);
					}
					$result = $this->Process->saveProcess($currentProcess, $currentFlow, $this->data, $this->Session->read('process.id'));
					
					if ($result == true) {
						$redirect = array('process-slug' => $currentProcess['Process']['slug']);

						if (isset($nextFlow)) {
							$redirect['flow-slug'] = $nextFlow['Flow']['slug'];
						} else {
							$redirect['flow-slug'] = $currentFlow['Flow']['slug'];
						}

						$this->Session->delete('form-data');
						$this->redirect($redirect);
					} else {
						if ($this->Process->mayReturnFalse($currentProcess)) {
							$this->data = Set::merge($this->Process->getData($processId, $currentProcess, $currentFlow, false, array('process-slug' => $currentProcess['Process']['slug'])), $this->data);

						}
					}
				}

				$currentModel = $currentFlow['Flow']['model'];

				$this->Session->delete('form-data');
				$this->set($this->Process->runFlow($currentFlow, $this->data));
				$this->set($this->Process->fetchLookups($currentFlow));
				$this->set($process);
				$this->set('sidebar', true);
				$this->set('edit', true);
			} else {
				$this->Auth->authException();
			}
		} catch (Exception $e) {
			$this->Session->delete('form-data');
			$this->_triggerError($e);
		}
	}

	public function continue_process() {
		try {
			$process = $this->Process->getProcess($this->params);
			extract($process);

			$processId = $this->params['id'];
			if ($this->Process->getData($processId, $currentProcess, $currentFlow)) {
				$this->Session->write('process.id', $processId);

				$this->redirect(array(
					'action' => 'form',
					'process-slug' => $currentProcess['Process']['slug'],
					'flow-slug' => $currentFlow['Flow']['slug']
				));
			}
		} catch (Exception $e) {
			$this->_triggerError($e);
		}
	}

	public function close() {
		$process = $this->Process->getProcess($this->params);
		extract($process);

		$result = true;
		if (isset($this->params['form']['saveForm'])) {
			$result = $this->Process->saveProcess($currentProcess, $currentFlow, $this->data, $this->Session->read('process.id'));
		}

		if (isset($this->params['form']['redirectTo'])) {
			$redirect = '/' . $this->params['form']['redirectTo'];
		} elseif ($this->Session->check('process.redirect')) {
			$redirect = $this->Session->read('process.redirect');
			$this->Session->delete('process.redirect');
		} else {
			$redirect = array('action' => 'list_process', 'process-slug' => $currentProcess['Process']['slug']);
		}

		if ($result === true) {
			$this->Session->delete('process.id');
			$this->Session->delete('form-data');

			if (isset($this->params['form']['saveForm'])) {
				$this->Session->setFlash('All your changes have been saved');
			}

			$this->redirect($redirect);
		} else {
			$this->Session->write('form-data', $this->data);
			$this->redirect(array('process-slug' => $currentProcess['Process']['slug'], 'flow-slug' => $currentFlow['Flow']['slug'], 'action' => 'form'));
		}
	}

	public function list_process() {
		set_time_limit(0);
		try {
			if (isset($this->params['setAction'])) {
				$this->data = array();
			}

			$process = $this->Process->getProcess($this->params);
			extract($process);

			$permission = array(
				'controller' => 'process.' . $currentProcess['Process']['slug'],
				'crud' => 'read'
			);
			if ($this->Auth->userPermission($permission)) {
				$mainModel = $currentProcess['Process']['main_model'];
				$this->loadModel($mainModel);
				if (method_exists($this->{$mainModel}, 'listSearchParams')) {
					$this->presetVars = $this->{$mainModel}->listSearchParams($this->params);
				}
				if ($this->RequestHandler->isPost() && !isset($this->params['setAction'])) {
					if (isset($this->data['Process']['search'])) {
						$this->data[$mainModel] = $this->data['Process']['search'];
					}
				}
				$this->Prg->commonProcess($mainModel, array('allowedParams' => array('process-slug')));
				if (!empty($this->data[$mainModel])) {
					$this->data['Process']['search'] = $this->data[$mainModel];
				}

				$this->paginate = array($mainModel => array());
				$conditions = array();

				if (method_exists($this->{$mainModel}, 'standardConditions')) {
					$this->paginate[$mainModel]['conditions'] = $this->{$mainModel}->standardConditions('list', $this->params);
				}
				if (method_exists($this->{$mainModel}, 'viewVariables')) {
					$this->set($this->{$mainModel}->viewVariables('list', $this->params));
				}
				if (method_exists($this->{$mainModel}, 'standardJoins')) {
					$this->paginate[$mainModel]['joins'] = $this->{$mainModel}->standardJoins('list', $this->params);
				}
				if (method_exists($this->{$mainModel}, 'standardContains')) {
					$this->paginate[$mainModel]['contain'] = $this->{$mainModel}->standardContains('list', $this->params);
				}

				if (isset($this->parsedData[$mainModel])) {
					$conditions = $this->{$mainModel}->parseCriteria($this->parsedData[$mainModel]);
				}
				if (method_exists($this->{$mainModel}, 'paginateParams')) {
					$this->paginate[$mainModel] = $this->{$mainModel}->paginateParams('list', $this->paginate[$mainModel], $this->params);
				}

				if (empty($this->paginate[$mainModel]['order'])) {
					$this->paginate[$mainModel]['order'] = $this->{$mainModel}->order;
				}
				$this->set('list', $this->paginate($mainModel, $conditions));
				$this->set($this->Process->fetchLookups($currentFlow));

				$this->set($process);

				if ($this->RequestHandler->isAjax()) {
					if (isset($this->data['Process']['selected']) && !is_array($this->data['Process']['selected'])) {
						$this->data['Process']['selected'] = Set::reverse(json_decode($this->data['Process']['selected']));
					}

					$this->render('ajax_list_process');
					return;
				} else {
					$url = '/' . $this->params['url']['url'];
					$this->Session->write('process.redirect', $url);
				}
			} else {
				$this->Auth->authException();
			}
		} catch (Exception $e) {
			$this->_triggerError($e);
		}
	}

	public function view() {
		try {
			$process = $this->Process->getProcess($this->params);
			extract($process);

			$permission = array(
				'controller' => 'process.' . $currentProcess['Process']['slug'],
				'crud' => 'read'
			);

			if ($this->Auth->userPermission($permission)) {
				$processId = $this->params['id'];
				$processData = $this->Process->getData($processId, $currentProcess, $currentFlow, false, $this->params['named']);
				$this->set($process);
				$this->set($this->Process->fetchLookups($currentFlow));
				$this->set('processData', $processData);
				$this->set('sidebar', true);
			} else {
				$this->Auth->authException();
			}
		} catch (Exception $e) {
			$this->_triggerError($e);
		}
	}

	public function perform_action() {
		try {
			$process = $this->Process->getProcess($this->params);
			extract($process);

			if (isset($this->params['action-slug'])) {
				$this->params['form']['action'] = $this->params['action-slug'];
			}

			if (!empty($this->params['data']['Process']['selected']) && !is_array($this->params['data']['Process']['selected'])) {
				$this->params['data']['Process']['selected'] = Set::reverse(json_decode($this->params['data']['Process']['selected']));
			}

			if (isset($this->params['id'])) {
				$this->params['data']['Process']['selected'][0] = $this->params['id'];
			}

			$actionPermission = $this->Process->actionPermission($currentProcess, $this->params);

			$permission = array(
				'controller' => 'process.' . $currentProcess['Process']['slug'],
				'crud' => $actionPermission
			);

			if ($this->Auth->userPermission($permission)) {
				$actionResult = $this->Process->peformAction($currentProcess, $this->params);
				if ($actionResult === true) {
					$this->Session->setFlash('The action was successfully performed on the selected items.');
					if ($this->RequestHandler->isAjax()) {
						$this->params['setAction'] = true;
						$this->setAction('list_process');
					} else {
						$this->redirect(
								array_merge(
										$this->params['named'], array(
									'action' => 'list_process',
									'process-slug' => $currentProcess['Process']['slug']
										)
								)
						);
					}
				} elseif (is_array($actionResult)) {
					$mainModel = $currentProcess['Process']['main_model'];
					$this->loadModel($mainModel);

					if (method_exists($this->{$mainModel}, 'alterActionResults')) {
						$actionResult = $this->{$mainModel}->alterActionResults($actionResult, $this->params);
					}

					$this->set($process);
					$this->set($actionResult);
					return;
				} elseif ($actionResult === false) {
					$this->redirect($this->referer());
				}
			} else {
				$this->Auth->authException();
			}
		} catch (Exception $e) {
			$this->_triggerError($e);
		}
	}

	private function __parseParams() {
		$namedParams = array(
			'action-slug',
			'process-slug',
			'id'
		);
		foreach ($namedParams as $namedParam) {
			if (isset($this->params['named'][$namedParam]) && !isset($this->params[$namedParam])) {
				$this->params[$namedParam] = $this->params['named'][$namedParam];
				unset($this->params['named'][$namedParam]);
			}
		}
		Router::connectNamed(array_keys($this->params['named']));
	}

}
