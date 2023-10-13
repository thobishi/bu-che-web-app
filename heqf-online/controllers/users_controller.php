<?php

class UsersController extends AppController {

	public $uses = array('OctoUsers.User');

	public $helpers = array('OctoUsers.AuthLinks', 'OctoFilter.Filter', 'FilterData');

	public $components = array(
		'Search.Prg',
		'PaginationRecall' => array(
			'vars' => array('search')
		)
	);

	public $presetVars = array(
		array('field' => 'role', 'type' => 'checkbox'),
		array('field' => 'institution_id', 'type' => 'checkbox'),
		array('field' => 'search', 'type' => 'value'),
		array('field' => 'status', 'type' => 'value'),
	);

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->mapAction('toggle_state', 'delete');
		$this->Auth->mapAction('authenticate', 'delete');
		$this->Auth->mapAction('toggle_admin', 'update');
	}

	public function inst_admin_index() {
		$redirect = $this->PaginationRecall->recall();
		if ($redirect !== null) {
			$this->redirect($redirect);
		}
		$this->Prg->commonProcess();

		$this->paginate = array(
			'contain' => array(
				'Role', 'Institution'
			),
			'order' => array('email_address'),
			'conditions' => array('User.institution_id' => Auth::get('Institution.id'))
		);

		$conditions = (!empty($this->data['User'])) ? $this->User->parseCriteria($this->data['User']) : $this->User->parseCriteria($this->Session->read('search.data'));

		$this->set('users', $this->paginate($conditions));
	}

/**
 * Admin add for user.
 *
 * @access public
 */
	public function inst_admin_add() {
		$this->PaginationRecall->save();

		try {
			if (!empty($this->data)) {
				$this->data['User']['institution_id'] = Auth::get('User.institution_id');
				$this->data['User']['heqc_institution_id'] = Auth::get('User.heqc_institution_id');
				$defaultRole = $this->User->Role->findByDefault(1);
				$this->data['Role']['Role'] = array($defaultRole['Role']['id']);
				$this->data['User']['ignoreRole'] = 1;
			}
			$result = $this->User->add($this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The user has been created', true));
				$this->PaginationRecall->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
			$this->PaginationRecall->redirect(array('action' => 'index'));
		}
		$roles = $this->User->Role->find('list');

		$this->set(compact('roles'));
		$this->render('inst_admin_form');
	}

/**
 * Admin edit for user.
 *
 * @param string $id, user id
 * @access public
 */
	public function inst_admin_edit($id = null) {
		$this->PaginationRecall->save();

		try {
			$result = $this->User->edit($id, $this->data, array(), array('User.institution_id' => Auth::get('Institution.id')));
			if ($result === true) {
				$this->Session->setFlash(__('The user has been updated', true));
				$this->PaginationRecall->redirect(array('action' => 'index'));
			} else {
				$this->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->PaginationRecall->redirect(array('action' => 'index'));
		}

		$this->render('inst_admin_form');
	}

	public function inst_admin_toggle_state($id = null) {
		try {
			$result = $this->User->toggle_state($id, array('User.institution_id' => Auth::get('Institution.id')));
			if ($result === true) {
				$this->Session->setFlash(__('User state changed', true));
				$this->redirect($this->referer());
			} else {
				$this->redirect($this->referer());
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect($this->referer());
		}
	}

	public function che_admin_index() {
		$redirect = $this->PaginationRecall->recall();
		if ($redirect !== null) {
			$this->redirect($redirect);
		}

		$this->Prg->commonProcess();

		$this->paginate = array(
			'contain' => array(
				'Role', 'Institution'
			),
			'order' => array('User.email_address' => 'asc')
		);

		$conditions = (!empty($this->data['User'])) ? $this->User->parseCriteria($this->data['User']) : $this->User->parseCriteria($this->Session->read('search.data'));
		$this->set('users', $this->paginate($conditions));

		$institutions = $this->User->Institution->find('list');
		$roles = $this->User->Role->find('list');

		$this->set(compact('institutions', 'roles'));
	}

	public function che_admin_edit($id = null) {
		$this->PaginationRecall->save();

		try {
			$result = $this->User->edit($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The user has been updated', true));
				$this->PaginationRecall->redirect(array('action' => 'index'));
			} else {
				$this->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->PaginationRecall->redirect(array('action' => 'index'));
		}
		$institutions = $this->User->Institution->find('list');
		$roles = $this->User->Role->find('list');

		$this->set(compact('roles', 'institutions'));
		$this->render('che_admin_form');
	}

	public function che_admin_add() {
		$this->PaginationRecall->save();

		try {
			$result = $this->User->add($this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The user has been created', true));
				$this->PaginationRecall->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
			$this->PaginationRecall->redirect(array('action' => 'index'));
		}
		$institutions = $this->User->Institution->find('list');
		$roles = $this->User->Role->find('list');

		$this->set(compact('roles', 'institutions'));
		$this->render('che_admin_form');
	}

	public function che_admin_toggle_state($id = null) {
		try {
			$result = $this->User->toggle_state($id);
			if ($result === true) {
				$this->Session->setFlash(__('User state changed', true));
			} else {
				$this->Session->setFlash(__('User state could not be changed', true), 'default', array(), 'error');
			}
			$this->redirect($this->referer());
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
			$this->redirect($this->referer());
		}
	}

	public function che_admin_authenticate($id = null) {
		try {
			$result = $this->User->edit($id, array(
				'User' => array(
					'id' => $id,
					'email_authenticated' => 1
			)));
			if ($result === true) {
				$this->Session->setFlash(__('User authenticated', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('User could not be authenticated', true), 'default', array(), 'error');
				$this->redirect($this->referer());
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
			$this->redirect($this->referer());
		}
	}

	public function che_admin_toggle_admin($id = null) {
		try {
			$result = $this->User->toggle_admin($id, $this->params);
			if ($result === true) {
				$this->Session->setFlash(__('User set to institutional administrator', true));
				$this->redirect($this->referer());
			} elseif (is_array($result)) {
				$this->set($result);
				return;
			} elseif ($result === false) {
				$this->redirect($this->referer());
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
			$this->redirect($this->referer());
		}
	}
}