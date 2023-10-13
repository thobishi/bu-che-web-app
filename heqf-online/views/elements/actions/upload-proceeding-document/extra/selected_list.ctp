<div class="applicationList">
	<?php
		if(!empty($applications)) {
			$applications = Set::combine($applications, '{n}.HeqfQualification.id', array('<strong>{0}</strong> - {1}', '{n}.HeqfQualification.s1_qualification_reference_no', '{n}.HeqfQualification.s1_qualification_title'));

			echo '<h4>'.$listHeading.'</h4>';
			echo $this->Html->nestedList($applications);
		}
		else {
			$message = '';
			if (isset($this->params['form']['action'])) {
				$message = '<br /><h1 class="assignReasons">Possible reason(s):</h1><ul>';
				switch($this->params['form']['action']){
					case 'inst_submit_proceeding':
						$message .= '<li>No application(s) selected.</li>';
						$message .= '<li>A Representation/Deferral Document has not been uploaded.</li>';
						break;
				}
				$message .= '</ul>';
			}
			echo 'No Representations/Deferrals will be affected by this action.';
			echo '<div class="assignReasons">' . $message . '</div>';
		}
	?>
</div>
