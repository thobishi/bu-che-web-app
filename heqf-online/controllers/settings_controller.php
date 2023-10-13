<?php

class SettingsController extends AppController {
		
	protected function _setupAuth() {
		parent::_setupAuth();
		
		$this->Auth->mapAction('index', 'read');
		$this->Auth->mapAction('edit', 'update');
	}
	
	public function index() {
		$settings = $this->Setting->getConfigurableSetting();
		$this->set(compact('settings'));
	}

	function edit() {
		$id = $this->params['id'];
		if(!$this->Setting->findById($id)) {
			throw new Exception('Invalid setting id');
		}

	    $this->Setting->id = $id;
	    if (empty($this->data)) {
	        $this->data = $this->Setting->read();
	    } else {
	        if ($this->Setting->save($this->data)) {
	            $this->Session->setFlash('Your Setting has been updated.');
	            $this->redirect(array('action' => 'index'));
	        }
	    }
	}
}