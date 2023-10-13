<?php
class YesNoDecision extends LookupsAppModel {
	var $name = 'YesNoDecision';
	
	public $displayField = 'lkp_yn_desc';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('YesNoDecision.id')
								));
		
		return $values;
		
	}		
}