<?php

/*
For lookups, create one custom function, send the model name

$modelName = 'test';
$this->{$modelName}->etc

Use the belongs to relationships as well to get the data, also the new methods in the findModel function
*/

class Alignment extends AppModel {
	var $name = 'Alignment';
	var $useTable = 'heqf_qualifications';
	
    var $hasMany = array(
        'Module' => array(
            'className'  => 'Module',
            'foreignKey' => 'alignment_id',
			'fields'     => array('id', 'error', 'module_code', 'module_name', 'module_type', 'credit_weighting', 'nqf_level', 'year_of_study', 'qualification_ref_no'),
            'dependent'=> true
        )
    );

	var $validate = array(
		'import_file' => array(
			'rule' => 'file',
			'message' => 'File is required'
		)		
	);
	
	var $totalRows = 0;

	
	function testFunction($check, $field){
		
		$value = array_values($check);
		$value = $value[0];

		$empty = 0;
		if($this->data[$this->name][$field] == 'Other' && $value == ''){
			$empty++;
		}
		if($empty){
			return FALSE;
		}
		else{	
			return TRUE;
		}
	}		
	
	function testAndSave($data){
	
	/*
		sheetnumber incorrect -> nee to get the correct count, coz includes the help sheets etc, maybe use names....?
		Sheet 1 and 2 are together -> dependancies etc
		Sheet 4 and 5 are together -> dependancies etc
		
		Need to bring the data here in seperate sheets
		Then can check what sheet it is in, and therefore save differently depending on the sheet etc
		Coz at the moment, saving all the records in one table, want different tables, for each sheet or something like that
		Also want to link tables to alignment table on record -> qual_ref_no
	*/
		$savedData = $this->find('first', array(
							'fields' => array('Alignment.id', 'Alignment.institution_name', 'Alignment.institution_number', 'Alignment.provider_type', 'Alignment.qualification_ref_no', 'Alignment.qualification_title', 'Alignment.qualification_title_abbr', 'Alignment.error', 'Alignment.status'),
							'conditions' => array('Alignment.qualification_ref_no' => $data['qualification_ref_no'])
		));
					
		$finalData = array();
		
		if(isset($savedData['Alignment']['id'])){
			if($savedData['Alignment']['status'] == 'Submitted'){
				return true;
			}
			else{
				$finalData['Alignment']['institution_name']         = $data['institution_name'];
				$finalData['Alignment']['institution_number']       = $data['institution_number'];
				$finalData['Alignment']['provider_type']            = $data['provider_type'];
				$finalData['Alignment']['qualification_ref_no']     = $data['qualification_ref_no'];
				$finalData['Alignment']['qualification_title_abbr'] = $data['qualification_title_abbr'];
				$finalData['Alignment']['qualification_title']      = $data['qualification_title'];
				$finalData['Alignment']['error']                    = $data['error'];
				$finalData['Alignment']['status']                   = 'New';
				$finalData['Alignment']['id']                       = $savedData['Alignment']['id'];
				return $this->save($finalData);
			}
		}
		else{				
			$data['status'] = 'New';
			return $this->save($data);
		}
		
		return false;
	}
	
	function isUploadedFile($params){
		$types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel');
		if(isset($params['data']['Alignment']['import_file']['tmp_name']) && is_uploaded_file($params['data']['Alignment']['import_file']['tmp_name']) && ($params['data']['Alignment']['import_file']['error'] == 0)){
			if(in_array($params['data']['Alignment']['import_file']['type'], $types )){
				return true;
			}
		}
		return false;
	}
	
