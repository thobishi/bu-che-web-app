<?php
class Setting extends AppModel {

	public $configurableSetting = array(
		'evaluation_due_date_period',
		'review_due_date_period',
		'evaluation_reminder1_period',
		'evaluation_reminder2_period',
		'evaluation_overdue1_period',
		'evaluation_overdue2_period',
		'review_reminder1_period',
		'review_reminder2_period',
		'review_overdue1_period',
		'review_overdue2_period',
		'reminder_email_cc'
	);


	public function getConfigurableSetting() {
		$settings = $this->find('all', array(
			'conditions' => array(
				'Setting.id' => $this->configurableSetting 
			)
		));
		return $settings;
	}
	
}