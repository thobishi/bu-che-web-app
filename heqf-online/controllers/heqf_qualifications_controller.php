<?php
class HeqfQualificationsController extends AppController {

	public $helpers = array('Html', 'Javascript', 'Ajax', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->HeqfQualification->publicInstitution = (Auth::get('Institution.priv_publ') == 2) ? true : false;
	}

	protected function _setupAuth() {
		parent::_setupAuth();

		$this->Auth->mapController('application', 'process');
		$this->Auth->mapAction('import', 'create');
		$this->Auth->mapAction('result', 'create');
		$this->Auth->mapAction('saveData', 'create');
		$this->Auth->mapAction('download_report', 'create');
		$this->Auth->mapAction('download_template', 'create');
		$this->Auth->mapAction('make_correction', 'update');
		$this->Auth->mapAction('edit_due_date', 'update');
	}

	public function result() {
		session_write_close();
		if ($this->Session->check('uniqueId')) {
			$uniqueId = $this->Session->read('uniqueId');
			$this->set(readStatus($uniqueId));
		}
	}

	public function import() {
		$this->HeqfQualification->userDetails = Auth::get();

		//import and add to db
		if (!empty($this->data)) {
			session_write_close();
			set_time_limit(0);

			$uniqueId = $this->Session->read('uniqueId');
			$this->HeqfQualification->statusUpdateId = $uniqueId;
			writeStatus(array(
				'current_function' => 'Uploading spreadsheet',
				'percent' => 25,
				'error' => false
			), $uniqueId);

			$key = array_keys($this->params['form']);
			$key = end($key);
			$render = 'validate';
			$layout = ($key == 'saveNormal') ? 'default' : 'ajax';
			if ($this->HeqfQualification->isUploadedFile($this->params)) {
				writeStatus(array(
					'percent' => 50
				), $uniqueId);
				App::import('vendor', 'excel_wrapper');
				$data = new ExcelWrapper($this->data['HeqfQualification']['import_file']['tmp_name']);
				writeStatus(array(
					'percent' => 75
				), $uniqueId);

				$result = $this->HeqfQualification->columnNames($data, $this->data['HeqfQualification']['browser']);
				if ($result['error']) {
					writeStatus(array(
						'error' => $result['error'],
					), $uniqueId);
					if ($key == 'saveNormal') {
						$this->Session->setFlash(__($result['error'], true));
						return;
					}
				} else {
					$this->__validate($result['saveData'], $this->data['HeqfQualification']['browser']);
				}
			} else {
				writeStatus(array(
					'error' => 'Please make sure the correct file is selected.',
				), $uniqueId);
				if ($key == 'saveNormal') {
					$this->Session->setFlash(__("Please make sure the correct file is selected.", true));
					return;
				}
			}
			$this->layout = $layout;
			$this->render($render);
		} else {
			if ($this->Session->check('uniqueId')) {
				clearStatus($this->Session->read('uniqueId'));
			}
			$this->Session->delete('validation');
			$this->Session->write('uniqueId', uniqid('', true));
			writeStatus(array(
				'current_function' => 'Uploading spreadsheet',
				'percent' => 0,
				'error' => false
			), $this->Session->read('uniqueId'));
		}
	}

	public function download_template() {
		Configure::write('debug', 0);

		$file = ($this->HeqfQualification->publicInstitution) ? 'HEQSF_public_form.xlsx' : 'HEQSF_private_form.xlsx';

		$this->view = 'Media';
		$pathInfo = pathinfo(WWW_ROOT . 'files/templates/' . $file);
		$params = array(
			'id' => $file,
              'name' => 'HEQSF_alignment_application_spreadsheet',
			'download' => true,
			'extension' => strtolower($pathInfo['extension']),
			'mimeType' => $this->_mimeTypes,
			'path' => 'files/templates/'
		);

		$this->set($params);
	}

