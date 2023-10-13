<?php
class FilterDataHelper extends AppHelper {
	public $helpers = array('Session', 'Html','Time');
	
	public $defaultFields = array(
		'user_list' => array(
			'institution_id',
			'role_id',
			'search'
		)
	);
	
	public function setDefaults($action){
		$defaults = array();
		
		if(!empty($action) && isset($this->defaultFields[$action])){
			foreach($this->defaultFields[$action] as $field){
				$defaults[$field] = ($this->Session->check('search.data.' . $field)) ? $this->Session->read('search.data.' . $field) : '';
			}
		}
		
		return $defaults;
	}

}
?>