	function saveEdit($data){
		
		$dataArray = array();
		$error = false;
		$saveError = 0;
		foreach($data as $modelName => $value){
			$model = ClassRegistry::init($modelName);
			if((is_array($value)) && isset($value[0])){
				foreach($value as $key => $field){
					$dataArray[$modelName] = $field;
					if($id = $model->getAlignmentID($field, $data['Alignment']['qualification_ref_no'], $data['Alignment']['old_qualification_ref_no'], $data['Alignment']['id'])){
						$dataArray[$modelName]['alignment_id'] = $id;
					}
					else{
						$this->$modelName->validationErrors[$key]['qualification_ref_no'] = 'Qualification reference number does not exist, or application has already been submitted';
						$error = true;
					}
					$dataArray[$modelName]['error'] = false;
					$saveError += ($model->save($dataArray)) ? 0 : 1;
					if(count($model->validationErrors) > 0){
						foreach($model->validationErrors as $field => $message){
							$this->$modelName->validationErrors[$key][$field] = $message;
						}
					}
				}
			}
			else{
				$dataArray[$modelName] = $value;
				$dataArray[$modelName]['error'] = false;
				$saveError += ($this->save($dataArray)) ? 0 : 1;
			}
		}		
		return (!$error && !$saveError) ? true : false;
	
	}
	
	function submitData($id, $value){
		
		$data = array();
		
		if($value){
			$data['Alignment']['status'] = 'Submitted';
			$data['Alignment']['id']     = $id;
			return $this->save($data);
		}
		return true;
		
	
	}
	
	function validateData($saveData, $model, $sheet, $compulsory, $browser){
		
		$resultsArray = array();
		$iterations   = ($browser) ? 15 : 5 ;
		$recordErrors = 0;
		$totalRecords = 0;
		$totalCoreErrors = 0;
		$correctRecords = 0;
		$validationData = array();
		
		foreach($saveData as $key => $data){
			$this->set($data);
			$coreError = false;
			$totalRecords++;
			
			//----------Progress----------
			$percent = ($totalRecords/$this->totalRows) * 100;
			if($percent % $iterations == 0) {
				session_start();
				$this->Session->write('percent', floor($percent));
				session_write_close();				
			}
			//----------------------------
			
			//----------Validate----------
			foreach($data as $field => $value){
				$coreErrorFieldCount = 0;
				//first check core fields
				if(in_array($field, $compulsory) && $value == ''){
					$coreError = true;
					$data['coreErrorFields'][$coreErrorFieldCount] = $field;
					$coreErrorFieldCount++;
				}
			}
			if($coreError){
				$totalCoreErrors++;
				$validationData[$sheet][$totalRecords]['coreError'] = $data;
			}
			if(!$this->validates() && !$coreError){
				$recordErrors++;
				foreach($this->validationErrors as $field_name => $error){
					$data['recordErrorFields'][$field_name] = $error;
				}
				$validationData[$sheet][$totalRecords]['recordError'] = $data;				
			}
			elseif(!$coreError && $this->validates()){
				$correctRecords++;
			}
			//----------------------------
		}
		
		session_start();
		$this->Session->write('recordsProcessed', $totalRecords);
		$this->Session->write('totalRows', $this->totalRows);
		session_write_close();
				
		$resultsArray['validationData'] = $validationData;
		$resultsArray['recordErrors'] = $recordErrors;
		$resultsArray['totalRecords'] = $totalRecords;
		$resultsArray['correctRecords'] = $correctRecords;
		$resultsArray['totalCoreErrors'] = $totalCoreErrors;
		
		return $resultsArray;
	
	}

	function checkSubmittedData($ref_no){
	
		$submittedData = array();
		
		$submittedData = $this->find('first', array(
							'fields' => array('Alignment.id'),
							'conditions' => array('Alignment.qualification_ref_no' => $ref_no, 'Alignment.status' => 'Submitted')
		));		
		if(isset($submittedData['Alignment']['id'])){
			return true;
		}
		return false;
		
	}

function getTotalRows($data){
		
		$totalRows = 0;
		$sheets = $data->numSheets();
		for($i = 0; $i < $sheets; $i++){
			$sheetData = array();
			$data->changeSheet($i);
			$totalRows += $data->getHighestRow();
		}
		
		return $totalRows;
	
}
	
