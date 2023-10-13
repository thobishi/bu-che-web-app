<?php
class Cesm1Code extends LookupsAppModel {
	var $name = 'Cesm1Code';
	
	public $displayField = 'Description';
	public $order = 'id';			
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('Cesm1Code.id', 'Cesm1Code.Description')
								));
		
		return $values;
		
	}
}