<?php
class HeqfAlign extends LookupsAppModel {
	var $name = 'HeqfAlign';
	
	public $displayField = 'heqf_align_desc';
	public $order = 'id';		
		
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('HeqfAlign.id', 'HeqfAlign.heqf_align_desc')
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