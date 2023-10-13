<?php

class HeqcUser extends HeqcAppModel {
	public $useTable = 'users';
	public $primaryKey = 'user_id';
	
	public $hasMany = array(
		'UserGroup' => array(
			'className' => 'Heqc.HeqcUserGroup',
			'foreignKey' => 'sec_user_ref'
		)
	);
}