	function columnNames($data, $browser){

		$iterations = ($browser) ? 15 : 5 ;
		$this->totalRows = $this->getTotalRows($data);
		$return = array();
		$saveData = array();
		$errorData  = array();
		$error = false;
		$sheets = $data->numSheets();
		$currentRowCount = 0;
		$percent = 0;
		
		//App::import('Model', 'CakeSession');
		//$session = new CakeSession(); 
		
		for($i = 0; $i < $sheets; $i++){
			$sheetData = array();
			$data->changeSheet($i);
			$head =$data->readHead();
			while($row = $data->readNextRow()) {
				$currentRowCount++;
				$percent = ($currentRowCount/$this->totalRows)*100;
				if($percent % $iterations == 0) {
					session_start();
					$this->Session->write('percent', floor($percent));
					session_write_close();
				}
				$newData = array();
				foreach($row as $col_name => $value){
					if($column = $this->searchSynonyms($col_name)){
						$newData[$column] = $value;
					}
					else{
						array_push($errorData, $col_name);
						$error = "Unknown column(s) <i>".implode(', ', array_unique($errorData))."</i> in the excel file. Download the template to obtain the required format.";
					}
				}
				array_push($sheetData, $newData);
			}
			$saveData[$data->sheetTitle()] = $sheetData;
		}		
		$return['error'] = $error;
		$return['saveData'] = $saveData;
		return $return;
	
	}

	function searchSynonyms($column){
	
		/*
			A lot of time is taken here during the verification portion of the process.
			Maybe when find the correct column name, break from the search
		*/
	
		$synonyms = array('qualification_reference_no' => array('qual ref no', 'qualification_reference_number', 'qual_ref_no'), 
						  'qualification_title' => array('qual title', 'qualification title', 'qual_title'),
						  'qualification_title_short' => array('qual title short', 'qualification title short'), 
						  'heqc_application_id' => array('heqc application id', 'heqc_app_id', 'heqc app id'),
						  'saqa_qualification_id' => array('saqa qualification id', 'saqa_qual_id', 'saqa qual id'),
						  'other_designator' => array('other designator'),
						  'motivation_other_designator' => array('motivation other designator'),
						  'professional_body' => array('professional body'),
						  'professional_body_registration_no' => array('professional body registration no', 'professional body registration number', 'professional_body_registration_number', 'professional_body_reg_no', 'professional body reg no'),
						  'credits_total' => array('credits total'),
						  'credits nqf5' => array('credits nqf5'),
						  'credits_nqf6' => array('credits nqf6'), 
						  'credits_nqf7' => array('credits nqf7'),
						  'credits_nqf8' => array('credits nqf8'),
						  'credits_nqf9' => array('credits nqf9'),
						  'credits_nqf10' => array('credits nqf10'),
						  'minimum_admission_requirements' => array('minimum admission requirements', 'min_admission_requirements', 'min admission requirements'),
						  'minimum_years_full' => array('minimum years full', 'min_years_full', 'min years full'),
						  'minimum_years_part' => array('minimum years part', 'min years part', 'min_years_part'),
						  'first_qualifier_credits' => array('first qualifier credits', 'first qual credits', 'first_qual_credits'),
						  'first_qualifier_credits_final' => array('first qualifier credits final', 'first_qual_credits_final', 'first qual credits final'),
						  'second_qualifier_credits' => array('second qualifier credits', 'second_qual_credits', 'second qual credits'),
						  'second_qualifier_credits_final' => array('second qualifier credits final', 'second_qual_credits_final', 'second qual credits final'),
						  'qualification_purpose' => array('qualification purpose', 'qual purpose', 'qual_purpose'),
						  'exit_level_outcome' => array('exit level outcome'),
						  'articulation_progression' => array('articulation progression'),
						  'rpl' => array('rpl'),
						  'international_comparability' => array('international comparability', 'int_comparability', 'int comparability'),
						  'hemis_minimum_exp_time' => array('hemis minimum exp time', 'hemis_min_exp_time', 'hemis min exp time'),
						  'hemis_total_subsidy_units' => array('hemis total subsidy units'),
						  's' => array('s'),
						  't' => array('t'),
						  'u' => array('u'),
						  'v' => array('v'),
						  'w' => array('w'),
						  'x' => array('x'),
						  'y' => array('y'),
						  'z' => array('z')
						  );
		
		$column = strtolower($column);
		
		foreach($synonyms as $key => $options){
			$options[] = $key; //Why this step???
			if(in_array($column, $options)) {
				return $key;
			}
		}
		
		return false;
	}
	
