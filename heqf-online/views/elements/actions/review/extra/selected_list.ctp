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
					case 'set_review_outcome':
						$message .= '<li>No application(s) selected.</li>';
						$message .= '<li>A Review Outcome already exists for the selected application(s).</li>';
						$message .= '<li> Q1, Q2 or Q3 of the application(s) is <i>"Needs improvement".</i></li>';
						$message .= '<li>A Representation/Deferral Outcome already exists for the selected application(s).</li>';
						break;
					case 'mark_reviewed':
						$message .= '<li>No application(s) selected.</li>';
						$message .= '<li>A <i>"Review Outcome".</i> is needed for the selected application(s) in Review</li>';
						$message .= '<li>A <i>"Representation/Deferral Outcome".</i> is needed for the selected for Representations/Deferrals</li>';
					break;
					case 'return_without_review':
						$message .= '<li>No application(s) selected.</li>';
						$message .= '<li>A <i>"Review Outcome".</i> exists for the selected application(s)</li>';
						$message .= '<li>A <i>"Representation/Deferral".</i> exists for the selected application(s)</li>';
					break;
				}
				$message .= '</ul>';
			}
			echo 'No qualifications will be affected by this action.';
			echo '<div class="assignReasons">' . $message . '</div>';
		}
	?>
</div>
