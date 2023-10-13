<?php

class HeqcInstitution extends HeqcAppModel {
	public $useTable = 'HEInstitution';
	public $primaryKey = 'HEI_id';
	public $displayField = 'HEI_name';
	public $order = 'HEI_name';

	
	public $validation = array(
		'hei_name' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'You need to enter your institution\'s name.'
			)
		)
	);
	 	
}