	function saveManual($data){
		
		$data['Alignment']['status'] = 'New';
		return $this->save($data);
	
	}
	
	function testAndDelete($id){
	
		$deletable = 	$this->find('first', array(
							'fields' => array('Alignment.id'),
							'conditions' => array('Alignment.id' => $id, 'Alignment.status' => 'New')
		));
		
		if(isset($deletable['Alignment']['id'])){
			return $this->delete($id);
		}
		else{
			return false;
		}
		
	}
	
	function findModel($data){
		
		$application_fields = Set::extract('/COLUMNS/Field',$this->query("DESCRIBE {$this->useTable}"));
		//App::import('model','Module');
		//$module = new Module();
		$module = ClassRegistry::init('Module');
		$module_fields = array_keys($module->schema());
		//$module_fields      = Set::extract('/COLUMNS/Field',$this->query("DESCRIBE {$module->useTable}"));
		//$test3Fields        = array('a', 'b','c','d', 'e', 'f');
		//$test4Fields        = array('aa', 'b','c','d');
		$possible_models = array('Module', 'Alignment');
		$foundInAppTable    = true;
		$foundInModuleTable = true;
		$foundTable3 = true;
		$foundTable4 = true;
		if(isset($data[0])){
			foreach($data[0] as $field => $value){
				if(!in_array($field, $application_fields)){
					$foundInAppTable = false;
					$foundTable3 = false;
					$foundTable4 = false;
					unset($possible_models[1]);
				}
				if(!in_array($field, $module_fields)){
					$foundInModuleTable = false;
					$foundTable3 = false;
					$foundTable4 = false;					
					unset($possible_models[0]);
				}	
				//Add for next sheets
				/*if(!in_array($field, $test3Fields)){
					$foundInModuleTable = false;
					$foundInAppTable = false;
					$foundTable3 = false;
					unset($possible_models[2]);
				}
				if(!in_array($field, $test4Fields)){
					$foundInModuleTable = false;
					$foundTable4 = false;
					$foundInAppTable = false;
					unset($possible_models[3]);
				}*/				
			}
		}
		$model = '';
		if(count($possible_models) == 1){
			foreach($possible_models as $value){
				$model = $value;
			}			
		}
		return ($model) ? $model  : false;
		
	}
	
	function showErrors($data){

		$dataArray = array();
		foreach($data as $modelName => $value){
			App::import('model',$modelName);
			$model = new $modelName();
			if((is_array($value)) && isset($value[0])){
				foreach($value as $key => $field){
					$dataArray[$modelName] = $field;
					$dataArray[$modelName]['error'] = false;
					$model->create($dataArray);
					$model->validates($dataArray);					
					if(count($model->validationErrors) > 0){
						foreach($model->validationErrors as $field => $message){
							$this->$modelName->validationErrors[$key][$field] = $message;
						}
					}
				}
			}
			else{
				$dataArray[$modelName] = $value;
				$dataArray[$modelName]['error'] = false;
				$this->create($dataArray);
				$this->validates($dataArray);
			}
		}
		
	
	}
	
	public function _findProcess($state, $query, $result = array()) {
		if($state == 'before') {
			//TODO: Set contain for sections
			$query['contain'] = array('Module');
			
			$query['limit'] = 1;
			
			return $query;
		}
		else {
			return reset($result);
		}
	}	
	
	public function saveProcess($processData, $processId) {
		$processData['Alignment']['id'] = $processId;
		
		return $this->save($processData);
	}	
}
?>