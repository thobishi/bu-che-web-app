<?php
class HeqfQualificationModule extends AppModel {

	public $belongsTo = array(
		'HeqfQualification',
		'InstitutionModule',
		'Lookups.ModuleAction'
	);

	private $__qualRefs = array();

	private $__moduleRefs = array();

	private $__moduleActions = array();

/**
 * [importSpreadsheet description]
 * @param  [type] $file [description]
 * @param array $namedParams Named parameters
 * @return [type]       [description]
 * @throws Exception If [this condition is met]
 */
	public function importSpreadsheet($file, $namedParams = array()) {
		if ($this->isValidFile($file)) {
			$this->__readRefs();
			$data = $this->__readData($file['tmp_name']);
			return $this->__validateImport($data, $namedParams);
		} else {
			throw new Exception('Invalid file type');
		}
	}

	public function saveImport($data, $namedParams) {
		$this->__readRefs();
		$saveData = array();

		$duplicateRows = $this->__checkForDuplicates($data);
		$this->__specialValidate($namedParams);

		foreach ($data as $rowNumber => $dataRow) {
			if (in_array($rowNumber, $duplicateRows)) {
				continue;
			}

			$this->create();
			$this->set($dataRow);
			if ($this->validates()) {
				$saveData[] = $this->__prepareRow($dataRow);
			}
		}

		$this->__clearModules($saveData);

		return $this->saveAll($saveData, array('validate' => false));
	}

	private function __clearModules($data) {
		$qualIds = array_unique(Set::extract($data, '/heqf_qualification_id'));
		$this->deleteAll(array(
			'HeqfQualificationModule.heqf_qualification_id' => $qualIds
		));
	}

	private function __readRefs() {
		$this->__readModuleRefs();
		$this->__readQualRefs();
		$this->__readModuleActions();
	}

	private function __readModuleActions() {
		$this->__moduleActions = array_flip($this->ModuleAction->getValues());
	}

	private function __readModuleRefs() {
		$this->__moduleRefs = $this->InstitutionModule->find('list', array(
			'fields' => array(
				'InstitutionModule.reference',
				'InstitutionModule.' . $this->InstitutionModule->primaryKey
			),
			'conditions' => array(
				'InstitutionModule.institution_id' => Auth::get('Institution.id')
			)
		));
	}

	private function __readQualRefs() {
		$qualifications = $this->HeqfQualification->Application->find('all', array(
			'fields' => array(
				'HeqfQualification.s1_qualification_reference_no',
				'HeqfQualification.' . $this->HeqfQualification->primaryKey,
				'HeqfQualification.s1_lkp_heqf_align_id',
				'Application.application_status'
			),
			'conditions' => array(
				'Application.institution_id' => Auth::get('Institution.id'),
				'Application.archived' => 0,
				'Application.inactive' => 0
			),
			'contain' => array(
				'HeqfQualification'
			)
		));

		$this->__qualRefs = Set::combine($qualifications, '{n}.HeqfQualification.s1_qualification_reference_no', '{n}');
	}

	private function __prepareRow($dataRow) {
		$dataRow['heqf_qualification_id'] = $this->__qualRefs[$dataRow['qualification_reference']]['HeqfQualification']['id'];
		$dataRow['institution_module_id'] = $this->__moduleRefs[$dataRow['module_reference']];
		$dataRow['module_action_id'] = $this->__moduleActions[$dataRow['module_action']];

		unset($dataRow['qualification_reference']);
		unset($dataRow['module_reference']);
		unset($dataRow['module_action']);

		return $dataRow;
	}

	private function __specialValidate($namedParams) {
		if (isset($namedParams['qual'])) {
			$qual = $this->HeqfQualification->find('first', array(
				'fields' => 'HeqfQualification.s1_qualification_reference_no',
				'conditions' => array(
					'HeqfQualification.id' => $namedParams['qual']
				)
			));
			$this->validate['qualification_reference']['specific'] = array(
				'rule' => array('equalTo', $qual['HeqfQualification']['s1_qualification_reference_no']),
				'message' => 'Only modules for the ' . $qual['HeqfQualification']['s1_qualification_reference_no'] . ' qualification will be saved.'
			);
		}
	}

	private function __validateImport($data, $namedParams) {
		$validation = array();

		$this->__specialValidate($namedParams);

		foreach ($data as $rowNumber => &$dataRow) {
			$this->create();
			$this->set($dataRow);
			if (!$this->validates()) {
				$validation[$rowNumber] = $this->validationErrors;
			}
		}

		$validation = $this->__checkForDuplicates($data, $validation);

		return compact('data', 'validation');
	}

	private function __checkForDuplicates($data, $validation = null) {
		$duplicateRows = array();
		$references = array();
		foreach ($data as $rowNumber => $dataRow) {
			if (!empty($validation[$rowNumber]['module_reference'])) {
				continue;
			}

			if (!isset($references[$dataRow['qualification_reference']]) || !is_array($references[$dataRow['qualification_reference']])) {
				$references[$dataRow['qualification_reference']] = array();
			}

			if (in_array($dataRow['module_reference'], $references[$dataRow['qualification_reference']])) {
				$duplicateRows[] = $rowNumber;
				if ($validation !== null) {
					$validation[$rowNumber]['module_reference'] = 'A qualification cannot have the same module more than once.';
				}
			} else {
				$references[$dataRow['qualification_reference']][] = $dataRow['module_reference'];
			}
		}

		return $validation ? $validation : $duplicateRows;
	}

	private function __readData($file) {
		App::import('vendor', 'excel_wrapper');
		$data = new ExcelWrapper($file);
		return $this->__parseColumns($data);
	}

	private function __checkSynonyms($column) {
		$synonyms = array(
			'qualification_reference' => array('qualification_reference'),
			'module_reference' => array('module_reference'),
			'year' => array('year_of_study'),
			'compulsory' => array('compulsory'),
			'elective' => array('elective'),
			'module_action' => array('action')
		);

		foreach ($synonyms as $key => $options) {
			if ($key == $column || in_array($column, $options)) {
				return $key;
			}
		}
	}

	private function __parseHeaderNames($data) {
		$errorData = array();

		$header = $data->readHead();
		foreach ($header as &$columnData) {
			if ($newSlug = $this->__checkSynonyms($columnData['slug'])) {
				$columnData['slug'] = $newSlug;
			} else {
				array_push($errorData, $columnData['name']);
			}
		}
		$data->setHead($header);

		if (!empty($errorData)) {
			$error = 'Unknown column(s) : ' . implode(', ', array_unique($errorData)) . ' in the excel file. Please make sure that you have downloaded the latest template with the required format and you are uploading the <strong>Modules for qualifications</strong> template.';
			throw new Exception($error);
		}

		return $header;
	}

	private function __parseColumns($data) {
		$return = array();
		$data->changeSheet(0);
		$headers = $this->__parseHeaderNames($data);

		while ($row = $data->readNextRow()) {
			if (!empty($row)) {
				$return[] = $row;
			}
		}

		return $return;
	}

	public function moduleExists($data) {
		return isset($this->__moduleRefs[$data['module_reference']]);
	}

	public function qualificationExists($data) {
		return isset($this->__qualRefs[$data['qualification_reference']]);
	}

	public function qualificationisNew($data) {
		return $this->__qualRefs[$data['qualification_reference']]['Application']['application_status'] == 'New';
	}

	public function qualificationisCatB($data) {
		return $this->__qualRefs[$data['qualification_reference']]['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B';
	}
}