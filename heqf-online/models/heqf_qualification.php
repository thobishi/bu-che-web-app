<?php

App::import('Helper', 'Heqf');
class HeqfQualification extends AppModel {

	public $totalRows = 0;

	public $currentRowCount = 0;

	public $sectionOneQualRefnos = array();

	public $sectionTwoQualRefnos = array();

	public $sectionTwoValidateData = array();

	public $replaceQualRefnos = array();

	private $__sectionTwoQualTypes = array();

	public $publicInstitution = true;

	private $__lookupValidationCache = array();

	private $__sectionTwoQuals = array();

	private $__submittedQuals = array();

	private $__multipleValidationCache = array();

	public $hasMany = array(
		'Application' => array(
			'foreignKey' => 'heqf_qualification_id',
			'dependant' => true
		),
		'HeqfQualificationSite' => array(
			'foreignKey' => 'heqf_qualification_id',
			'dependant' => true,
			'order' => 'site_id'
		),
		'S1QualificationSite' => array(
			'foreignKey' => 'heqf_qualification_id',
			'dependant' => true,
			'order' => 'site_id'
		),
		'HeqfQualificationModule' => array(
			'dependant' => true
		),
		'ProgrammeAssessmentApproach' => array(
			'foreignKey' => 'heqf_qualification_id',
			'dependant' => true,
			'order' => 'year'
		)	
	);

	public $belongsTo = array(
		'QualificationType' => array(
			'className' => 'Lookups.QualificationType',
			'foreignKey' => 'lkp_qualification_type_id',
		),
		'Designator' => array(
			'className' => 'Lookups.Designator',
			'foreignKey' => 'lkp_designator_id',
		),
		'Cesm1Code' => array(
			'className' => 'Lookups.Cesm1Code',
			'foreignKey' => 'lkp_cesm1_code_id',
		),
		'DeliveryMode' => array(
			'className' => 'Lookups.DeliveryMode',
			'foreignKey' => 'lkp_delivery_mode_id',
		),
		'ProfessionalClass' => array(
			'className' => 'Lookups.ProfessionalClass',
			'foreignKey' => 'lkp_professional_class_id',
		),
		'NqfLevel' => array(
			'className' => 'Lookups.NqfLevel',
			'foreignKey' => 'lkp_nqf_level_id',
		),
		'Cesm2Code' => array(
			'className' => 'Lookups.Cesm2Code',
			'foreignKey' => 'lkp_cesm2_code_id',
		),
		'Cesm3Code' => array(
			'className' => 'Lookups.Cesm3Code',
			'foreignKey' => 'lkp_cesm3_code_id',
		),
		'CesmCode' => array(
			'className' => 'Lookups.CesmCode',
			'foreignKey' => 'lkp_cesm3_code_id',
		),
		'HemisHeqfQualificationType' => array(
			'className' => 'Lookups.HemisHeqfQualificationType',
			'foreignKey' => 'lkp_hemis_heqf_qualification_type_id',
		),
		'HemisFundingLevel' => array(
			'className' => 'Lookups.HemisFundingLevel',
			'foreignKey' => 'lkp_hemis_funding_level_id',
		),
		'HemisQualifier' => array(
			'className' => 'Lookups.HemisQualifier',
			'foreignKey' => 'hemis_lkp_cesm3_code_id',
		),
		'S1DeliveryMode' => array(
			'className' => 'Lookups.DeliveryMode',
			'foreignKey' => 's1_lkp_delivery_mode_id',
		),
		'S1NqfLevel' => array(
			'className' => 'Lookups.NqfLevel',
			'foreignKey' => 's1_lkp_nqf_level_id',
		),
		'S1HeqfAlign' => array(
			'className' => 'Lookups.HeqfAlign',
			'foreignKey' => 's1_lkp_heqf_align_id',
		),
		'S1HemisQualifier' => array(
			'className' => 'Lookups.HemisQualifier',
			'foreignKey' => 's1_lkp_hemis_qualifier_id',
		),
		'S1HemisQualificationType' => array(
			'className' => 'Lookups.HemisQualificationType',
			'foreignKey' => 's1_lkp_hemis_qualification_type_id',
		),
		'S1HemisFundingLevel' => array(
			'className' => 'Lookups.HemisFundingLevel',
			'foreignKey' => 's1_lkp_hemis_funding_level_id',
		),
		'YesNoDecision' => array(
			'className' => 'Lookups.YesNoDecision',
			'foreignKey' => 'compulsory_id',
		)
	);

	public $actsAs = array(
		'Search.Searchable',
		'OctoLog.AuditLog' => array(
			'userModel' => 'OctoUsers.User'
		)
	);

