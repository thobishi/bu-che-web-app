<?php
class ModuleAction extends LookupsAppModel {
	var $name = 'ModuleAction';
	
	public $displayField = 'action';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('ModuleAction.id', 'ModuleAction.action')
								));
		
		return $values;
		
	}
}