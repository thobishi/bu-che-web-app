<?php
class InstitutionModule extends AppModel {

	public $belongsTo = array(
		'Institution',
		'NqfLevel' => array(
			'className' => 'Lookups.NqfLevel'
		)
	);

	public $hasMany = array(
		'HeqfQualificationModule' => array(
			'dependant' => true
		)
	);

	public $hasAndBelongsToMany = array(
		'HeqfQualification' => array(
			'with' => 'HeqfQualificationModule'
		)
	);

	public $order = array('InstitutionModule.title');

	public function fetchLookups() {
		return array();
	}

	public function standardConditions() {
		$conditions = array();
		if (Auth::get('User.institution_id') !== 0) {
			$conditions['InstitutionModule.institution_id'] = Auth::get('User.institution_id');
		}

		return $conditions;
	}

/**
 * [importSpreadsheet description]
 * @param  [type] $file [description]
 * @return [type]       [description]
 * @throws Exception If [this condition is met]
 */
	public function importSpreadsheet($file) {
		if ($this->isValidFile($file)) {
			$data = $this->__readData($file['tmp_name']);
			return $this->__validateImport($data);
		} else {
			throw new Exception('Invalid file type');
		}
	}

	public function saveImport($data) {
		$instId = Auth::get('Institution.id');
		$saveData = array();

		$duplicateRows = $this->__checkForDuplicates($data);
		foreach ($data as $rowNumber => $dataRow) {
			if (in_array($rowNumber, $duplicateRows)) {
				continue;
			}

			$this->create();
			$this->set($dataRow);
			if ($this->validates()) {
				$saveData[] = $this->__prepareRow($dataRow, $instId);
			}
		}

		return $this->saveAll($saveData, array('validate' => false));
	}

	private function __prepareRow($dataRow, $instId) {
		$currentRow = $this->find('first', array(
			'fields' => $this->alias . '.' . $this->primaryKey,
			'conditions' => array(
				$this->alias . '.institution_id' => $instId,
				$this->alias . '.reference' => $dataRow['reference']
			)
		));
		$dataRow['institution_id'] = $instId;
		if (!empty($currentRow)) {
			$dataRow[$this->primaryKey] = $currentRow[$this->alias][$this->primaryKey];
		}

		return $dataRow;
	}

	private function __validateImport($data) {
		$validation = array();

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
			if (!empty($validation[$rowNumber]['reference'])) {
				continue;
			}

			if (in_array($dataRow['reference'], $references)) {
				$duplicateRows[] = $rowNumber;
				if ($validation !== null) {
					$validation[$rowNumber]['reference'] = 'Module references need to be unique.';
				}
			} else {
				$references[] = $dataRow['reference'];
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
			'reference' => array('module_code', 'module_reference', 'module_ref'),
			'title' => array('module_title'),
			'nqf_level_id' => array('nqf_level'),
			'credits' => array('credits')
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
			$error = 'Unknown column(s) : ' . implode(', ', array_unique($errorData)) . ' in the excel file. Please make sure that you have downloaded the latest template with the required format and you are uploading the <strong>All modules for institution</strong> template.';
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
}