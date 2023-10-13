<?php
class RulesController extends AppController {

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->allow('*');
	}

	public function admin_index() {
		$this->Rule->recursive = 0;
		$this->set('rules', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid rule', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('rule', $this->Rule->read(null, $id));
	}

	public function admin_add() {
		if (!empty($this->data)) {
			$this->Rule->create();
			if ($this->Rule->save($this->data)) {
				$this->Session->setFlash(__('The rule has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.', true));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid rule', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Rule->save($this->data)) {
				$this->Session->setFlash(__('The rule has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Rule->read(null, $id);
		}
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for rule', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Rule->delete($id)) {
			$this->Session->setFlash(__('Rule deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rule was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}