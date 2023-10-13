<?php
class QualificationType extends LookupsAppModel {
	var $name = 'QualificationType';
	
	public $displayField = 'qualification_type_desc';
	public $order = 'id';
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('QualificationType.id', 'QualificationType.qualification_type_desc')
								));
		/*
			altered the values to match what is in the db
		*/
								
		foreach($values as $key => $value){
			$values[$key] = $key.' '.$value;
		}
		
		return $values;
		
	}
	
	function getAllValues($givenValue){
		
		$values = $this->find('all', array(
									'conditions' => array('QualificationType.id' => $givenValue)
										));
		
		return $values;
		
	}	
}