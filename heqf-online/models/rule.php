<?php
class Rule extends AppModel {
	var $name = 'Rule';
	
	function getCompulsoryFields(){
	
		$compulsory = $this->find('list', array(
							'fields' => array('Rule.column_name'),
							'conditions' => array('Rule.compulsory' => true, 'Rule.active' => true)
		));
		
		return $compulsory;
	
	}
	
}
?>