<?php

class HeqfQualificationModulesController extends AppController {

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->mapController('application', 'process');
		$this->Auth->mapAction('import', 'update');
		$this->Auth->mapAction('save', 'update');
		$this->Auth->mapAction('download_template', 'read');
		$this->Auth->mapAction('export', 'read');
	}

	public function export() {
		$conditions = array(
			'InstitutionModule.institution_id' => Auth::get('User.institution_id')
		);

		if (isset($this->params['named']['qual'])) {
			$conditions['HeqfQualification.id'] = $this->params['named']['qual'];
		}

			$qualModules = $this->HeqfQualificationModule->find('all', array(
			'conditions' => $conditions,
			'contain' => array(
				'InstitutionModule.reference',
				'HeqfQualification.s1_qualification_reference_no'
			),
			'order' => array(
				'HeqfQualification.s1_qualification_reference_no' => 'asc',
				'InstitutionModule.reference' => 'asc'
			)
		));
		$modules = $this->HeqfQualificationModule->InstitutionModule->find('all', array(
			'conditions' => array(
				'InstitutionModule.institution_id' => Auth::get('User.institution_id')
			),
			'order' => array(
				'InstitutionModule.reference' => 'asc'
			)
		));
		$moduleActions = $this->HeqfQualificationModule->ModuleAction->find('list');
		$this->set(compact('qualModules', 'moduleActions', 'modules'));
	}

	public function import() {
		if (!empty($this->data)) {
			set_time_limit(0);
			try {
				$importResults = $this->HeqfQualificationModule->importSpreadsheet($this->data['HeqfQualificationModule']['file'], $this->params['named']);
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
			if ($this->HeqfQualificationModule->saveImport($this->Session->read('ModuleImport.data'), $this->params['named'])) {
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
		$pathInfo = pathinfo(WWW_ROOT . 'files/templates/qualification_modules.xlsx');
		$params = array(
			'id' => 'qualification_modules.xlsx',
			'name' => 'Modules for qualifications',
			'download' => true,
			'extension' => strtolower($pathInfo['extension']),
			'mimeType' => $this->_mimeTypes,
			'path' => 'files/templates/'
		);

		$this->set($params);
	}
}