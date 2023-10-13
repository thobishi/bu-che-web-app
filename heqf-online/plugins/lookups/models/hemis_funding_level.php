<?php
class HemisFundingLevel extends LookupsAppModel {
	var $name = 'HemisFundingLevel';
	
	public $displayField = 'funding_level_desc';
	public $order = 'id';	
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('HemisFundingLevel.id', 'HemisFundingLevel.funding_level_desc')
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