<?php
class NqfLevel extends LookupsAppModel {
	var $name = 'NqfLevel';
	
	public $displayField = 'nqf_level_desc';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('NqfLevel.id')
								));
		
		return $values;
		
	}		
}