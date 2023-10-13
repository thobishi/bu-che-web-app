<?php
class Outcome extends LookupsAppModel {
	var $name = 'Outcome';
	
	public $displayField = 'outcome_desc';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('Outcome.id', 'Outcome.outcome_desc')
								));
		
		return $values;
		
	}
}