	public $presetVars = array(
		'heqf_data_dump' => array(
			array('field' => 'lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'lkp_outcome_id', 'type' => 'value'),
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_qualification_type_id', 'type' => 'value'),
			array('field' => 's1_lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'letter_data_report' => array(
			array('field' => 'lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'lkp_outcome_id', 'type' => 'value'),
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_qualification_type_id', 'type' => 'value'),
			array('field' => 's1_lkp_heqf_align_id', 'type' => 'value'),
			array('field' => 'keyword', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value'),
		),
		'letter_verifications' => array(
			array('field' => 'institution_id', 'type' => 'value'),
			array('field' => 'lkp_delivery_mode_id', 'type' => 'value')
		),
	);

	public $filterArgs = array(
		array('name' => 'lkp_heqf_align_id', 'type' => 'query', 'method' => 'searchCheAlign'),
		array('name' => 'lkp_outcome_id', 'type' => 'query', 'method' => 'searchOutcome'),
		array('name' => 's1_lkp_heqf_align_id', 'type' => 'value'),
		array('name' => 'lkp_qualification_type_id', 'type' => 'value'),
		array('name' => 'institution_id', 'type' => 'value'),
		array('name' => 'keyword', 'type' => 'query', 'method' => 'searchKeyword'),
		array('name' => 'lkp_delivery_mode_id', 'type' => 'query', 'method' => 'searchModeOfDelivery'),
	);

	public function searchModeOfDelivery($data) {
		return array(
			'HeqfQualification.lkp_delivery_mode_id' => $data['lkp_delivery_mode_id']
		);
	}

	public function searchKeyword($data) {
		return array(
			'OR' => array(
				'HeqfQualification.let_qual_title LIKE' => '%' . $data['keyword'] . '%',
				'HeqfQualification.let_qual_title_abbr LIKE' => '%' . $data['keyword'] . '%',
			)
		);
	}

	public function searchCheAlign($data) {
		$applications = $this->Application->find('all', array(
			'conditions' => array(
				'Application.lkp_heqf_align_id' => $data['lkp_heqf_align_id']
			),
			'fields' => array(
				'Application.heqf_qualification_id'
			)
		));

		$qualIds = Set::extract('/Application/heqf_qualification_id', $applications);

		return array(
			'HeqfQualification.id' => $qualIds
		);
	}

	public function searchOutcome($data) {
		$applications = $this->Application->find('all', array(
			'conditions' => array(
				'Application.lkp_outcome_id' => $data['lkp_outcome_id']
			),
			'fields' => array(
				'Application.heqf_qualification_id'
			)
		));

		$qualIds = Set::extract('/Application/heqf_qualification_id', $applications);

		return array(
			'HeqfQualification.id' => $qualIds
		);
	}

	public function duplicateMotivation($value, $field) {
		$value = end($value);
		$return = true;

		if (empty($value)) {
			if ($this->data[$this->name][$field] == 'D') {
				$return = false;
			}
		}

		return $return;
	}

	public function multipleValuesHEMIS($value, $model) {
		$return = false;
		$return = $this->multipleValuesValidate($value, $model, array('4', '6'));
		return $return;
	}

	public function multipleValuesCESM($value, $model) {
		$return = false;
		$limit = array('3', '5');
		$return = $this->multipleValuesValidate($value, $model, $limit);
		return $return;
	}

	public function multipleValuesMFOS($value, $model) {
		$return = false;
		$limit = array('5', '7');
		$return = $this->multipleValuesValidate($value, $model, $limit);
		return $return;
	}

	public function multipleValuesValidate($value, $model, $limit) {
		$return = false;
		$field = end(array_keys($value));
		$value = end($value);
		if (isset($this->{$model})) {
			if (!empty($value)) {
				//Convert semicolon to comma.
				if (is_string($value) && strpos(';', $value) !== false) {
					$value = str_replace(';', ',', $value);
				}

				if (!is_array($value)) {
					$value = explode(',', $value);
				}

				$incorrectValues = array();

				foreach ($value as &$singleValue) {
					$singleValue = trim($singleValue);

					if (!empty($singleValue)) {
						$match = $this->_getLookupValue($singleValue, $model);

						if (!empty($match) && in_array(strlen((string)$match[$model][$this->{$model}->primaryKey]), $limit)) {
							$this->data[$this->alias][$field] = $match[$model][$this->{$model}->primaryKey];
							$singleValue = $match[$model][$this->{$model}->primaryKey];
						} else {
							$incorrectValues[] = $singleValue;
							$return = false;
						}
					}
				}

				if (empty($incorrectValues)) {
					$return = true;
				}

				$this->data[$this->alias][$field] = implode(',', $value);
			}
		}

		return $return;
	}

	public function replaceQualsList($value, $field) {
		$qualList = $value[$field];
		if (empty($qualList)) {
			return true;
		}
		if (!is_array($qualList)) {
			$qualList = explode(',', $qualList);
		}

		$return = true;
		$incorrectQuals = array();
		$compareSectionOneQualRefs = array_flip($this->sectionOneQualRefnos);
		if (empty($compareSectionOneQualRefs)) {
			$compareSectionOneQualRefs = array_flip($this->getQuals());
		}
		foreach ($qualList as $qual) {
			$qual = trim($qual);
			if (!isset($compareSectionOneQualRefs[$qual]) && !empty($qual)) {
				$return = false;
				$incorrectQuals[] = $qual;
			}
		}
		if (!empty($incorrectQuals) && !$return) {
			$this->validate[$field]['notrequired']['message'] .= ' Unknown Qual Ref Number(s):' . implode(', ', $incorrectQuals);
		}
		$this->data[$this->alias][$field] = implode(',', $qualList);

		return $return;
	}

	public function saqaQualIDCheck($value, $field) {
		$return = false;
		$value = end($value);
		if (!empty($this->data[$this->name][$field]) && ($this->data[$this->name][$field]) > 0) {
			$return = true;
		}
		if (!empty($value)) {
			$return = true;
		}

		return $return;
	}

	public function dependantValidation($value, $field) {
		if ($this->data[$this->name][$field] != 'C') {
			return true;
		} else {
			$value = array_values($value);
			$value = $value[0];

			if (empty($value) || $value == '1970-01-01') {
				return false;
			} else {
				return true;
			}
		}
	}

	public function designatorValidation($value, $model, $lookupField) {
		//use the field motivation_other_designator to test etc

		$requiredValues = array('6', '7', '9', '10', '11', '12'); //degrees

		$model = ClassRegistry::init($model);
		$lookUps = $model->getValues();

		$key = array_keys($value);
		$key = $key[0];
		$value = end($value);

		if (!empty($value)) {
			if (in_array($value, $lookUps) || isset($lookUps[$value])) {
				$this->data[$this->name][$key] = $value;
				return true;
			} else {
				$this->data[$this->name]['other_designator'] = (isset($this->data[$this->name]['other_designator']) && ($this->data[$this->name]['other_designator'] != '')) ? ($this->data[$this->name]['other_designator']) : $this->data[$this->name][$key];
				$this->data[$this->name][$key] = 'Oth';
				return true;
			}
		} else {
			if (in_array($this->data[$this->name][$lookupField], $requiredValues)) {
				if (empty($this->data[$this->name]['motivation_other_designator'])) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		}
	}

	public function explainDesignatorValidation($value, $field) {
		$value = array_values($value);
		$value = $value[0];
		//echo $value;
		//exit;

		if ($this->data[$this->name][$field] == 'Oth') {
			if (!empty($value)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	public function profValidation($value, $field) {
		//test if professional classification was selected, if so, this is needed

		$value = array_values($value);
		$value = $value[0];

		if (isset($this->data[$this->name][$field]) && $this->data[$this->name][$field] == 1) {
			if (empty($value)) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function qualCesmLookups($value, $model, $field) {
		if (!empty($this->data[$this->name][$field])) {
			if (isset($this->{$model})) {
				$displayField = $model . '.' . 'DOE_CESM_code';//$this->{$model}->displayField;
				$primaryKey = $model . '.' . $this->{$model}->primaryKey;

				$this->{$model}->virtualFields = array(
					'name' => 'concat(' . $primaryKey . ', " ", ' . $displayField . ')'
				);

				$value = end($value);

				$match = $this->{$model}->find('first', array(
					'conditions' => array(
						'or' => array(
							'name' => $value,
							$displayField => $value,
							$primaryKey => $value
						)
					)
				));

				if (!empty($match)) {
					return true;
				}

				return false;
			}
		} else {
			return true;
		}
	}

	public function qualCreditInteger($value, $field) {
		//test to see that the field is not empty, if not, then this needs to be an integer
		$value = array_values($value);
		$value = $value[0];

		if (!empty($this->data[$this->name][$field])) {
			if (is_numeric($value)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	private function __findById($model, $value) {
		if (isset($this->{$model})) {
			if (!isset($this->__lookupValidationCache[$model][$value])) {
				$match = $this->{$model}->findById($value);
				$this->__lookupValidationCache[$model][$value] = $match;
			} else {
				$match = $this->__lookupValidationCache[$model][$value];
			}

			return $match;
		}
	}

	public function valueRangeMatch($value, $model, $localField, $minField, $maxField) {
		$value = end($value);
		$fieldValue = $this->data[$this->name][$localField];

		$check = $this->__findById($model, $fieldValue);

		if ($check && ($check[$model][$minField] <= $value && $check[$model][$maxField] >= $value)) {
			return true;
		} else {
			return false;
		}
	}

	public function minValueMatch($value, $model, $localField, $foreignField, $compareField) {
		$value = end($value);
		$fieldValue = $this->data[$this->name][$localField];

		$check = $this->__findById($model, $fieldValue);

		if ($check && $check[$model][$foreignField] <= $value) {
			return true;
		} else {
			if (isset($this->data[$this->name][$compareField]) && $this->data[$this->name][$compareField] != 0) {
				return true;
			}
			return false;
		}
	}

	public function rangeMatch($value, $model, $localField, $foreignField) {
		$value = end($value);
		$fieldValue = $this->data[$this->name][$localField];

		$check = $this->__findById($model, $fieldValue);

		$minField = 'min_' . $foreignField;
		$maxField = 'max_' . $foreignField;

		//if ($check && ($check[$model][$minField] <= $value && $check[$model][$maxField] >= $value)) {
		if ($check && ($value >= $check[$model][$minField])) {
			return true;
		} else {
			return false;
		}
	}

	public function totalCreditsSum($value, $field) {
		$value = array_values($value);
		$value = $value[0];

		$totalEntered = $this->data[$this->name]['credits_nqf5'] + $this->data[$this->name]['credits_nqf6'] + $this->data[$this->name]['credits_nqf7'] + $this->data[$this->name]['credits_nqf8'] + $this->data[$this->name]['credits_nqf9'] + $this->data[$this->name]['credits_nqf10'];

		$return = false;

		if ($totalEntered == $value) {
			$return = true;
		}

		return $return;
	}

	public function warningRule($value, $field) {
		$institutionId = Auth::get('User.institution_id');
		$value = end($value);

		$module = ClassRegistry::init('Institution');
		if ($information = $module->getInformation($institutionId)) {
			if ($field == 'priv_publ') {
				$model = 'S1ProviderType';
				$displayField = $model . '.' . $this->{$model}->displayField;
				$primaryKey = $model . '.' . $this->{$model}->primaryKey;
				$match = $this->{$model}->find('first', array(
					'conditions' => array(
						'or' => array(
							'name' => $value,
							$displayField => $value,
							$primaryKey => $value
						)
					)
				));
				if (!empty($match)) {
					if (($information['Institution'][$field] == 1) && ($match[$model]['id'] == 4) || (($information['Institution'][$field] == 2) && ($match[$model]['id'] != 4))) {
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}

			} else {
				if ($information['Institution'][$field] != $value) {
					return false;
				} else {
					return true;
				}
			}

		} else {
			return false;
		}
	}

	public function sitesValidation($value) {
		$field = end(array_keys($value));
		$pos = strrpos($field, '_');
		$field = substr($field, 0, $pos);
		$value = end($value);
		$group = ($field == 's1_site') ? 's1_qualification_sites' : 'heqf_qualification_sites';

		if (!empty($value)) {
			for ($i = 1; $i <= 30; $i++) {
				$this->data[$this->name][$group][$i]['site_id'] = $i;
				$this->data[$this->name][$group][$i]['site_name'] = isset($this->data[$this->name][$field . '_' . $i]) ? $this->data[$this->name][$field . '_' . $i] : '';
				unset($this->data[$this->name][$field . '_' . $i]);
			}
			$this->data[$this->name][$group] = base64_encode(serialize($this->data[$this->name][$group]));
			return true;
		} else {
			return false;
		}
	}

	public function fundingLevelValidate($value, $field) {
		$fieldValue = end(array_keys($value));
		$value = end($value);
		if (!empty($value)) {
			$return = false;
			switch ($this->data[$this->name][$fieldValue]) {
				case '1' :
					$options = array('7', '5', '6', '4', '3', '1', '2');
					if (in_array($this->data[$this->name][$field], $options)) {
						$return = true;
					}
					break;
				case '2' : //8,9
					$options = array('8', '9');
					if (in_array($this->data[$this->name][$field], $options)) {
						$return = true;
					}
					break;
				case '3' : //10,11
					$options = array('10', '11');
					if (in_array($this->data[$this->name][$field], $options)) {
						$return = true;
					}
					break;
				case '4' : //12
					if ($this->data[$this->name][$field] == 12) {
						$return = true;
					}
					break;
				case '5' :
					$return = true;
					break;
				case '6' :
					$return = true;
					break;
				case '7' :
					$return = true;
					break;
			}
			return $return;
		} else {
			return true;
		}
	}

	public function qualTitleValidate($value, $field, $modelValue, $model) {
		$return = false;
		$fieldValue = end(array_keys($value));
		$value = end($value);

		$modelValue = $this->data[$this->name][$modelValue];
		$match = $this->_getLookupValue($modelValue, $model);

		$inFields = array('1', '2', '3', '4', '5', '8');
		$ofFields = array('6', '7', '9', '10', '11', '12');

		if (!empty($match)) {
			if (isset($match[$model]['id'])) {
				if (in_array($match[$model]['id'], $inFields)) {
					if (strlen(strstr($value, ' in ')) > 0) {
						$return = true;
					}
				}
				if (in_array($match[$model]['id'], $ofFields)) {
					if (strlen(strstr($value, ' of ')) > 0) {
						$return = true;
					}
				}
			}
		}

		return $return;
	}

	public function categoryValidation($value) {
		$key = end(array_keys($value));
		$qualNo = $this->data[$this->name]['s1_qualification_reference_no'];
		$return = false;
		if (isset($this->data[$this->name][$key]) && ($this->data[$this->name][$key] == 'A' || $this->data[$this->name][$key] == 'B')) {
			$importValues = (count($this->sectionTwoValidateData) > 0) ? array_flip($this->sectionTwoValidateData) : '';
			$dbValues = $this->getSectionTwoQuals();
			if ((!empty($importValues) && isset($importValues[$qualNo])) || (!empty($dbValues) && isset($dbValues[$qualNo]))) {
				$return = true;
			}
		} else {
			$return = true;
		}

		return $return;
	}

	public function emptyConditionRequired($value, $field) {
		$value = array_values($value);
		$value = $value[0];

		if ($this->data[$this->name][$field] != 0 && !empty($this->data[$this->name][$field])) {
			if (empty($value)) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function isUploadedFile($params) {
		$types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/octet-stream');
		
		//Special case for when the user does not have excel installed:
		$types[] = 'application/x-zip-compressed';
		if (isset($params['data']['HeqfQualification']['import_file']['tmp_name']) && is_uploaded_file($params['data']['HeqfQualification']['import_file']['tmp_name']) && ($params['data']['HeqfQualification']['import_file']['error'] == 0)) {
			if (in_array($params['data']['HeqfQualification']['import_file']['type'], $types )) {
				return true;
			}
		}
		return false;
	}

	public function columnNames($data, $browser) {
		$sectionSheets = array(0, 2);
		$return = array();
		$saveData = array();
		$errorData = array();
		$error = false;
		$percent = 0;

		foreach ($sectionSheets as $sectionSheet) {
			$sheetData = array();
			try {
				$data->changeSheet($sectionSheet);
			} catch (Exception $e) {
				// If the thrown exception is active sheet index and the current sheetIndex is 2 then try to load sheet 1.
				// This is due to the downloaded export only have 2 sheets, and the normal template having a help sheet between the required sections
				if ($sectionSheet == 2 && $e->getMessage() == 'Active sheet index is out of bounds.') {
					$data->changeSheet(1);
				} else {
					throw $e;
				}
			}
			$sectionTitle = $data->sheetTitle();
			writeStatus(array(
				'current_function' => 'Verifiying spreadsheet - ' . $sectionTitle,
				'percent' => 0
			), $this->statusUpdateId);

			$header = $data->readHead();

			$currentItem = 0;
			$numberItems = $data->getHighestRow() + count($header);

			foreach ($header as &$columnData) {
				$currentItem++;
				if ($newSlug = $this->checkSynonyms($columnData['slug'], $sectionSheet)) {
					$columnData['slug'] = $newSlug;
				} else {
					array_push($errorData, $columnData['name']);
					$error = 'Unknown column(s) : ' . implode(', ', array_unique($errorData)) . ' in the excel file. Please make sure that you have downloaded the latest template with the required format.';
				}
				$percent = floor(($currentItem / $numberItems) * 100);
				writeStatus(array(
					'percent' => $percent
				), $this->statusUpdateId);
			}
			$data->setHead($header);

			while ($row = $data->readNextRow()) {
				$currentItem++;
				if (isset($row['s1_teachout_date'])) {
					$row['s1_teachout_date'] = (!empty($row['s1_teachout_date'])) ? $this->timeConversion($row['s1_teachout_date']) : $row['s1_teachout_date'];
				}
				array_push($sheetData, $row);

				$percent = floor(($currentItem / $numberItems) * 100);
				writeStatus(array(
					'percent' => $percent
				), $this->statusUpdateId);
			}
			$saveData[$sectionTitle] = $sheetData;
		}
		$return['error'] = $error;
		$return['saveData'] = $saveData;

		return $return;
	}

	public function checkSynonyms($column, $sheet) {
		$synonyms = array(
			0 => array(
				's1_qualification_reference_no' => array('qual_ref_no', 'qualification_reference_no', 'qualification reference number'),
				's1_heqc_reference_no' => array('heqc_ref', 'heqc reference number', 'heqc reference no'),
				's1_qualification_title' => array('qual_title', 'qualification title'),
				's1_qualification_title_short' => array('qual_title_abbr', 'qualification title short', 'qualification title abbreviation'),
				's1_institution_qualification_title' => array('inst_qual_title', 'institution qualification title'),
				's1_saqa_qualification_id' => array('saqa_qual_id', 'saqa qualification id'),
				's1_lkp_delivery_mode_id' => array('mode_of_delivery', 'delivery mode'),
				's1_lkp_nqf_level_id' => array('nqf_level', 'nqf_exit_level'),
				's1_credits_total' => array('total_credits', 'credits total'),
				's1_credits_nqf5' => array('total_credits_nqf_5'),
				's1_credits_nqf6' => array('total_credits_nqf_6'),
				's1_credits_nqf7' => array('total_credits_nqf_7'),
				's1_credits_nqf8' => array('total_credits_nqf_8'),
				's1_credits_nqf9' => array('total_credits_nqf_9'),
				's1_credits_nqf10' => array('total_credits_nqf_10'),
				's1_minimum_admission_requirements' => array('min_admission_req', 'minimum admission requirements'),
				's1_minimum_years_full' => array('min_duration_full', 'minimum duration full', 'minimum years full'),
				's1_minimum_years_part' => array('min_duration_part', 'minimum duration part', 'minimum years part'),
			's1_lkp_heqf_align_id' => array('proposed_heqf_catg', 'proposed_heqsf_catg'),
				's1_teachout_date' => array('teach_out_date'),
				's1_lkp_hemis_qualification_type_id' => array('hemis_qual_type', 'hemis qualification type'),
				's1_hemis_minimum_exp_time' => array('hemis_min_exp_time'),
				's1_hemis_total_subsidy_units' => array('total_subsidy_units'),
				's1_lkp_hemis_funding_level_id' => array('funding_level'),
				's1_lkp_hemis_qualifier_id' => array('major_field_of_study'),
				's1_site_1' => array('site_of_delivery_1'),
				's1_site_2' => array('site_of_delivery_2'),
				's1_site_3' => array('site_of_delivery_3'),
				's1_site_4' => array('site_of_delivery_4'),
				's1_site_5' => array('site_of_delivery_5'),
				's1_site_6' => array('site_of_delivery_6'),
				's1_site_7' => array('site_of_delivery_7'),
				's1_site_8' => array('site_of_delivery_8'),
				's1_site_9' => array('site_of_delivery_9'),
				's1_site_10' => array('site_of_delivery_10'),
				's1_site_11' => array('site_of_delivery_11'),
				's1_site_12' => array('site_of_delivery_12'),
				's1_site_13' => array('site_of_delivery_13'),
				's1_site_14' => array('site_of_delivery_14'),
				's1_site_15' => array('site_of_delivery_15'),
				's1_site_16' => array('site_of_delivery_16'),
				's1_site_17' => array('site_of_delivery_17'),
				's1_site_18' => array('site_of_delivery_18'),
				's1_site_19' => array('site_of_delivery_19'),
				's1_site_20' => array('site_of_delivery_20'),
				's1_site_21' => array('site_of_delivery_21'),
				's1_site_22' => array('site_of_delivery_22'),
				's1_site_23' => array('site_of_delivery_23'),
				's1_site_24' => array('site_of_delivery_24'),
				's1_site_25' => array('site_of_delivery_25'),
				's1_site_26' => array('site_of_delivery_26'),
				's1_site_27' => array('site_of_delivery_27'),
				's1_site_28' => array('site_of_delivery_28'),
				's1_site_29' => array('site_of_delivery_29'),
				's1_site_30' => array('site_of_delivery_30')
			),
			2 => array(
				'qualification_reference_no' => array('qual_ref_no', 'qualification_reference_no', 'qualification reference number'),
				'heqc_reference_no' => array('heqc_ref', 'heqc reference number', 'heqc reference no'),
				'qualification_title' => array('qual_title', 'qualification title'),
				'qualification_title_short' => array('qual_title_abbr', 'qualification title short', 'qualification title abbreviation'),
				'institution_qualification_title' => array('inst_qual_title', 'institution qualification title'),
				'lkp_qualification_type_id' => array('qual_type', 'qualification type'),
				'lkp_designator_id' => array('qual_designator', 'qualification designator'),
				'motivation_other_designator' => array('motivation_other_designator'),
				'lkp_delivery_mode_id' => array('mode_of_delivery', 'delivery mode'),
				'lkp_professional_class_id' => array('prof_class', 'professional class'),
				'professional_body' => array('prof_body', 'professional body'),
				'lkp_nqf_level_id' => array('nqf_level', 'nqf_exit_level'),
				'credits_total' => array('total_credits', 'credits total'),
				'credits_nqf5' => array('total_credits_nqf_5'),
				'credits_nqf6' => array('total_credits_nqf_6'),
				'credits_nqf7' => array('total_credits_nqf_7'),
				'credits_nqf8' => array('total_credits_nqf_8'),
				'credits_nqf9' => array('total_credits_nqf_9'),
				'credits_nqf10' => array('total_credits_nqf_10'),
				'first_qualifier_credits' => array('fq_credits', 'first qualifier credits'),
				'first_qualifier_credits_final' => array('fq_final_year_credits', 'first qualifier final year credits'),
				'second_qualifier_credits' => array('sq_credits', 'second qualifier credits'),
				'second_qualifier_credits_final' => array('sq_final_year_credits', 'second qualifier final year credits'),
				'wil_el_credits' => array('wil_el_credits'),
				'research_credits' => array('research_credits'),
				'minimum_admission_requirements' => array('min_admission_req', 'minimum admission requirements'),
				'minimum_years_full' => array('min_duration_full', 'min years full', 'minumum years full', 'minimum duration full'),
				'minimum_years_part' => array('min_duration_part', 'min years part', 'minimum years part', 'minimum duration part'),
				'qualification_purpose' => array('qual_purpose', 'qualification purpose'),
				'exit_level_outcome' => array('exit_level_outcomes', 'exit_level_outcome', 'grad_attributes'),
				'articulation_progression' => array('articulation_progression'),
				'rpl' => array('rpl'),
				'international_comparability' => array('international_comparability'),
				'lkp_hemis_heqf_qualification_type_id' => array('hemis_amended_qual_type', 'hemis amended qualification type'),
				'hemis_minimum_exp_time' => array('hemis_min_exp_time'),
				'hemis_total_subsidy_units' => array('total_subsidy_units'),
				'lkp_hemis_funding_level_id' => array('funding_level'),
				'lkp_cesm1_code_id' => array('cesm'),
				'lkp_cesm2_code_id' => array('fq_cesm', 'first qualifier cesm'),
				'lkp_cesm3_code_id' => array('sq_cesm', 'second qualifier cesm'),
				'hemis_lkp_cesm3_code_id' => array('major_field_of_study'),
				'first_qualifier' => array('first_qualifier_fq'),
				'second_qualifier' => array('second_qualifier_sq'),
				'saqa_qualification_id' => array('saqa_qual_id', 'saqa qualification id'),
				'qualification_rationale' => array('qual rationale', 'qual_rationale'),
				'struct_elect' => array('struct/_elect', 'struct/ elect'),
				'int_assess' => array('int assess', 'int_assess'),
				'moderation' => array('moderation'),
				'replace_qual' => array('replace_qual', 'replace qual'),
				'site_1' => array('site_of_delivery_1'),
				'site_2' => array('site_of_delivery_2'),
				'site_3' => array('site_of_delivery_3'),
				'site_4' => array('site_of_delivery_4'),
				'site_5' => array('site_of_delivery_5'),
				'site_6' => array('site_of_delivery_6'),
				'site_7' => array('site_of_delivery_7'),
				'site_8' => array('site_of_delivery_8'),
				'site_9' => array('site_of_delivery_9'),
				'site_10' => array('site_of_delivery_10'),
				'site_11' => array('site_of_delivery_11'),
				'site_12' => array('site_of_delivery_12'),
				'site_13' => array('site_of_delivery_13'),
				'site_14' => array('site_of_delivery_14'),
				'site_15' => array('site_of_delivery_15'),
				'site_16' => array('site_of_delivery_16'),
				'site_17' => array('site_of_delivery_17'),
				'site_18' => array('site_of_delivery_18'),
				'site_19' => array('site_of_delivery_19'),
				'site_20' => array('site_of_delivery_20'),
				'site_21' => array('site_of_delivery_21'),
				'site_22' => array('site_of_delivery_22'),
				'site_23' => array('site_of_delivery_23'),
				'site_24' => array('site_of_delivery_24'),
				'site_25' => array('site_of_delivery_25'),
				'site_26' => array('site_of_delivery_26'),
				'site_27' => array('site_of_delivery_27'),
				'site_28' => array('site_of_delivery_28'),
				'site_29' => array('site_of_delivery_29'),
				'site_30' => array('site_of_delivery_30')
			)
		);

		foreach ($synonyms[$sheet] as $key => $options) {
			if ($key == $column) {
				return $key;
			}
			if (in_array($column, $options)) {
				return $key;
			}
		}

		return false;
	}

	public function validateData($saveData, $sheet, $compulsory, $browser) {
		$resultsArray = array();
		$recordErrors = 0;
		$totalRecords = 0;
		$totalCoreErrors = 0;
		$correctRecords = 0;
		$nonExistErrorCount = 0;
		$duplicateErrorCount = 0;
		$submittedErrorCount = 0;
		$categoryErrorCount = 0;
		$validationData = array();
		$currentItem = 0;
		$totalRows = count($saveData);
		$this->__sectionTwoQuals = $this->getSectionTwoQuals();
		$this->__submittedQuals = $this->__getSubmittedQuals();

		foreach ($saveData as $key => $data) {
			//----------------------------
			$this->data[$this->name] = array();

			$this->set($data);
			$nonExistError = false;
			$duplicateError = false;
			$coreError = false;
			$submittedError = false;
			$categoryError = false;
			$totalRecords++;
			$currentItem++;

			//----------No corresponding qual ref no in section 2----------
			if ($sheet == 'S1 Existing qualification info' && !empty($data['s1_qualification_reference_no'])) {
				array_push($this->sectionOneQualRefnos, $data['s1_qualification_reference_no']);

				//----------Check for duplicates in sheets----------
				if ($this->arrayCountOccurrence($this->sectionOneQualRefnos, $data['s1_qualification_reference_no']) > 1) {
					$duplicateError = true;
					$this->data[$this->name]['duplicateErrorField']['s1_qualification_reference_no'] = 'Duplicate qualification number. This record will be discarded.';
				}
				//----------------------------

				//----------Check if corresponding qual number has been submitted----------
				if (!empty($data['s1_qualification_reference_no']) && $this->checkSubmittedQuals($data['s1_qualification_reference_no'])) {
					$submittedError = true;
					$this->data[$this->name]['submittedErrorField']['s1_qualification_reference_no'] = 'This qualification has been submitted. This record will be discarded.';
				}
				//----------------------------

				//----------(CORE) Check valid category----------
				if ($this->__coreCatExclude($this->data[$this->name]['s1_lkp_heqf_align_id'])) {
					$categoryError = true;
					$this->data[$this->name]['categoryErrorField']['s1_lkp_heqf_align_id'] = $this->data[$this->name]['s1_lkp_heqf_align_id'] . ' selected as proposed HEQSF category. Only A, B and C are valid categories.';
				}
				//----------------------------

				//----------(CORE) Check category A / B----------
				if ($this->__coreCatValidation($this->data[$this->name]['s1_lkp_heqf_align_id'], $data['s1_qualification_reference_no'])) {
					$categoryError = true;
					$this->data[$this->name]['categoryErrorField']['s1_lkp_heqf_align_id'] = $this->data[$this->name]['s1_lkp_heqf_align_id'] . ' selected, but corresponding qualification has not been found in section 2. This record will be discarded.';
				}

				//----------(CORE) Exclude Cat A----------
				if ($this->__coreCatExclude($this->data[$this->name]['s1_lkp_heqf_align_id'])) {
					$categoryError = true;
					$this->data[$this->name]['categoryErrorField']['s1_lkp_heqf_align_id'] = $this->data[$this->name]['s1_lkp_heqf_align_id'] . ' selected. Please note that category A applications will no longer be processed. This record will be discarded.';
				}
				

				//----------------------------
			} elseif (isset($data['qualification_reference_no'])) {
				array_push($this->sectionTwoQualRefnos, $data['qualification_reference_no']);
				//----------Check for duplicates in sheets----------
				if ($this->arrayCountOccurrence($this->sectionTwoQualRefnos, $data['qualification_reference_no']) > 1) {
					$duplicateError = true;
					$this->data[$this->name]['duplicateErrorField']['qualification_reference_no'] = 'Duplicate qualification number. This record will be discarded.';
				}
				//----------------------------

				//----------Non existant qual ref no in section 1, using section 2----------
				if (!(in_array($data['qualification_reference_no'], $this->sectionOneQualRefnos)) && !empty($data['qualification_reference_no'])) {
					$nonExistError = true;
					$this->data[$this->name]['nonExistantErrorField']['qualification_reference_no'] = 'Corresponding qualification number not found in Section 1. This record will be discarded';
					//$validationData[$sheet][$totalRecords]['nonExistantError']['nonExistantErrorField']['qualification_reference_no'] = 'Corresponding qualification number not found in Section 1';
				}
				//----------------------------

				//----------Check if corresponding qual number has been submitted----------
				if (!empty($data['qualification_reference_no']) && $this->checkSubmittedQuals($data['qualification_reference_no'])) {
					$submittedError = true;
					$this->data[$this->name]['submittedErrorField']['qualification_reference_no'] = 'This qualification has been submitted. This record will be discarded.';
				}
				//----------------------------
			}
			//----------------------------

			//----------Progress----------
			$percent = floor(($currentItem / $totalRows) * 100);
			writeStatus(array(
				'percent' => $percent
			), $this->statusUpdateId);
			//----------------------------

			//----------Validate----------
			if ($categoryError) {
				$categoryErrorCount++;
				$validationData[$sheet][$totalRecords]['categoryError'] = $this->data[$this->name];
				continue;
			}
			if ($submittedError) {
				$submittedErrorCount++;
				$validationData[$sheet][$totalRecords]['submittedError'] = $this->data[$this->name];
				continue;
			}
			if ($duplicateError) {
				$duplicateErrorCount++;
				$validationData[$sheet][$totalRecords]['duplicateError'] = $this->data[$this->name];
				continue;
			}

			if ($nonExistError) {
				$nonExistErrorCount++;
				$validationData[$sheet][$totalRecords]['nonExistantError'] = $this->data[$this->name];
			} else {
				foreach ($data as $field => $value) {
					//first check core fields
					$coreErrorFieldCount = 0;
					if (in_array($field, $compulsory) && $value == '') {
						$coreError = true;
						$this->data[$this->name]['coreErrorFields'][$coreErrorFieldCount] = $field;
						//$validationData[$sheet][$totalRecords]['coreError']['coreErrorFields'][$coreErrorFieldCount] = $field;
						$coreErrorFieldCount++;
					}
				}
				if ($coreError) {
					$totalCoreErrors++;
					$validationData[$sheet][$totalRecords]['coreError'] = $this->data[$this->name];
				}
				if (!$this->validates() && !$coreError) {
					$recordErrors++;
					foreach ($this->validationErrors as $fieldName => $error) {
						$this->data[$this->name]['recordErrorFields'][$fieldName] = $error;
						//$validationData[$sheet][$totalRecords]['recordError']['recordErrorFields'][$field_name] = $error;
					}
					$errorField = ($sheet == 'S1 Existing qualification info') ? 's1_error' : 's2_error';
					$this->data[$this->name][$errorField] = true;
					$validationData[$sheet][$totalRecords]['recordError'] = $this->data[$this->name];
				} elseif (!$coreError) {
					$correctRecords++;
					$errorField = ($sheet == 'S1 Existing qualification info') ? 's1_error' : 's2_error';
					$this->data[$this->name][$errorField] = false;
					$validationData[$sheet][$totalRecords]['correctRecord'] = $this->data[$this->name];
				}
			}
		}

		/*
			Want to display on the validate page a list of errors if a qual ref no is entered in section 1 and is cat A or B, but is not entered in section 2
			Also want to display the records that will be discarded coz in section 2 and nothing in section 1 etc
		*/

		//remove sheets validation criteria
		$this->validationErrors = array();
		//remove data
		$this->data = array();
		foreach ($saveData as $key => $data) {
			foreach ($data as $field => $value) {
				unset($this->validate[$field]);
			}
		}

		$resultsArray['validationData'] = $validationData;
		$resultsArray['categoryErrors'] = $categoryErrorCount;
		$resultsArray['recordErrors'] = $recordErrors;
		$resultsArray['duplicateErrors'] = $duplicateErrorCount;
		$resultsArray['totalRecords'] = $totalRecords;
		$resultsArray['correctRecords'] = $correctRecords;
		$resultsArray['totalCoreErrors'] = $totalCoreErrors;
		$resultsArray['nonExistErrors'] = $nonExistErrorCount;
		$resultsArray['submittedErrors'] = $submittedErrorCount;

		//remove data
		$validationData = array();

		return $resultsArray;
	}

	public function getQuals() {
		$quals = $this->find('all', array(
							'fields' => array('HeqfQualification.s1_qualification_reference_no'),
							'conditions' => array('HeqfQualification.institution_id' => Auth::get('User.institution_id'))
		));

		$return = array();

		if (!empty($quals)) {
			foreach ($quals as $qual) {
				$return[] = $qual[$this->name]['s1_qualification_reference_no'];
			}
		}

		return $return;
	}

	private function __getSubmittedQuals() {
		if (empty($this->userDetails['User']['institution_id'])) {
			$this->userDetails = Auth::get();
		}
		return $this->Application->find('list', array(
			'fields' => array(
				'HeqfQualification.s1_qualification_reference_no',
				'Application.application_status'
			),
			'conditions' => array(
				'Application.institution_id' => $this->userDetails['User']['institution_id'],
				'Application.application_status !=' => 'New',
				'Application.archived' => 0,
				'Application.inactive' => 0
			),
			'recursive' => false,
			'contain' => array(
				'HeqfQualification'
			)
		));
	}

	public function checkSubmittedQuals($qualRefNo) {
		if (empty($this->__submittedQuals)) {
			$this->__submittedQuals = $this->__getSubmittedQuals();
		}
		if (isset($this->__submittedQuals[$qualRefNo]) && $this->__submittedQuals[$qualRefNo] != 'New') {
			return true;
		}
	}

	public function arrayCountOccurrence($array, $value) {
		$results = array_count_values($array);
		foreach ($results as $key => $result) {
			if ($key == $value) {
				return $results[$value];
			}
		}
	}

	public function getTotalRows($data, $sectionSheets) {
			$totalRows = 0;
			$sheets = $data->numSheets();

			foreach ($sectionSheets as $sectionSheet) {
				$data->changeSheet($sectionSheet);
				$totalRows += $data->getHighestRow();
				$totalRows += count($data->readHead());
			}

			return $totalRows;
	}

	private function __roundMultiple($number, $multiple) {
		return round($number / $multiple) * $multiple;
	}

	public function fetchLookups() {
		$lookups = array();

		foreach ($this->belongsTo as $alias => $config) {
			$varName = Inflector::tableize($alias);
			$lookups[$varName] = $this->{$alias}->find('list');
		}

		$lookups['User'] = $this->Application->User->find('list', array('fields' => array('User.name')));
		$lookups['Institution'] = $this->Application->Institution->find('list');
		$lookups['ProceedingType'] = $this->Application->ProceedingType->find('list');
		$lookups['HeqcMeeting'] = $this->Application->HeqcMeeting->find('list', array('fields' => array('HeqcMeeting.id', 'HeqcMeeting.date')));
		$lookups['Outcome'] = $this->Application->Outcome->find('list', array('conditions' => array('Outcome.id' => array('a', 'r', 'n'))));
		$lookups['AllOutcome'] = $this->Application->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc')));
		$lookups['ReviewOutcome'] = $this->Application->Outcome->find('list', array('fields' => array('Outcome.id', 'Outcome.outcome_desc'), 'conditions' => array('Outcome.id' => array('ni', 'nr', 'a'))));
		$lookups['QualificationType'] = $this->QualificationType->find('list');
		$lookups['DeliveryMode'] = $this->DeliveryMode->find('list');
		$lookups['QualificationTypeNQFs'] = $this->QualificationType->find('list', array('fields' => 'QualificationType.nqf_exit_level'));
		$lookups['AppHeqfAlign'] = $this->Application->AppHeqfAlign->find('list', array('fields' => array('AppHeqfAlign.id', 'AppHeqfAlign.heqf_align_desc')));
		$lookups['ModuleActions'] = $this->HeqfQualificationModule->ModuleAction->find('list');
		$lookups['numberInstModules'] = $this->HeqfQualificationModule->InstitutionModule->find('count', array(
			'conditions' => array(
				'InstitutionModule.institution_id' => Auth::get('User.institution_id')
			)
		));

		$this->virtualFields = array(
			'name' => 'CONCAT(HeqfQualification.s1_qualification_title, " (", HeqfQualification.s1_qualification_reference_no, ")")'
		);
		$lookups['InstitutionQualification'] = $this->find('list', array(
			'fields' => array(
				'HeqfQualification.s1_qualification_reference_no',
				'name'
			),
			'conditions' => array(
				'HeqfQualification.institution_id' => Auth::get('User.institution_id')
			)
		));

		return $lookups;
	}

	public function section1($data) {
		return array(
			'disableFields' => $data['HeqfQualification']['disable_section1']
		);
	}

	public function section1B($data) {
		return $this->section1($data);
	}

	public function validate($data) {
		$this->set($data);
		$this->validates();

		return;
	}

	public function validateCatB($data) {
		return $this->validate($data);
	}

	public function saveApplications($data, $instID) {
		$sheetOne = (!empty($data['HeqfQualification'][0])) ? $data['HeqfQualification'][0] : '';
		$sheetTwo = (!empty($data['HeqfQualification'][1])) ? $data['HeqfQualification'][1] : '';
		$finalData = array();

		if (isset($sheetOne) && !empty($sheetOne)) {
			foreach ($sheetOne as $record => $oneValues) {
				$finalData['HeqfQualification'][$record] = $oneValues;
				$finalData['HeqfQualification'][$record]['institution_id'] = $instID;
				if ($sheetTwoValues = $this->findQualNo($oneValues['s1_qualification_reference_no'], $sheetTwo)) {
					$finalData['HeqfQualification'][$record] += $sheetTwoValues;
				}
			}
		}

		return $this->testAndSave($finalData['HeqfQualification']);
	}

	public function findQualNo($qualNo, $sheetTwo) {
		if (isset($sheetTwo) && !empty($sheetTwo)) {
			foreach ($sheetTwo as $twoValues) {
				if ($twoValues['qualification_reference_no'] == $qualNo) {
					return $twoValues;
				}
			}
		}
		return false;
	}

	public function testAndSave($data) {
		$return = false;
		$count = 0;
		if (isset($data) && !empty($data)) {
			foreach ($data as $finalData) {
				$finalSaveData = array();

				$finalData['s1_qualification_sites'] = (isset($finalData['s1_qualification_sites'])) ? $finalData['s1_qualification_sites'] : '';
				$finalData['heqf_qualification_sites'] = (isset($finalData['heqf_qualification_sites'])) ? $finalData['heqf_qualification_sites'] : '';

				$savedData = $this->find('first', array(
					'fields' => array('HeqfQualification.id', 'HeqfQualification.upload_status'),
					'conditions' => array('HeqfQualification.s1_qualification_reference_no' => $finalData['s1_qualification_reference_no'], 'HeqfQualification.institution_id' => Auth::get('User.institution_id')),
					'contain' => 'Application'
				));

				if (isset($savedData['HeqfQualification']['id'])) {
					if (!empty($savedData['Application'])) {
						foreach ($savedData['Application'] as $key => $application) {
							if ($application['application_status'] == 'New') {
								$finalSaveData['S1QualificationSite'] = ($this->__setSites($finalData['s1_qualification_sites'])) ? $this->__setSites($finalData['s1_qualification_sites']) : '';
								$finalSaveData['HeqfQualificationSite'] = ($this->__setSites($finalData['heqf_qualification_sites'])) ? $this->__setSites($finalData['heqf_qualification_sites']) : '';
								unset($finalData['s1_qualification_sites']);
								unset($finalData['heqf_qualification_sites']);
								if (empty($finalSaveData['HeqfQualificationSite'])) {
										unset($finalSaveData['HeqfQualificationSite']);
								}
								if (empty($finalSaveData['S1QualificationSite'])) {
										unset($finalSaveData['S1QualificationSite']);
								}
								$finalSaveData[$this->name] = $finalData;
								$finalSaveData['Application'][$key]['id'] = $application['id'];
								$finalSaveData['Application'][$key]['institution_id'] = Auth::get('User.institution_id');
								$finalSaveData['Application'][$key]['user_id'] = Auth::get('User.id');
								$finalSaveData['Application'][$key]['heqf_qualification_id'] = $savedData['HeqfQualification']['id'];
								$finalSaveData[$this->name]['upload_status'] = 'New';
								$finalSaveData[$this->name]['id'] = $savedData['HeqfQualification']['id'];
								$this->HeqfQualificationSite->removeValues($savedData['HeqfQualification']['id']);
								$this->S1QualificationSite->removeValues($savedData['HeqfQualification']['id']);

								if (empty($finalSaveData['HeqfQualification']['credits_total'])) {
									$finalSaveData['HeqfQualification']['credits_total'] = '0';
								}

								$return = ($this->saveAll($finalSaveData, array('validate' => false))) ? true : false;
							}
						}
					}
				} else {
					$finalSaveData['S1QualificationSite'] = ($this->__setSites($finalData['s1_qualification_sites'])) ? $this->__setSites($finalData['s1_qualification_sites']) : '';
					$finalSaveData['HeqfQualificationSite'] = ($this->__setSites($finalData['heqf_qualification_sites'])) ? $this->__setSites($finalData['heqf_qualification_sites']) : '';
					unset($finalData['s1_qualification_sites']);
					unset($finalData['heqf_qualification_sites']);
					if (empty($finalSaveData['HeqfQualificationSite'])) {
							unset($finalSaveData['HeqfQualificationSite']);
					}
					if (empty($finalSaveData['S1QualificationSite'])) {
							unset($finalSaveData['S1QualificationSite']);
					}
					$finalSaveData[$this->name] = $finalData;
					$finalSaveData['Application'][$count]['application_status'] = 'New';
					$finalSaveData['Application'][$count]['institution_id'] = Auth::get('User.institution_id');
					$finalSaveData['Application'][$count]['user_id'] = Auth::get('User.id');
					$finalSaveData[$this->name]['upload_status'] = 'New';
					if (empty($finalSaveData['HeqfQualification']['credits_total'])) {
						$finalSaveData['HeqfQualification']['credits_total'] = '0';
					}

					$return = ($this->saveAll($finalSaveData, array('validate' => false))) ? true : false;
				}
				$count++;
			}
		}

		return $return;
	}

	private function __setSites($sites) {
		$saveSites = array();
		if (isset($sites) && !empty($sites)) {
			$sites = unserialize(base64_decode($sites));
			foreach ($sites as $key => $site) {
				$saveSites[$key]['site_id'] = $site['site_id'];
				$saveSites[$key]['site_name'] = $site['site_name'];
			}
			return $saveSites;
		} else {
			return false;
		}
	}

	public function beforeValidate() {
		$Heqf = new HeqfHelper();

		$this->tempValidate = $this->validate;

		if (isset($this->userDetails['Institution']['priv_publ'])) {
			$institutionType = $this->userDetails['Institution']['priv_publ'] == 2 ? 'public' : 'private';
		} else {
			$institutionType = Auth::get('Institution.priv_publ') == 2 ? 'public' : 'private';
		}

		foreach ($this->validate as $field => $rules) {
			foreach ($rules as $name => $rule) {
				if ($rule[$institutionType] == 0) {
					unset($this->validate[$field][$name]);
				}
				if (isset($this->data[$this->name]['qualification_reference_no']) && empty($this->data[$this->name]['qualification_reference_no']) && isset($Heqf->section2Fields[$field])) {
					unset($this->validate[$field][$name]);
				}
			}
			if (empty($this->validate[$field])) {
				unset($this->validate[$field]);
			}
		}

		return true;
	}

	public function deleteAssociatedData($modelData) {
		foreach ($modelData as $model => $id) {
			$this->$model->deleteAll(
				array(
					$model . '.heqf_qualification_id' => $id
				)
			);
		}
	}

	public function beforeSave() {
		if (!empty($this->tempValidate)) {
			$this->validate = $this->tempValidate;
		}

		/*if (!empty($this->data['HeqfQualification']['ProgrammeDesignDetail'])) {
			$this->deleteAssociatedData(array('ProgrammeDesignDetail' => $this->data['HeqfQualification']['id']));
			$programmeSave = array();
			foreach ($this->data['HeqfQualification']['ProgrammeDesignDetail'] as &$programme) {
				$programme['heqf_qualification_id'] = $this->data['HeqfQualification']['id'];
			}

			$this->ProgrammeDesignDetail->saveAll($this->data['HeqfQualification']['ProgrammeDesignDetail']);
		}*/

		if (!empty($this->data['HeqfQualification']['ProgrammeAssessmentApproach'])) {
			$this->deleteAssociatedData(array('ProgrammeAssessmentApproach' => $this->data['HeqfQualification']['id']));
			$programmeSave = array();
			foreach ($this->data['HeqfQualification']['ProgrammeAssessmentApproach'] as &$programme) {
				$programme['heqf_qualification_id'] = $this->data['HeqfQualification']['id'];
			}

			$this->ProgrammeAssessmentApproach->saveAll($this->data['HeqfQualification']['ProgrammeAssessmentApproach']);
		}

		$this->data['HeqfQualification']['s3_modules'] = 0;
		if (isset($this->data['HeqfQualification']['id'])) {
			$findQuery = array(
				'conditions' => array(
					'heqf_qualification_id' => $this->data['HeqfQualification']['id']
				)
			);
			$this->data['HeqfQualification']['s3_modules'] = $this->HeqfQualificationModule->find('count', $findQuery) > 0;
		}

		if (!empty($this->data[$this->alias]['replace_qual']) && is_array($this->data[$this->alias]['replace_qual'])) {
			$this->data[$this->alias]['replace_qual'] = implode(',', $this->data[$this->alias]['replace_qual']);
		}

		return true;
	}

	public function timeConversion($value) {
		//check valid date
		if (is_numeric($value)) {
			//excel stores the days (number of days since Jan. 1, 1900) as the timestamp
			// But you must subtract 1 from the days to get the correct timestamp
			$ts = mktime(0, 0, 0, 1, $value - 1, 1900);
			return date("Y-m-d", $ts);
		} else {
			return '1970-01-01';
		}
	}

	public function onlineEdit() {
		$list = $this->find('list', array(
					'conditions' => array('HeqfQualification.edited_online' => true, 'HeqfQualification.institution_id' => Auth::get('User.institution_id'), 'HeqfQualification.upload_status' => 'New'),
					'fields' => array('HeqfQualification.s1_qualification_reference_no')
				)
		);

		return $list;
	}

	public function sectionTwoVals($saveData) {
		$sectionTwoSheet = 'S2 Amended qualification info';
		if (!empty($saveData[$sectionTwoSheet])) {
			foreach ($saveData[$sectionTwoSheet] as $data) {
				$this->sectionTwoValidateData[] = $data['qualification_reference_no'];
				$this->__sectionTwoQualTypes[$data['qualification_reference_no']] = $data['lkp_qualification_type_id'];
				$this->replaceQualRefnos[] = (isset($data['replace_qual'])) ? $data['replace_qual'] : '';
			}
		}
	}

	public function getSectionTwoQuals() {
		$list = $this->find('list', array(
					'conditions' => array(
						'HeqfQualification.institution_id' => Auth::get('User.institution_id')
					),
					'fields' => array('HeqfQualification.qualification_reference_no', 'HeqfQualification.id')
				)
		);

		return (!empty($list)) ? $list : '';
	}

	private function __getIdFromLookup($model, $value) {
		$match = $this->_getLookupValue($value, $model);

		if (empty($match)) {
			return null;
		}
		return $match[$model][$this->{$model}->primaryKey];
	}

	private function __coreCatExclude($category) {
		$allowedCategories = array('B', 'C');

		$value = $this->__getIdFromLookup('S1HeqfAlign', $category);

		if (in_array($value, $allowedCategories)) {
			return false;
		}

		return true;
	}

	private function __coreCatValidation($value, $qualNo) {
		if (isset($value) && !empty($value)) {

			$model = 'S1HeqfAlign';
			$match = $this->_getLookupValue($value, 'S1HeqfAlign');

			if (!empty($match)) {
				$value = $match[$model][$this->{$model}->primaryKey];
			}

			if (($value == 'A' || $value == 'B')) {
				//check replace quals
				if (!empty($this->replaceQualRefnos)) {
					foreach ($this->replaceQualRefnos as $replaceNos) {
						if (strlen(strstr($replaceNos, ',')) > 0) {
							$replaceArray = explode(',', $replaceNos);
							foreach ($replaceArray as $replaceValue) {
								if ($qualNo == trim($replaceValue)) {
									return false;
								}
							}
						}
					}
				}
				$importValues = (count($this->sectionTwoValidateData) > 0) ? array_flip($this->sectionTwoValidateData) : '';
				$dbValues = $this->__sectionTwoQuals;
				if ((!empty($importValues) && isset($importValues[$qualNo])) || (!empty($dbValues) && isset($dbValues[$qualNo]))) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function completeApplications() {
		return $this->find('all', array(
			'order' => array(
				'HeqfQualification.s1_qualification_title',
				'HeqfQualification.lkp_qualification_type_id',
			),
			'conditions' => array(
				'HeqfQualification.institution_id' => Auth::get('Institution.id')
			)
		));
	}

	public function setThisData($sessionData) {
		$thatData = array();
		$allowedRecords = array('recordError', 'correctRecord');

		$recordCount = 0;
		foreach ($sessionData as $sheetNo => $report) {
			unset($report['categoryErrors']);
			unset($report['duplicateErrors']);
			unset($report['totalRecords']);
			unset($report['correctRecords']);
			unset($report['totalCoreErrors']);
			unset($report['nonExistErrors']);
			unset($report['submittedErrors']);
			unset($report['recordErrors']);
			foreach ($report['validationData'] as $sheetName => $sheetData) {
				foreach ($sheetData as $recordNo => $record) {
					foreach ($record as $state => $information) {
						if (in_array($state, $allowedRecords)) {
							$recordCount++;
							$thatData[$this->name][$sheetNo][$recordCount] = $information;
						}
					}
				}
			}
		}

		return $thatData;
	}

	public function heqfDataDump($conditions) {
		$this->recursive = -1;
		$report = array(
			'contain' => array(
				'Application' => array(
					'conditions' => array(
						'Application.inactive' => 0,
						'Application.archived' => 0,
						'Application.application_status !=' => 'New'
					)
				)
			),
			'conditions' => $conditions
		);

		return $report;
	}

	public function letterDataReport($conditions) {
		$this->recursive = -1;
		$report = array(
			'contain' => array(
				'Application' => array(
					'conditions' => array(
						'Application.inactive' => 0,
						'Application.archived' => 0
					)
				)
			),
			'conditions' => $conditions,
			'fields' => array(
				'HeqfQualification.id',
				'HeqfQualification.s1_lkp_heqf_align_id',
				'HeqfQualification.institution_id',
				'HeqfQualification.lkp_qualification_type_id',
				'HeqfQualification.s1_qualification_reference_no',
				'HeqfQualification.qualification_reference_no',
				'HeqfQualification.qualification_title',
				'HeqfQualification.s1_qualification_title',
				'HeqfQualification.qualification_title_short',
				'HeqfQualification.institution_qualification_title',
				'HeqfQualification.saqa_qualification_id',
				'HeqfQualification.lkp_designator_id',
				'HeqfQualification.other_designator',
				'HeqfQualification.lkp_cesm1_code_id',
				'HeqfQualification.lkp_delivery_mode_id',
				'HeqfQualification.lkp_professional_class_id',
				'HeqfQualification.lkp_nqf_level_id',
				'HeqfQualification.credits_total',
				'HeqfQualification.wil_el_credits',
				'HeqfQualification.research_credits',
				'HeqfQualification.hemis_lkp_cesm3_code_id',
				'HeqfQualification.apx_A',
				'HeqfQualification.apx_B',
				'HeqfQualification.let_hei_id',
				'HeqfQualification.let_hei_code',
				'HeqfQualification.let_hei_name',
				'HeqfQualification.let_qual_ref_no',
				'HeqfQualification.let_qual_title_abbr',
				'HeqfQualification.let_qual_title',
				'HeqfQualification.let_dupl_ind',
				'HeqfQualification.let_saqa_qual_id',
				'HeqfQualification.let_qual_designator',
				'HeqfQualification.let_motivation_other_designator',
				'HeqfQualification.let_cesm',
				'HeqfQualification.let_cesm_ind',
				'HeqfQualification.let_mode_of_delivery',
				'HeqfQualification.let_prof_class',
				'HeqfQualification.let_nqf_exit_level',
				'HeqfQualification.let_total_credits',
				'HeqfQualification.let_wil_el_credits',
				'HeqfQualification.let_research_credits',
				'HeqfQualification.let_rc_ind',
				'HeqfQualification.let_major_field_of_study',
				'HeqfQualification.let_mfos_ind'
			)
		);

		return $report;
	}

	public function letterVerifications($conditions) {
		$finalConditions = array_merge($conditions, array('OR' => array('HeqfQualification.apx_A' => true, 'HeqfQualification.apx_B' => true)));

		$this->recursive = -1;
		$report = array(
			'conditions' => $finalConditions,
			'fields' => array(
				'HeqfQualification.id',
				'HeqfQualification.institution_id',
				'HeqfQualification.lkp_qualification_type_id',
				'HeqfQualification.qualification_reference_no',
				'HeqfQualification.qualification_title',
				'HeqfQualification.qualification_title_short',
				'HeqfQualification.saqa_qualification_id',
				'HeqfQualification.lkp_designator_id',
				'HeqfQualification.other_designator',
				'HeqfQualification.motivation_other_designator',
				'HeqfQualification.lkp_cesm1_code_id',
				'HeqfQualification.lkp_delivery_mode_id',
				'HeqfQualification.lkp_professional_class_id',
				'HeqfQualification.lkp_nqf_level_id',
				'HeqfQualification.credits_total',
				'HeqfQualification.wil_el_credits',
				'HeqfQualification.research_credits',
				'HeqfQualification.hemis_lkp_cesm3_code_id',
				'HeqfQualification.apx_A',
				'HeqfQualification.apx_B',
				'HeqfQualification.let_dupl_ind',
				'HeqfQualification.let_cesm_ind',
				'HeqfQualification.let_rc_ind',
				'HeqfQualification.let_mfos_ind'
			),
			'order' => array(
				'HeqfQualification.qualification_reference_no ASC'
			)
		);

		return $report;
	}

	public function runValidationFunctions() {
		$this->multipleValuesCESM(array('lkp_cesm1_code_id' => $this->data['HeqfQualification']['lkp_cesm1_code_id']), 'Cesm2Code', '4');
		return $this->data['HeqfQualification']['lkp_cesm1_code_id'];
	}
	
	public function getHistoryData($foreign_key_id){
		$historyData = $this->AuditLog->find('all', array(
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'INNER',
					'conditions' => array(
						'BINARY User.id = BINARY AuditLog.created_by',
						'User.role_id' => '71f77998-544e-11e0-b14b-000c292ff614'
					)
				) 
			),					
			'callbacks' => false,
			'fields'=> array(
				'AuditLog.data','AuditLog.created','AuditLog.created_by, User.first_name, User.last_name'
			) ,
			'conditions' => array(
				'AuditLog.model'=> $this->alias, 'AuditLog.foreign_key' => $foreign_key_id 
			), 
				'Order' => 'AuditLog.created ASC'
			)
		);	
		return $historyData;
	}

	public function isWillRequired($heqf_qualification_id){
		$willRequired = false;
		$data = $this->find('first', array('fields'=> array('HeqfQualification.s3_has_wil'), 'conditions' => array('HeqfQualification.id' => $heqf_qualification_id)));
		if(!empty($data)){
			$s3_has_wil = $data['HeqfQualification']['s3_has_wil'];
			if($s3_has_wil == '1'){
				$willRequired = true;
			}
		}	
		return $willRequired;
	}
}