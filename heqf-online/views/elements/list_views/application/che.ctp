<?php
	$button_institution = $this->Form->button('Return to institution', array('value' => 'return_inst', 'name' => 'action', 'class' => 'dialogButton'));
	$button_checklist = $this->Form->button('Assign to checklister', array('value' => 'assign_checklister', 'name' => 'action', 'class' => 'dialogButton'));
	$button_evaluate = $this->Form->button('Assign to evaluator', array('value' => 'assign_evaluator', 'name' => 'action', 'class' => 'dialogButton'));
	$button_review = $this->Form->button('Assign to reviewer', array('value' => 'assign_reviewer', 'name' => 'action', 'class' => 'dialogButton'));
	$button_heqc_meeting = $this->Form->button('Assign to HEQC meeting', array('value' => 'assign_heqc_meeting', 'name' => 'action', 'class' => 'dialogButton'));
	$button_review_return = $this->Form->button('Return reviewed applications', array('value' => 'return_inst_review', 'name' => 'action', 'class' => 'dialogButton'));
	$button_inst_representation = $this->Form->button('Return for Representation', array('value' => 'return_for_representation', 'name' => 'action', 'class' => 'dialogButton'));
	$button_inst_deferral = $this->Form->button('Return for Deferral', array('value' => 'return_for_deferral', 'name' => 'action', 'class' => 'dialogButton'));
	$button_reviewer_representation = $this->Form->button('Assign Representation(s) to reviewer', array('value' => 'assign_representation_reviewer', 'name' => 'action', 'class' => 'dialogButton'));
	$button_reviewer_deferral = $this->Form->button('Assign Deferral(s) to reviewer', array('value' => 'assign_deferral_reviewer', 'name' => 'action', 'class' => 'dialogButton'));
	$button_proc_heqc_meeting = $this->Form->button('Assign to proceeding(s) to HEQC meeting', array('value' => 'assign_proc_heqc_meeting', 'name' => 'action', 'class' => 'dialogButton'));
	$button_recategorise = $this->Form->button('Recategorise to C', array('value' => 're_categorise_to_c', 'name' => 'action', 'class' => 'dialogButton'));
	

?>


<div class="listViews">
<h2><?php __('List of Applications');?> - <?php echo (Auth::checkRole('che_admin') ? 'CHE administrator' : 'CHE user')?></h2>
</div>

<?php
	echo (isset($applicationsInformation) && !empty($applicationsInformation)) ? $this->element('information/application_info') : '';


	echo $this->element('search/application_search');
	
	$totalDispplay = $this->Paginator->counter(array(
		'format' => 'Total: %current% of %count% application(s)'
	));

	echo $this->Html->div('total', $totalDispplay);
