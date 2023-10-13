<div class="applicationList">
	<?php

	$message = '<ul>';	
	if(isset($this->params['form']['action'])){
		switch($this->params['form']['action']){
			case 'outcome_notify':
				$message .= '<li>No Institution(s) selected.</li>';
				$message .= '<li>Institutions already notified.</i></li>';
				$message .= '<li>Outcomes not accepted.</i></li>';
				break;
			case 'outcome_accept':
				$message .= '<li>No Institution(s) selected.</li>';
				$message .= '<li>Outcomes already accepted.</i></li>';
				break;
		}
	}
	$message .= '</ul>';
	
	if(!empty($institutions)){
		$listData = array();
		if(!empty($this->data)){
			if(!empty($this->data['Process']['selected'])){
				foreach($this->data['Process']['selected'] as $date => $instID){
					foreach($institutions as $institution){
						if($institution['Institution']['id'] == $instID){
							$date = str_replace(substr($date, strpos($date, '_'), strlen($date)), '', $date);
							array_push($listData, array(
								'name' => $institution['Institution']['hei_name'],
								'code' => $institution['Institution']['hei_code'],
								'id' => $institution['Institution']['id'] . $date,
								'date' => $date,
								)
							);
						}
					}
				}
			}
		}
		$listData = Set::combine($listData, '{n}.id', array('<strong>{0}</strong> ({1}) - {2}', '{n}.name', '{n}.code', '{n}.date'));
		echo '<h4>'.$listHeading.'</h4>';
		echo $this->Html->nestedList($listData);
	}
	else{
		echo 'No institutions will be affected by this action.';
		echo '<div class="assignReasons">' . $message . '</div>';
	}
	?>
</div>
