<?php
class CesmCode extends LookupsAppModel {
	var $name = 'CesmCode';
	
	public $displayField = 'Description';
	public $codeField = 'DOE_CESM_code';
	public $order = 'id';		
	
	function getValues(){
		$values = 	$this->find('list', array(
			'fields' => array('CesmCode.id')
		));
		
		return $values;
	}	
}