?>
<div class="list_view_table">
	<table>
		<thead>
			<tr class="tableHead">
				<td></td>
				<td style="white-space: nowrap;">
					<?php
						echo '<a id="searchLink" style="float:right" href="#">Advanced search</a>';
					?>
				</td>
				<td colspan="12" style="border:none;">
					<div class="search actions ui-buttonset">
						<?php
							echo $this->Form->text('Process.search.basic', array('placeholder' => 'Search'));
							echo $this->Form->button('Go', array('id' => 'searchButton', 'value' => 'search', 'class' => 'ui-button ui-widget ui-state-default ui-button-text-only ui-corner-left ui-corner-right'));
						?>
					</div>
				</td>
			</tr>
			<tr class="tableHead">
				<td style="width:16px;text-align:center;color:#8C8B8B;font-size:12px;">
					<?php
						echo $this->Form->label('submitAll', 'All:');
						echo $this->Form->checkbox("submitAll");
					?>
				</td>
				<td colspan="14">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if(count($list)){
									if($this->AuthLinks->checkPermission('admin', 'application', 'process')) {
										echo $button_institution;
										echo $button_checklist;
										echo $button_evaluate;
										echo $button_review;
										echo $button_heqc_meeting;
										echo $button_review_return;
										echo $button_inst_representation;
										echo $button_inst_deferral;
										echo $button_reviewer_representation;
										echo $button_reviewer_deferral;
										echo $button_proc_heqc_meeting;
										echo $button_recategorise;
									}
								}
							?>
						</div>
					</div>
				</td>
			</tr>
			<tr>
					<th></th>
					<th><?php echo $this->Paginator->sort('Institution', 'Institution.hei_name') ?></th>
					<?php /*?><th><?php echo $this->Paginator->sort('Ref', 'HeqfQualification.qualification_reference_no') ?></th><?php */?>
					<th><?php echo $this->Paginator->sort('Qualification title (Section 1)', 'HeqfQualification.s1_qualification_title') ?></th>
					<th><?php echo $this->Paginator->sort('Qualification title (Section 2)', 'HeqfQualification.qualification_title') ?></th>
					<th><?php echo $this->Paginator->sort('Original section 2 title', 'HeqfQualification.qualification_title_orig') ?></th>
					<th><?php echo $this->Paginator->sort('Submission date', 'Application.submission_date') ?></th>
					<th><?php echo $this->Paginator->sort('Submission user', 'SubmitUser.email_address') ?></th>
					<?php /*?><th><?php echo $this->Paginator->sort('Checklist status', 'Application.checklisting_status_id') ?></th>
					<th><?php echo $this->Paginator->sort('Checklisted on date', 'Application.checklisting_date') ?></th>
					<th><?php echo $this->Paginator->sort('Evaluation status', 'Application.evaluation_status_id') ?></th>
					<th><?php echo $this->Paginator->sort('Evaluation date', 'Application.evaluation_date') ?></th>
					<th><?php echo $this->Paginator->sort('Review status', 'Application.review_status_id') ?></th>
					<th><?php echo $this->Paginator->sort('Review date', 'Application.review_date') ?></th>
					<?php
					*/
					?>
					<th><?php echo $this->Paginator->sort('Proposed HEQSF category', 'Application.lkp_heqf_align_id') ?></th>
					<th><?php echo $this->Paginator->sort('Institution alignment category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>
					<th><?php echo $this->Paginator->sort('Application status', 'Application.application_status') ?></th>
					<th><?php echo $this->Paginator->sort('User assigned to', 'User.last_name') ?></th>
					<th>HEQC Meeting</th>
					<th>Proceeding Document(s)</th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>
		</thead>
		<?php if(count($list)) { ?>
		<tbody id="tableBody">
		<?php
		$list = $this->Heqf->combineApplicationData($list); //combineApplicationWithEvaluation
		$i = 0;
		foreach ($list as $key => $application) {
			$applicationStatus = $this->Status->getStatus($application['Application']);
			$class = $this->Status->getClass($applicationStatus) . '';
			if ($i++ % 2 == 0) {
				$class .= '_altrow';
			}

				$rowspan = isset($application['evaluationHistory']) ? count($application['evaluationHistory']) + 2 : '1';
				$rowspan = !empty($application['ReviewUser']) ? $rowspan + 2 : $rowspan;
		?>
		<tr <?php echo 'class="'.$class.'"';?>>
			<td style="width: 16px">
				<?php
					$checked = isset($this->data['Process']['selected']) && is_array($this->data['Process']['selected']) && in_array($application['Application']['id'], $this->data['Process']['selected']);
					echo $this->Form->input(
						'Process.selected.'.$key,
						array(
							'value'=>$application['Application']['id'],
							'label' => '',
							'type' => 'checkbox',
							'checked' => $checked,
						)
					);
				?>
			</td>
			<td><?php echo $application['Institution']['hei_name'] . ' (' .$application['Institution']['hei_code']. ')' ?></td>
			<?php 
				$QualRefNo = '';
				$QualRefNo = !empty($application['HeqfQualification']['qualification_reference_no']) ? $application['HeqfQualification']['qualification_reference_no'] : $application['HeqfQualification']['s1_qualification_reference_no'];
				$QualRefNo = (!empty($QualRefNo)) ? ' (' . $QualRefNo . ')' : '';
				
			/*?><td><?php echo !empty($application['HeqfQualification']['qualification_reference_no']) ? $application['HeqfQualification']['qualification_reference_no'] : $application['HeqfQualification']['s1_qualification_reference_no'] ?></td><?php */?>
			<td><?php echo !empty($application['HeqfQualification']['s1_qualification_title']) ? $application['HeqfQualification']['s1_qualification_title'] . $QualRefNo : '' ?></td>
			<td><?php echo !empty($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] . $QualRefNo : '' ?></td>
			<td><?php echo !empty($application['HeqfQualification']['qualification_title_orig']) ? $application['HeqfQualification']['qualification_title_orig'] . $QualRefNo : '' ?></td>
			<td>
				<?php
					if($application['Application']['submission_date'] !== '1970-01-01') {
						echo $application['Application']['submission_date'];
					}
					else {
						echo 'Not submitted';
					}
				?>
			</td>
			<td>
				<?php
					if($application['SubmitUser']['email_address'] > '') {
						echo $application['SubmitUser']['email_address'];
					}
					else {
						echo '&nbsp;';
					}
				?>
			</td>
			<?php
			/*
			?>
			<td><?php echo $application['ChecklistingStatus']['description'] ?></td>
			<td>
				<?php
					if($application['Application']['checklisting_date'] !== '1970-01-01') {
						echo $application['Application']['checklisting_date'];
					}
					else {
						echo '&nbsp';
					}
				?>
			</td>
			<td><?php echo $application['EvaluationStatus']['description'] ?></td>
			<td>
				<?php
					if($application['Application']['evaluation_date'] !== '1970-01-01') {
						echo $application['Application']['evaluation_date'];
					}
					else {
						echo '&nbsp;';
					}
				?>
			</td>
			<td><?php echo $application['ReviewStatus']['description'] ?></td>
			<td>
				<?php
					if($application['Application']['review_date'] !== '1970-01-01') {
						echo $application['Application']['review_date'];
					}
					else {
						echo '&nbsp;';
					}
				?>
			</td>
			<?php
			*/
			?>
			<td>
				<?php
					echo ($application['Application']['lkp_heqf_align_id']) ? $application['Application']['lkp_heqf_align_id'] : '';
				?>
			</td>
			<td>
				<?php
					echo $application['HeqfQualification']['s1_lkp_heqf_align_id'];
				?>
			</td>
			<td>
				<?php
					if($applicationStatus == 'New' && $rowError) {
						$applicationStatus = 'Needs correction';
					}
					elseif($applicationStatus == 'New' && !$rowError){
						$applicationStatus = 'Ready for submission';
					}

					echo $applicationStatus;
				?>
			</td>
			<td>
				<?php 
					$displayName = $application['User']['first_name'] . ' ' . $application['User']['last_name'];
					$displayEmail = (!empty($application['User']['email_address'])) ? '('.$application['User']['email_address'].')' : '';
					$display = $displayName . '<br />' . $displayEmail;
					if($displayName == ' ' && empty($displayEmail)){
						$display = '&nbsp;';					
					}
					echo $display;
				?>
			</td>
			<td>
				<?php 
					echo isset($HeqcMeeting[$application['Application']['heqc_meeting_id']]) ? $HeqcMeeting[$application['Application']['heqc_meeting_id']] : '&nbsp';
				?>
			</td>
			<td>
				<?php
					if (!empty($application['submittedProceedingDocs'])){
						echo '<ul>';
							foreach ($application['submittedProceedingDocs'] as $key => $doc) {
								$submittedProcType = $this->Heqf->getProceedingTypeDesc($doc['proceeding_type_id']);
								?>
								<li>
								<?php 
									$this->Heqf->showProceedingFile($doc['proc_document'], 'View ' . $submittedProcType . ' ' . $doc['proc_submission_date'], $application['Institution']['hei_code']); ?>
								</li>
								<?php

							}
						echo '</ul>';
					}
				?>
			</td>
			<td class="actions bulkButtons">
				<?php
					if($this->AuthLinks->checkPermission('read', 'application', 'process')) {
						echo $this->Html->link(__('View', true), array('controller' => 'process', 'action' => 'view', 'process-slug' => 'application', 'id' => $application['Application']['id']));
					}
				?>
				<br>
				<?php 
					
					if($this->AuthLinks->checkPermission('update', 'application', 'process') && $applicationStatus != "New") {
						echo $this->Html->link(
							__('Make Corrections', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'section-2-correction',
								'id' => $application['Application']['id']
							));						
					}
				?>
				<br>
				<?php 
					$allowedStatusArr = array('In evaluation', 'In review', 'Representation (Reviewer)', 'Deferral (Reviewer)');
					if($this->AuthLinks->checkPermission('update', 'edit-due-date', 'process') && in_array($applicationStatus, $allowedStatusArr)) {
						echo $this->Html->link(
							__('Edit due date', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'edit-due-date',
								'id' => $application['Application']['id']
							));						
					}
				?>
			</td>
		</tr>
		<?php
			if(!empty($application['Application']['checklisting_comments'])){
		?>
			<tr <?php echo 'class="'.$class.' comments"';?>>
				<td>
				</td>
				<td colspan="2">
					<b>Checklister comments:</b>
				</td>
				<td colspan="14">
					<?php
						echo $application['Application']['checklisting_comments'];
					?>
				</td>
			</tr>
		<?php
			}
			if(isset($application['evaluationHistory'])){
		?>
			<tr <?php echo 'class="'.$class.' comments"';?>>
				<td>
				</td>
				<td colspan="1">
					<b>Evaluator</b>
				</td>
				<td colspan="3">
					<b>Recommended Evaluation Outcome</b>
				</td>
				<td colspan="1">
					<b>Evaluation Date</b>
				</td>
				<td colspan="10">
					<b>Evaluation Comments</b>
				</td>
				<?php
					foreach ($application['evaluationHistory'] as $evaluation) {
						$evaluation_outcome = isset($AllOutcome[$evaluation['eval_lkp_outcome_id']]) ? $AllOutcome[$evaluation['eval_lkp_outcome_id']] : '';
						$evaluationCommentsCatA = !empty($evaluation['eval_comments']) ? $evaluation['eval_comments'] : 'None';
						$evaluationCommentsCatB = (!empty($evaluation['eval_outcome_comment']) || !empty($evaluation['request_second_evaluation_comment'])) ? $evaluation['eval_outcome_comment'] . ' ' . $evaluation['request_second_evaluation_comment'] : 'None';
						if($this->Heqf->isCatB($application)){
							$comments = $evaluationCommentsCatB;
						}else{
							$comments = $evaluationCommentsCatA;
						}
						echo '<tr class = "'.$class.' comments">';
						echo '<td></td>';
							echo '<td colspan="1">'  . $evaluation['first_name'] . ' ' . $evaluation['last_name'] . '</td>';
							echo '<td colspan="3">' . $evaluation_outcome . '</td>';
							echo '<td colspan="1">' . $evaluation['eval_date'] . '</td>';
							echo '<td colspan="10">' . $comments . '</td>';
						echo '</tr>';
					}
					/*foreach ($application['evaluationHistory'] as $evaluation) {
						$evaluation_outcome = isset($AllOutcome[$evaluation['eval_lkp_outcome_id']]) ? $AllOutcome[$evaluation['eval_lkp_outcome_id']] : '';
						$evaluationCommentsCatA = !empty($evaluation['eval_comments']) ? $evaluation['eval_comments'] : 'None';						
						$catBCommentArr = array($evaluation['s3_curriculum_comment'], $evaluation['s3_module_comment'], $evaluation['s3_assessment_comment'], $evaluation['s3_learning_activities_comment'],$evaluation['s3_workplace_comment']);
						$evaluationCommentsCatB = $this->Heqf->buildCatBHistory($catBCommentArr);
						if($this->Heqf->isCatB($application)){
							$comments = $evaluationCommentsCatB;
						}else{
							$comments = $evaluationCommentsCatA;
						}
						echo '<tr class = "'.$class.' comments">';
						echo '<td></td>';
							echo '<td colspan="1">'  . $evaluation['first_name'] . ' ' . $evaluation['last_name'] . '</td>';
							echo '<td colspan="3">' . $evaluation_outcome . '</td>';
							echo '<td colspan="1">' . $evaluation['eval_date'] . '</td>';
							echo '<td colspan="10">' . $comments . '</td>';
						echo '</tr>';
					}*/

				 ?>
			</tr>
		<?php			
			}
		?>
		
		<?php
			if(!empty($application['ReviewUser']) && $application['Application']['review_status_id'] == 'Reviewed'){
			$review_outcome = isset($AllOutcome[$application['Application']['review_outcome_id']]) ? $AllOutcome[$application['Application']['review_outcome_id']] : '';
		?>
				<tr <?php echo 'class="'.$class.' comments"';?>>
					<td></td>
					<td colspan="1">
						<b>Reviewer</b>
					</td>
					<td colspan="3">
						<b>Review Outcome</b>
					</td>
					<td colspan="1">
						<b>Review Date</b>
					</td>
					<td colspan="10">
						<b>Review Comments</b>
					</td>
				</tr>
				<tr <?php echo 'class="'.$class.' comments"';?>>
					<td></td>
					<td colspan="1"><?php echo (!empty($application['ReviewUser']['id'])) ? $application['ReviewUser']['name'] : 'No reviewer assigned'; ?></td>
					<td colspan="3"><?php echo $review_outcome; ?></td>
					<td colspan="1"><?php echo $application['Application']['review_date']; ?></td>
					<td colspan="10"><?php echo $application['Application']['review_comments']; ?></td>
				</tr>
			
		<?php			
			}
		?>

		<?php if (isset($application['proceedingHistory']) && !empty($application['proceedingHistory'])) :?>
			<tr <?php echo 'class="'.$class.' comments"';?>>
					<td></td>
					<td colspan="1">
						<b>Reviewer(Proceeding)</b>
					</td>
					<td colspan="3">
						<b>Review Outcome</b>
					</td>
					<td colspan="1">
						<b>Review Date</b>
					</td>
					<td colspan="1">
						<b>HEQC meeting date</b>
					</td>
					<td colspan="2">
						<b>Proc Document</b>
					</td>
					<td colspan="9">
						<b>Review Comments</b>
					</td>
					<?php foreach ($application['proceedingHistory'] as $proceeding) {
						$proc_outcome = isset($AllOutcome[$proceeding['proc_lkp_outcome_id']]) ? $AllOutcome[$proceeding['proc_lkp_outcome_id']] : '';
						$procHeqcMeeting = isset($proceeding['date']) && !empty($proceeding['date']) ? $proceeding['date'] : '';
						$procType = $this->Heqf->getProceedingTypeDesc($proceeding['proceeding_type_id']);
						echo '<tr class = "'.$class.' comments">';
						echo '<td></td>';
							echo '<td colspan="1">'  . $proceeding['first_name'] . ' ' . $proceeding['last_name'] . '</td>';
							echo '<td colspan="3">' . $proc_outcome . '</td>';
							echo '<td colspan="1">' . $proceeding['proc_date'] . '</td>';
							echo '<td colspan="1">' . $procHeqcMeeting . '</td>';
							?>
							<td colspan="2"> <?php $this->Heqf->showProceedingFile($proceeding['proc_document'], 'View ' . $procType, $application['Institution']['hei_code']) ?></td>
							<?php
							echo '<td colspan="9">' . $proceeding['proc_comments'] . '</td>';
						echo '</tr>';
					}
					?>
			</tr>
		<?php endif;?>
	<?php } ?>
		</tbody>

		<tfoot>
			<tr class="tableHead">
				<td>
				</td>
				<td style="border:none;" colspan="13">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if($this->AuthLinks->checkPermission('admin', 'application', 'process')) {
									echo $button_institution;
									echo $button_checklist;
									echo $button_evaluate;
									echo $button_review;
									echo $button_heqc_meeting;
									echo $button_review_return;
									echo $button_inst_representation;
									echo $button_inst_deferral;
									echo $button_reviewer_representation;
									echo $button_reviewer_deferral;
									echo $button_proc_heqc_meeting;
									echo $button_recategorise;
								}
							?>
						</div>
					</div>
				</td>
			</tr>
		</tfoot>
	<?php
	} else { 		
		$message = 'There are no applications available.';
		if (!empty($this->data['Process']['advancedSearch'])) {
			$message = 'Your search criteria found no applications.';
		}
	?>
		<p><?php echo $message; ?></p>
	<?php } ?>
	</table>
</div>
	<?php echo $this->element('paging', array('plugin' => 'octoplus', 'extraParams' => array('process-slug'))); ?>
