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
					$message .= '<li>Deletion of the selected application(s) have been disabled.</i>.</li>';
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
				case 'assign_heqc_meeting':
					$message .= '<li>Outcomes have been accepted.</li>';
					$message .= '<li>For cat A and B the application status must be <i>Reviewed</i>.</li>';
					$message .= '<li>For cat C the application status must be submitted or checklisted.</li>';
				break;
				case 'assign_proc_heqc_meeting':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>No Deferral(s)/Representation(s) found for the selected application(s).</li>';
					$message .= '<li>The Application status must be <i>Representation (Processed)</i> Or <i>Deferral (Processed)</i></li>';
				break;
				case 'return_for_representation':
					$message .= '<li>The application status must be <i>Reviewed</i>.</li>';
					$message .= '<li>The Review Outcome must be <i>Not HEQSF-aligned and Re-categorised to Category C</i></li>';
					$message .= '<li>The Application status must not be <i>Representation (Submitted)</i></li>';
				break;
				case 'return_for_deferral':
					$message .= '<li>The application status must be <i>Reviewed</i>.</li>';
					$message .= '<li>The Review Outcome must be <i>Needs Improvement</i></li>';
					$message .= '<li>The Application status must not be <i>Defferal (Submitted)</i></li>';
				break;
				case 'assign_representation_reviewer':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application(s) must have a <i>Representation (Submitted)</i> status.</li>';
				break;
				case 'assign_deferral_reviewer':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>The application(s) must have a <i>Deferral (Submitted)</i> status.</li>';
				break;
				case 're_categorise_to_c':
					$message .= '<li>No application(s) selected.</li>';
					$message .= '<li>Outcomes have not been accepted.</li>';
					$message .= '<li>The application(s) outcome must be <i>Not HEQSF-aligned and Re-categorised to Category C</i>.</li>';
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
