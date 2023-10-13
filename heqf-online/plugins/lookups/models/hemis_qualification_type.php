<?php
class HemisQualificationType extends LookupsAppModel {
	var $name = 'HemisQualificationType';
	
	public $displayField = 'hemis_qualification_type_desc';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('HemisQualificationType.id', 'HemisQualificationType.hemis_qualification_type_desc')
								));
		/*
			altered the values to match what is in the db
		*/
								
		foreach($values as $key => $value){
			$values[$key] = $key.' '.$value;
		}
		
		return $values;
		
	}	
}