<?php

class InstitutionModulesController extends AppController {

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->mapController('application', 'process');
		$this->Auth->mapAction('import', 'create');
		$this->Auth->mapAction('save', 'create');
		$this->Auth->mapAction('download_template', 'create');
		$this->Auth->mapAction('export', 'read');
	}

	public function export() {
		$modules = $this->InstitutionModule->find('all', array(
			'conditions' => array(
				'InstitutionModule.institution_id' => Auth::get('User.institution_id')
			),
			'order' => array(
				'InstitutionModule.reference' => 'asc'
			)
		));
		$this->set(compact('modules'));
	}

	public function import() {
		if (!empty($this->data)) {
			set_time_limit(0);
			try {
				$importResults = $this->InstitutionModule->importSpreadsheet($this->data['InstitutionModule']['file']);
				$this->set($importResults);
				$this->Session->write('ModuleImport', $importResults);
				$this->render('validation');
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
				return;
			}
		} else {
		}
	}

	public function save() {
		if (empty($this->params['form'])) {
			$this->cakeError('error500'); // 500 Error
		} elseif (isset($this->params['form']['discard'])) {
			$this->Session->delete('ModuleImport');
			$this->Session->setFlash('Your module import has been discarded');
			$this->redirect(array('action' => 'import'));
		} elseif (isset($this->params['form']['accept'])) {
			if ($this->InstitutionModule->saveImport($this->Session->read('ModuleImport.data'))) {
				$message = 'The module information was saved successfully.';
			} else {
				$message = 'No modules could be saved.';
			}
			$this->Session->setFlash($message);
			$this->redirect(array(
				'controller' => 'process',
				'action' => 'list_process',
				'process-slug' => 'module'
			));
		}
	}

	public function download_template() {
		Configure::write('debug', 0);

		$this->view = 'Media';
		$pathInfo = pathinfo(WWW_ROOT . 'files/templates/institution_modules.xlsx');
		$params = array(
			'id' => 'institution_modules.xlsx',
			'name' => 'All modules for institution',
			'download' => true,
			'extension' => strtolower($pathInfo['extension']),
			'mimeType' => $this->_mimeTypes,
			'path' => 'files/templates/'
		);

		$this->set($params);
	}
}