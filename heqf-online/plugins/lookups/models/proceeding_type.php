<?php
class ProceedingType extends LookupsAppModel {
	var $name = 'ProceedingType';
	
	public $displayField = 'description';
	public $order = 'id';		
		
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('ProceedingType.id', 'ProceedingType.description')
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