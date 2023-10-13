<?php
	$message = '';
	if(isset($this->params['form']['action'])){
		switch($this->params['form']['action']){
			case 'assign_checklister':
				$message = 'No users have been assigned to a "<i>checklister</i>" role.';
				break;
			case 'assign_evaluator':
				$message = 'No users have been assigned to a "<i>evaluator</i>" role.';
				break;
			case 'assign_reviewer':
			case 'assign_representation_reviewer':
				$message = 'No users have been assigned to a "<i>reviewer</i>" role.';
				break;
		}
	}
	if(isset($users) && !empty($users)){
		if (!empty($applications)){
			echo $this->Form->input('Application.user_id', array('label' => 'Reviewer to assign representation(s) to'));
		}
	}
	else{
		echo $message;
	}
?>