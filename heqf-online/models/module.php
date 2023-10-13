<?php
class Module extends AppModel {
	var $name = 'Module';
	var $totalRows = 0;
	var $rowsProcessed = 0;
	
	function validateData($saveData, $model, $sheet, $compulsory, $browser){

		$this->rowsProcessed = $this->Session->read('recordsProcessed');
		$this->totalRows = $this->Session->read('totalRows');	
		
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
	
	function testAndSave($data){

		App::import('model','Alignment');
		$model = new Alignment();
		
		$submitted = $model->find('first', array(
							'fields' => array('Alignment.id'),
							'conditions' => array('Alignment.qualification_ref_no' => $data['qualification_ref_no'], 'Alignment.status' => 'New')
		));
		
		$savedData = $this->find('first', array(
							'fields' => array('Module.id', 'Module.qualification_ref_no', 'Module.alignment_id', 'Module.module_code', 'Module.module_name', 'Module.module_type', 'Module.credit_weighting', 'Module.nqf_level', 'Module.year_of_study', 'Module.status'),
							'conditions' => array('Module.module_code' => $data['module_code'])
		));

		if(isset($submitted['Alignment']['id'])){ //if application with same qual no exists and not submitted, go in, else not save
			if($savedData['Module']['id']){ //check if this module has been save already. if has, overwrite, else new
				$finalData['Module']['alignment_id']         = $submitted['Alignment']['id'];
				$finalData['Module']['qualification_ref_no'] = $data['qualification_ref_no'];
				$finalData['Module']['module_name']          = $data['module_name'];
				$finalData['Module']['module_type']          = $data['module_type'];
				$finalData['Module']['nqf_level']            = $data['nqf_level'];
				$finalData['Module']['year_of_study']        = $data['year_of_study'];
				$finalData['Module']['error']                = $data['error'];
				$finalData['Module']['status']               = 'New';
				$finalData['Module']['id']                   = $savedData['Module']['id'];
				return $this->save($finalData);
			}
			else{
				$data['alignment_id'] = $submitted['Alignment']['id'];
				$data['status'] = 'New';
				return $this->save($data);			
			}		
		}
		else{
			return true;
		}
	

	}
	
	function getAlignmentID($data, $newQual, $oldQual, $currentAppID){
	
		App::import('model','Alignment');
		$model = new Alignment();
		$model->recursive = 0;
		
		$saved = $model->find('first', array(
							'fields' => array('Alignment.id'),
							'conditions' => array('Alignment.qualification_ref_no' => $data['qualification_ref_no'], 'Alignment.status' => 'New')
		));
		
		if(isset($saved['Alignment']['id'])){
			/*
				Found, but can be the current one
			*/
				if($newQual == $oldQual){
					return $saved['Alignment']['id'];
				}
				else{
					if($data['qualification_ref_no'] == $oldQual){
						return false;
					}
					else{
						return $saved['Alignment']['id'];
					}
				}
		}
		else{
			if($newQual == $oldQual){
				return false;
			}
			else{
				if($data['qualification_ref_no'] == $newQual){
						return $currentAppID;
				}
				else{
					return false;
				}
				
			}
		}
	
	}
	
	function findAndSave($data){

		App::import('model','Alignment');
		$model = new Alignment();
		$model->recursive = 0;	
	
		$application = $model->find('first', array(
							'fields' => array('Alignment.id'),
							'conditions' => array('Alignment.qualification_ref_no' => $data['Module']['qualification_ref_no'], 'Alignment.status' => 'New')
		));
	
		if(isset($application['Alignment']['id'])){
			$data['Module']['status'] = 'New';
			$data['Module']['alignment_id'] = $application['Alignment']['id'];
			return $this->save($data);
		}
		else{
			$this->validationErrors['qualification_ref_no'] = 'Qualification reference number does not exist, or application has already been submitted';
			return false;
		}
	
	}	
			
	
}
?>