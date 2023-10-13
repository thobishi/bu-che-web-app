<div class="applicationList">
	<?php

	$message = '<ul>';	
	if(isset($this->params['form']['action'])){
		switch($this->params['form']['action']){
			case 'proceeding_outcome_notify':
				$message .= '<li>No Institution(s) selected.</li>';
				$message .= '<li>Institutions already notified.</i></li>';
				$message .= '<li>Proceeding Outcomes not accepted.</i></li>';
				break;
			case 'proceeding_outcome_accept':
				$message .= '<li>No Institution(s) selected.</li>';
				$message .= '<li>Proceeding Outcomes already accepted.</i></li>';
				break;
		}
	}
	$message .= '</ul>';
		
	if(!empty($institutions)) {
		$listData = array();
		foreach($institutions as $data) {
			array_push($listData, array(
				'name' => $data['Institution']['hei_name'],
				'code' => $data['Institution']['hei_code'],
				'id' => $data['Application']['institution_id'] . $data['ProceedingType']['description'],
				'procType' => $data['ProceedingType']['description'],
				)
			);
		}	
		
		$listData = Set::combine($listData, '{n}.id', array('<strong>{0}</strong> ({1}) - {2}', '{n}.name', '{n}.code', '{n}.procType'));
		echo '<h4>'.$listHeading.'</h4>';
		echo $this->Html->nestedList($listData);
	}
	else{
		echo 'No institutions will be affected by this action.';
		echo '<div class="assignReasons">' . $message . '</div>';
	}
	?>
</div>