	private function __validate($saveData, $browser) {
		//remove empty rows
		foreach ($saveData as $skey => $sheets) {
			foreach ($sheets as $dkey => $data) {
				if (!array_filter($data)) {
					unset($saveData[$skey][$dkey]);
				}
			}
		}

		$uniqueId = $this->Session->read('uniqueId');
		$resultsArray = array();
		$finalData = array();
		$total_records = 0;
		$total_errors = 0;
		$sheetInfo = array();
		$this->loadModel('Rule');
		$compulsory = array_unique($this->Rule->getCompulsoryFields());

		/*
			Before validate, to get the correct percentage, need to get the total records here, then send to each of the models etc
			Make a global variable in alignments first, called records processed, then when in other model, this will be the new "record count" of the records processed
		*/
		$finalData = array();

		/*
			Get Section 2 qual numbers, save as global var, then when validate, on the cat, check the global var here. etc
		*/
		$this->HeqfQualification->sectionTwoVals($saveData);

		foreach ($saveData as $skey => $sheets) {
			writeStatus(array(
				'current_function' => 'Validating - ' . $skey,
				'percent' => 0
			), $uniqueId);
			$sheetInfo['totalRecords'][$skey] = 0;
			$sheetInfo['duplicateErrors'][$skey] = 0;
			$sheetInfo['totalErrors'][$skey] = 0;
			$sheetInfo['correctRecords'][$skey] = 0;
			$sheetInfo['totalCoreErrors'][$skey] = 0;
			$sheetInfo['nonExistErrors'][$skey] = 0;
			$sheetInfo['submittedErrors'][$skey] = 0;
			$sheetInfo['categoryErrors'][$skey] = 0;
			if (count($sheets)) {
				$resultsArray = $this->HeqfQualification->validateData($sheets, $skey, $compulsory, $browser);

				array_push($finalData, $resultsArray);
				$sheetInfo['totalRecords'][$skey] += $resultsArray['totalRecords'];
				$sheetInfo['totalErrors'][$skey] += $resultsArray['recordErrors'];
				$sheetInfo['correctRecords'][$skey] += $resultsArray['correctRecords'];
				$sheetInfo['totalCoreErrors'][$skey] += $resultsArray['totalCoreErrors'];
				$sheetInfo['nonExistErrors'][$skey] += $resultsArray['nonExistErrors'];
				$sheetInfo['duplicateErrors'][$skey] += $resultsArray['duplicateErrors'];
				$sheetInfo['submittedErrors'][$skey] += $resultsArray['submittedErrors'];
				$sheetInfo['categoryErrors'][$skey] += $resultsArray['categoryErrors'];
			}
		}

		/*
			Get the records that have been edited online
		*/

		writeStatus(array(
			'current_function' => 'Finalising import',
			'percent' => 0
		), $uniqueId);
		$online_edited = $this->HeqfQualification->onlineEdit();

		session_start();
		$this->Session->write('validation', compact('sheetInfo', 'browser', 'finalData', 'online_edited'));
		session_write_close();
	}

	public function saveData() {
		if (isset($this->params['form']['accept']) || (isset($this->data['HeqfQualification']['link']) && $this->data['HeqfQualification']['link'] == 'accept')) {
			$this->data = $this->HeqfQualification->setThisData($this->Session->read('validation.finalData'));
			$this->Session->delete('validation');

			if ($this->HeqfQualification->saveApplications($this->data, $this->Session->read('UserAuth.User.institution_id'))) {
				$this->Session->setFlash(__("The alignment information has been saved. Thank you.", true));
				$this->redirect(array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'application'));
			} else {
				$this->Session->setFlash(__("The alignment information could not be saved. Please try again.", true));
				$this->redirect(array('action' => 'import'));
			}
		} else {
			$this->Session->setFlash(__('The data has been discarded', true));
			$this->redirect(array('action' => 'import'));
		}
	}

	public function download_report() {
		set_time_limit(0);

		$sheetInfo = $this->Session->read('validation.sheetInfo');
		$finalData = $this->Session->read('validation.finalData');

		$this->set(compact('sheetInfo', 'finalData'));

		if ($this->RequestHandler->ext == 'pdf') {
			$this->set('filename', 'HEQF_validation_report_' . date('d F Y') . '_institution - ' . Inflector::slug(Auth::get('Institution.hei_name')));
		}
	}

	public function afterFilter() {
		if ($this->Session->check('uniqueId')) {
			$uniqueId = $this->Session->read('uniqueId');
			$currentStatus = readStatus($uniqueId);
			if (isset($currentStatus['current_function']) && $currentStatus['current_function'] == 'finished') {
				clearStatus($uniqueId);
			}
		}
	}
	
}
