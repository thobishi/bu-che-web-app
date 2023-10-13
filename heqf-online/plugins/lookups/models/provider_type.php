<?php
class ProviderType extends LookupsAppModel {
	var $name = 'ProviderType';
	
	public $displayField = 'uni_tech';
	public $order = 'id';	
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('ProviderType.id', 'ProviderType.uni_tech')
								));
		
		return $values;
		
	}
}