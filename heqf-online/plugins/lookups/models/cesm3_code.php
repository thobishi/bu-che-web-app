<?php
class Cesm3Code extends LookupsAppModel {
	var $name = 'Cesm3Code';
	
	public $displayField = 'Description';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('Cesm3Code.id')
								));
		
		return $values;
		
	}	
}