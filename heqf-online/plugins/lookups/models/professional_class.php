<?php
class ProfessionalClass extends LookupsAppModel {
	var $name = 'ProfessionalClass';
	
	public $displayField = 'professional_class_desc';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('ProfessionalClass.id', 'ProfessionalClass.professional_class_desc')
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