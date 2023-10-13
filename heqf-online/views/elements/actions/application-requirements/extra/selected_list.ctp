<div class="applicationList">
	<?php
		$message = '';
		if(isset($this->params['form']['action'])){
			$message = '<br /><h1 class="assignReasons">Possible reason(s):</h1><ul>';
			switch($this->params['form']['action']){
				case 'assign_checklister':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application(s) status must be <i>"Submitted".</i></li>';
					break;
				case 'assign_evaluator':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application status must be <i>"Checklisted".</i></li>';
					$message .= '<li>Application is still being "Checklisted" by the checklister and is not ready for evaluation.</li>';
					$message .= '<li>Application is still being <i>"Evaluated"</i>.</li>';
					$message .= '<li>Application is to be returned to the institution.</li>';
					break;
				case 'assign_reviewer':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application status must be <i>"Evaluated".</i></li>';
					$message .= '<li>Application is still being "Evaluated" by the evaluator and is not ready for review.</li>';
					break;
				case 'archive':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application has been submitted.</i>.</li>';
					break;
				case 'assign':
					$message .= '<li>No application(s) selected.</li>';
					break;
				case 're_submit':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>Application(s) need correction.</li>';
					$message .= '<li>Application(s) already re-submitted.</li>';
					break;
				case 'submit':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>Application(s) need correction.</li>';
					$message .= '<li>Application(s) already submitted.</li>';
					$message .= '<li>Application(s) needs to be re-submitted.</li>';
					break;
				case 'take_back':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>Application(s) already assigned to you.</li>';
					break;
				case 'return_inst':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application(s) must be <i>"Submitted"</i> or have a <i>checklisting</i> status.</li>';
					break;
				case 'return_inst_review':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application status must be <i>Reviewed (return)</i>.</li>';
					break;
			}
			$message .= '</ul>';
		}
	
		if(!empty($applications)) {
			$applications = Set::combine($applications, '{n}.HeqfQualification.id', array('<strong>{0}</strong> - {1}', '{n}.HeqfQualification.s1_qualification_reference_no', '{n}.HeqfQualification.s1_qualification_title'));
			echo '<h4>'.$listHeading.'</h4>';
			echo $this->Html->nestedList($applications);
		}
		else {
			echo 'No qualifications will be affected by this action.';
			echo '<div class="assignReasons">' . $message . '</div>';
		}
	?>
</div>
