<?php
class DeliveryMode extends LookupsAppModel {
	var $name = 'DeliveryMode';
	
	public $displayField = 'delivery_mode_desc';
	public $order = 'id';		
	
	function getValues(){
		
		$values = 	$this->find('list', array(
									'fields' => array('DeliveryMode.id', 'DeliveryMode.delivery_mode_desc')
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