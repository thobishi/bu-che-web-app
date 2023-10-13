<div class="dashboard">
<?php
	echo $this->element('reports/header');
	$this->set('title_for_layout', 'HEQSF alignment applications');
?>
<h2>HEQSF alignment applications</h2>
<?php
	echo '<div style="clear:both;"></div>';
	echo $this->element('search/report_filter', array(
			'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
			'model' => $report['model'],
			'advancedOnly' => true,
			'searchText' => 'Filter ' . strtolower($report['name']),
			'clearSearch' => false
		)
	);

	if (!empty($reportData)) {
		$totalDisplay = $this->Paginator->counter(array(
			'format' => 'Total: %current% of %count% active application(s)'
		));
		echo $this->Html->div('total', $totalDisplay);
	}
?>
</div>
<?php if (!empty($reportData)) { 	
		$reportData = $this->Heqf->combineApplicationData($reportData);
?>
	<div class="list_view_table">	
		<table>
			<thead>
				<tr class="tableHead">
						<th><?php echo $this->Paginator->sort('Institution', 'Institution.hei_name') ?></th>
						<th>Status</th>
						<th><?php echo $this->Paginator->sort('User assigned to', 'User.last_name') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification reference number', 'HeqfQualification.s1_qualification_reference_no') ?></th>
						<th><?php echo $this->Paginator->sort('HEQSF reference number', 'HeqfQualification.heqf_reference_no') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification title (Section 1)', 'HeqfQualification.s1_qualification_title') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification title (Section 2)', 'HeqfQualification.qualification_title') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification title (Section 2 original)', 'HeqfQualification.qualification_title_orig') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification title abbreviation (Section 1)', 'HeqfQualification.s1_qualification_title_short') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification title abbreviation (Section 2)', 'HeqfQualification.qualification_title_short') ?></th>
						<th>Proceeding Document(s)</th>
						<th><?php echo $this->Paginator->sort('CESM', 'HeqfQualification.lkp_cesm1_code_id') ?></th>
						<th><?php echo $this->Paginator->sort('NQF', 'HeqfQualification.lkp_nqf_level_id') ?></th>
						<th><?php echo $this->Paginator->sort('Total credits', 'HeqfQualification.credits_total') ?></th>
						<th><?php echo $this->Paginator->sort('Qualification type',
						'HeqfQualification.lkp_qualification_type_id') ?></th>
						<th><?php echo $this->Paginator->sort('CHE alignment Category', 'Application.lkp_heqf_align_id') ?></th>
						<th><?php echo $this->Paginator->sort('Institution alignment Category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>
						<th><?php echo $this->Paginator->sort('Designator', 'HeqfQualification.lkp_designator_id') ?></th>
						<th><?php echo $this->Paginator->sort('Mode of delivery', 'HeqfQualification.lkp_delivery_mode_id') ?></th>
						<th><?php echo $this->Paginator->sort('Professional Classification', 'HeqfQualification.lkp_professional_class_id') ?></th>
						<th><?php echo $this->Paginator->sort('Submission date', 'Application.submission_date') ?></th>
						<th><?php echo $this->Paginator->sort('Checklister name', 'Application.checklisting_user_id') ?></th>
						<th><?php echo $this->Paginator->sort('Checklisting date', 'Application.checklisting_date') ?></th>
						<!-- <th><?php //echo $this->Paginator->sort('Evaluator name', 'Application.evaluation_user_id') ?></th>
						<th><?php //echo $this->Paginator->sort('Evaluation date', 'Application.evaluation_date') ?></th>
						<th>Evaluation comments</th> -->
						<th>Edited evaluation comments</th>
						<th><?php echo $this->Paginator->sort('Reviewer name', 'Application.review_user_id') ?></th>
						<th><?php echo $this->Paginator->sort('Review date', 'Application.review_date') ?></th>
						<th>Review history</th>
						<th><?php echo $this->Paginator->sort('Outcome', 'Application.lkp_outcome_id') ?></th>
						<th><?php echo $this->Paginator->sort('HEQC Meeting', 'HeqcMeeting.date') ?></th>
						
						<th><?php echo $this->Paginator->sort('Outcome approval date', 'Application.outcome_approval_date') ?></th>
						<th><?php echo $this->Paginator->sort('Outcome accepted', 'Application.outcome_accepted') ?></th>
						<th><?php echo $this->Paginator->sort('Institution notified', 'Application.notified') ?></th>
						<th><?php echo $this->Paginator->sort('Archive date', 'Application.archive_date') ?></th>
						<th><?php echo $this->Paginator->sort('Archived by', 'Application.archived_by') ?></th>
						<th>Categoy A to B</th>
						<th>Categoy B to C</th>
						<th>Categoy A to C</th>
				</tr>
			</thead>
			<tbody id="tableBody">
			<?php
			$i = 0;
			foreach ($reportData as $key => $application) {
				$class = '';
				if ($i++ % 2 == 0) {
					$class = 'altrow';
				}
				$rowspan = isset($application['evaluationHistory']) ? count($application['evaluationHistory']) + 2 : '1';

				$rowspan = (!empty($application['ReviewUser']) && $application['Application']['review_status_id'] == 'Reviewed') ? $rowspan + 2 : $rowspan;
				
				$rowspan = !empty($application['proceedingHistory']) ? $rowspan + 2 : $rowspan;
			?>
			<tr <?php echo 'class="' . $class . '"';?>>
				<td <?php echo 'rowspan= "'. $rowspan .'"' ?> ><?php echo $application['Institution']['hei_name'] . ' (' . $application['Institution']['hei_code'] . ')'; ?></td>
				<td>
					<?php
						$applicationStatus = $this->Status->getStatus($application['Application']);
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
				<td><?php echo $application['HeqfQualification']['s1_qualification_reference_no']; ?></td>
				<td><?php echo $application['HeqfQualification']['heqf_reference_no']; ?></td>
				<td><?php echo $application['HeqfQualification']['s1_qualification_title']; ?></td>
				<td><?php echo $application['HeqfQualification']['qualification_title']; ?></td>
				<td><?php echo $application['HeqfQualification']['qualification_title_orig']; ?></td>
				<td><?php echo $application['HeqfQualification']['s1_qualification_title_short']; ?></td>
				<td><?php echo $application['HeqfQualification']['qualification_title_short']; ?></td>
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
				<td>
					<?php
						$cesms = $this->Heqf->reportMultiple($application['HeqfQualification']['lkp_cesm1_code_id'], $CesmCode);
						echo $cesms;
					?>
				</td>
				<td><?php echo (isset($NqfLevel[$application['HeqfQualification']['lkp_nqf_level_id']])) ? $NqfLevel[$application['HeqfQualification']['lkp_nqf_level_id']] : '&nbsp;'; ?></td>
				<td><?php echo $application['HeqfQualification']['credits_total']; ?></td>
				<td><?php echo (isset($QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']])) ? $QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']] : '&nbsp;'; ?></td>
				<td><?php echo (isset($AppHeqfAlign[$application['Application']['lkp_heqf_align_id']])) ? $AppHeqfAlign[$application['Application']['lkp_heqf_align_id']] : '&nbsp;'; ?></td>
				<td><?php echo (isset($AppHeqfAlign[$application['HeqfQualification']['s1_lkp_heqf_align_id']])) ? $AppHeqfAlign[$application['HeqfQualification']['s1_lkp_heqf_align_id']] : '&nbsp;'; ?></td>
				<td><?php echo (isset($Designator[$application['HeqfQualification']['lkp_designator_id']])) ? $Designator[$application['HeqfQualification']['lkp_designator_id']] : '&nbsp;'; ?></td>
				<td><?php echo (isset($DeliveryMode[$application['HeqfQualification']['lkp_delivery_mode_id']])) ? $DeliveryMode[$application['HeqfQualification']['lkp_delivery_mode_id']] : '&nbsp;'; ?></td>
				<td><?php echo (isset($ProfessionalClass[$application['HeqfQualification']['lkp_professional_class_id']])) ? $ProfessionalClass[$application['HeqfQualification']['lkp_professional_class_id']] : '&nbsp;'; ?></td>
				<td><?php echo ($application['Application']['submission_date'] != '1970-01-01') ? $application['Application']['submission_date'] : 'Not submitted'; ?></td>
				<td><?php echo (!empty($application['ChecklistUser']['id'])) ? $application['ChecklistUser']['first_name'] . ' ' . $application['ChecklistUser']['last_name'] : 'No checklister assigned'; ?></td>
				<td><?php echo ($application['Application']['checklisting_date'] != '1970-01-01') ? $application['Application']['checklisting_date'] : 'Not checklisted'; ?></td>
				<!-- <td><?php //echo (!empty($application['EvalUser']['id'])) ? $application['EvalUser']['first_name'] . ' ' . $application['EvalUser']['last_name'] : 'No evaluator assigned'; ?></td>
				<td><?php //echo ($application['Application']['evaluation_date'] != '1970-01-01') ? $application['Application']['evaluation_date'] : 'Not evaluated'; ?></td>
				<td><?php //echo (!empty($application['Application']['evaluation_comments'])) ? nl2br($application['Application']['evaluation_comments']) : ''; ?></td> -->
				<td><?php echo (!empty($application['Application']['edited_evaluation_comments'])) ? nl2br($application['Application']['edited_evaluation_comments']) : ''; ?></td>
				<td><?php echo (!empty($application['ReviewUser']['id'])) ? $application['ReviewUser']['first_name'] . ' ' . $application['ReviewUser']['last_name'] : 'No reviewer assigned'; ?></td>
				<td><?php echo ($application['Application']['review_date'] != '1970-01-01') ? $application['Application']['review_date'] : 'Not reviewed'; ?></td>
				<td>
					<?php
						echo str_replace('_|_', '<br /><br />', $application['Application']['review_history']);
					?>
				</td>
				<td><?php echo (isset($AllOutcome[$application['Application']['lkp_outcome_id']])) ? $AllOutcome[$application['Application']['lkp_outcome_id']] : '&nbsp;'; ?></td>
				<td>
					<?php 
						echo isset($HeqcMeeting[$application['Application']['heqc_meeting_id']]) ? $HeqcMeeting[$application['Application']['heqc_meeting_id']] : '&nbsp';
					?>
				</td>
				
				<td><?php echo ($application['Application']['outcome_approval_date'] != '1970-01-01') ? $application['Application']['outcome_approval_date'] : '&nbsp;'; ?></td>
				<td><?php echo ($application['Application']['outcome_accepted'] == '1') ? 'Accepted' : '&nbsp;'; ?></td>
				<td><?php echo ($application['Application']['notified'] == '1') ? 'Notified' : '&nbsp;'; ?></td>
				<td><?php echo $application['Application']['archive_date']; ?></td>
				<td><?php echo $application['Application']['archived_by']; ?></td>
				<td><?php echo ($application['HeqfQualification']['catg_A_to_B_ind'] != 0) ? 'Yes' : '&nbsp;' ; ?></td>
				<td><?php echo ($application['HeqfQualification']['catg_B_to_C_ind'] != 0) ? 'Yes' : '&nbsp;' ; ?></td>				
				<td><?php echo ($application['HeqfQualification']['catg_A_to_C_ind'] != 0) ? 'Yes' : '&nbsp;' ; ?></td>
			</tr>

		<?php
			
			if(isset($application['evaluationHistory'])){
		?>
			<tr <?php echo 'class="'.$class.' comments"';?>>
				<td colspan="1">
					<b>Evaluator</b>
				</td>
				<td colspan="3">
					<b>Evaluation outcome</b>
				</td>
				<td colspan="1">
					<b>Evaluation Date</b>
				</td>
				<td colspan="31">
					<b>Evaluator Comments</b>
				</td>
			</tr>
			<?php					
				foreach ($application['evaluationHistory'] as $evaluation) {
					$evaluation_outcome = isset($AllOutcome[$evaluation['eval_lkp_outcome_id']]) ? $AllOutcome[$evaluation['eval_lkp_outcome_id']] : '';
					$evaluationCommentsCatA = !empty($evaluation['eval_comments']) ? $evaluation['eval_comments'] : 'None';				
					$evaluationCommentsCatB = (!empty($evaluation['eval_outcome_comment']) || !empty($evaluation['request_second_evaluation_comment'])) ? $evaluation['eval_outcome_comment'] . ' ' . $evaluation['request_second_evaluation_comment'] : 'None';
					if($this->Heqf->isCatB($application) && empty($evaluation['eval_comments'])){
						$comments = $evaluationCommentsCatB;
					}else{
						$comments = $evaluationCommentsCatA;
					}
					echo '<tr class = "'.$class.' comments">';
					
						echo '<td colspan="1">'  . $evaluation['first_name'] . ' ' . $evaluation['last_name'] . '</td>';
						echo '<td colspan="3">' . $evaluation_outcome . '</td>';
						echo '<td colspan="1">' . $evaluation['eval_date'] . '</td>';
						echo '<td colspan="31">' . $comments . '</td>';
					echo '</tr>';
				}

			 ?>
			
		<?php			
			}
		?>

		<?php			
			if(!empty($application['ReviewUser']) && $application['Application']['review_status_id'] == 'Reviewed'){
			$review_outcome = isset($AllOutcome[$application['Application']['review_outcome_id']]) ? $AllOutcome[$application['Application']['review_outcome_id']] : '';
		?>
				<tr <?php echo 'class="'.$class.' comments"';?>>
					<td colspan="1">
						<b>Reviewer</b>
					</td>
					<td colspan="3">
						<b>Review Outcome</b>
					</td>
					<td colspan="1">
						<b>Review Date</b>
					</td>
					<td colspan="31">
						<b>Review Comments</b>
					</td>
				</tr>
				<tr <?php echo 'class="'.$class.' comments"';?>>
					<td colspan="1"><?php echo (!empty($application['ReviewUser']['id'])) ? $application['ReviewUser']['name'] : 'No reviewer assigned'; ?></td>
					<td colspan="3"><?php echo $review_outcome; ?></td>
					<td colspan="1"><?php echo $application['Application']['review_date']; ?></td>
					<td colspan="31"><?php echo $application['Application']['review_comments']; ?></td>
				</tr>
			
		<?php			
			}
		?>
		<?php if (isset($application['proceedingHistory']) && !empty($application['proceedingHistory'])) :?>
			<tr <?php echo 'class="'.$class.' comments"';?>>
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
					<td colspan="29">
						<b>Review Comments</b>
					</td>
					<?php foreach ($application['proceedingHistory'] as $proceeding) {
						$proc_outcome = isset($AllOutcome[$proceeding['proc_lkp_outcome_id']]) ? $AllOutcome[$proceeding['proc_lkp_outcome_id']] : '';
						$procHeqcMeeting = isset($proceeding['date']) && !empty($proceeding['date']) ? $proceeding['date'] : '';
						$procType = $this->Heqf->getProceedingTypeDesc($proceeding['proceeding_type_id']);
						echo '<tr class = "'.$class.' comments">';
							echo '<td colspan="1">'  . $proceeding['first_name'] . ' ' . $proceeding['last_name'] . '</td>';
							echo '<td colspan="3">' . $proc_outcome . '</td>';
							echo '<td colspan="1">' . $proceeding['proc_date'] . '</td>';
							echo '<td colspan="1">' . $procHeqcMeeting . '</td>';
							?>
							<td colspan="2"> <?php $this->Heqf->showProceedingFile($proceeding['proc_document'], 'View ' . $procType, $application['Institution']['hei_code']) ?></td>
							<?php
							echo '<td colspan="29">' . $proceeding['proc_comments'] . '</td>';
						echo '</tr>';
					}
		?>
			</tr>
		<?php endif;?>

		<?php
			}
		?>
			</tbody>
		</table>
	</div>
	<?php echo $this->element('paging', array('plugin' => 'octoplus', 'extraParams' => array('process-slug'))); ?>
<?php } else { ?>
		<p>There is no data for this report.</p>
<?php }