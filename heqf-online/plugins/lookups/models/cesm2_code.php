<?php
class Cesm2Code extends LookupsAppModel {
	var $name = 'Cesm2Code';
	
	public $displayField = 'Description';
	public $order = 'id';			
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('Cesm2Code.id')
								));
		
		return $values;
		
	}	
}