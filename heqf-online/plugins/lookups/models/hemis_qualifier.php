<?php
class HemisQualifier extends LookupsAppModel {
	var $name = 'HemisQualifier';

	public $displayField = 'hemis_qualifier_desc';
	public $order = 'id';	
	
	function getValues(){
		
		$values = $this->find('list', array(
					'fields' => array('HemisQualifier.id')
				));
		return $values;
		
	}	
}