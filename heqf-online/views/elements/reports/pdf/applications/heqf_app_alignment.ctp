<?php
	$this->set('title_for_layout', 'Report of HEQSF alignment applications');
	$this->set('filename', 'Report of HEQSF alignment applications');
	$this->setOption('orientation', 'Landscape');

	if(!empty($reportData)){
		$reportData = $this->Heqf->combineApplicationData($reportData);
?>
	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr class="tableHead">
					<th><?php echo 'Institution'; ?></th>
					<th><?php echo 'Status'; ?></th>
					<th><?php echo 'User assigned to'; ?></th>
					<th><?php echo 'Qualification reference number'; ?></th>
					<th><?php echo 'HEQSF reference number'; ?></th>
					<th><?php echo 'Qualification title (Section 1)'; ?></th>
					<th><?php echo 'Qualification title (Section 2)'; ?></th>
					<th><?php echo 'Qualification title (Section 2 original)'; ?></th>
					<th><?php echo 'Qualification title abbreviation (Section 1)'; ?></th>
					<th><?php echo 'Qualification title abbreviation (Section 2)'; ?></th>
					<th><?php echo 'CESM'; ?></th>
					<th><?php echo 'NQF'; ?></th>
					<th><?php echo 'Total credits'; ?></th>
					<th><?php echo 'Qualification type'; ?></th>
					<th><?php echo 'CHE alignment Category'; ?></th>
					<th><?php echo 'Institution alignment Category'; ?></th>
					<th><?php echo 'Designator'; ?></th>
					<th><?php echo 'Mode of delivery'; ?></th>
					<th><?php echo 'Professional Classification'; ?></th>
					<th><?php echo 'Submission date'; ?></th>
					<th><?php echo 'Checklister name'; ?></th>
					<th><?php echo 'Checklisting date'; ?></th>
					<!-- <th><?php //echo 'Evaluator name'; ?></th>
					<th><?php //echo 'Evaluation date'; ?></th>
					<th><?php //echo 'Evaluation comments'; ?></th> -->
					<th><?php echo 'Edited evaluation comments'; ?></th>
					<th><?php echo 'Reviewer name'; ?></th>
					<th><?php echo 'Review date'; ?></th>
					<th><?php echo 'Review history'; ?></th>
					<th><?php echo 'Outcome'; ?></th>
					<th><?php echo 'HEQC Meeting'; ?></th>
					
					<th><?php echo 'Outcome approval date'; ?></th>
					<th><?php echo 'Outcome accepted'; ?></th>
					<th><?php echo 'Institution notified'; ?></th>
					<th><?php echo 'Archive date';?></th>
					<th><?php echo 'Archived by'; ?></th>
					<th><?php echo 'Categoy A to B'; ?></th>
					<th><?php echo 'Categoy B to C'; ?></th>
					<th><?php echo 'Categoy A to C'; ?></th>					
			</tr>
		</thead>
		<tbody id="tableBody">
		<?php
		foreach ($reportData as $key => $application) {
			$rowspan = isset($application['evaluationHistory']) ? count($application['evaluationHistory']) + 2 : '1';
			$rowspan = (!empty($application['ReviewUser']) && $application['Application']['review_status_id'] == 'Reviewed') ? $rowspan + 2 : $rowspan;
			$rowspan = !empty($application['proceedingHistory']) ? $rowspan + 2 : $rowspan;
		?>
		<tr>
			<td <?php echo 'rowspan= "'. $rowspan .'"' ?> ><?php echo $application['Institution']['hei_name'] . ' (' .$application['Institution']['hei_code']. ')'; ?></td>
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
					$cesms = $this->Heqf->reportMultiple($application['HeqfQualification']['lkp_cesm1_code_id'], $CesmCode);
					echo $cesms;
				?>
			</td>
			<td><?php echo (isset($NqfLevel[$application['HeqfQualification']['lkp_nqf_level_id']])) ? $NqfLevel[$application['HeqfQualification']['lkp_nqf_level_id']] : '&nbsp;' ; ?></td>
			<td><?php echo $application['HeqfQualification']['credits_total']; ?></td>
			<td><?php echo (isset($QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']])) ? $QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']] : '&nbsp;' ; ?></td>
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
			<td><?php echo (isset($application['Application']['review_history'])) ? str_replace('_|_', "\n\r", $application['Application']['review_history']) : ''; ?></td>
			<td><?php echo (isset($AllOutcome[$application['Application']['lkp_outcome_id']])) ? $AllOutcome[$application['Application']['lkp_outcome_id']] : '&nbsp;'; ?></td>
			<td><?php echo (isset($application['HeqcMeeting']['date'])) ? $application['HeqcMeeting']['date'] : '&nbsp;'; ?></td>
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
			<tr>
				<td colspan="1">
					<b>Evaluator</b>
				</td>
				<td colspan="3">
					<b>Recommended Evaluation Outcome</b>
				</td>
				<td colspan="1">
					<b>Evaluation Date</b>
				</td>
				<td colspan="29">
					<b>Evaluation Comments</b>
				</td>
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
						echo '<tr>';
						
							echo '<td colspan="1">'  . $evaluation['first_name'] . ' ' . $evaluation['last_name'] . '</td>';
							echo '<td colspan="3">' . $evaluation_outcome . '</td>';
							echo '<td colspan="1">' . $evaluation['eval_date'] . '</td>';
							echo '<td colspan="29">' . $comments . '</td>';
						echo '</tr>';
					}

				 ?>
			</tr>
		<?php			
			}
		?>

		<?php
			
			if(!empty($application['ReviewUser']) && $application['Application']['review_status_id'] == 'Reviewed'){
			$review_outcome = isset($AllOutcome[$application['Application']['review_outcome_id']]) ? $AllOutcome[$application['Application']['review_outcome_id']] : '';
		?>
				<tr>
					<td colspan="1">
						<b>Reviewer</b>
					</td>
					<td colspan="3">
						<b>Review Outcome</b>
					</td>
					<td colspan="1">
						<b>Review Date</b>
					</td>
					<td colspan="30">
						<b>Review Comments</b>
					</td>
				</tr>
				<tr>
					<td colspan="1"><?php echo (!empty($application['ReviewUser']['id'])) ? $application['ReviewUser']['name'] : 'No reviewer assigned'; ?></td>
					<td colspan="3"><?php echo $review_outcome; ?></td>
					<td colspan="1"><?php echo $application['Application']['review_date']; ?></td>
					<td colspan="30"><?php echo $application['Application']['review_comments']; ?></td>
				</tr>
			
		<?php			
			}
		?>	

		<?php if (isset($application['proceedingHistory']) && !empty($application['proceedingHistory'])) :?>
				<tr>
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
					<td colspan="29">
						<b>Review Comments</b>
					</td>
					<?php foreach ($application['proceedingHistory'] as $proceeding) {
						$proc_outcome = isset($AllOutcome[$proceeding['proc_lkp_outcome_id']]) ? $AllOutcome[$proceeding['proc_lkp_outcome_id']] : '';
						$procHeqcMeeting = isset($proceeding['date']) && !empty($proceeding['date']) ? $proceeding['date'] : '';
						$procType = $this->Heqf->getProceedingTypeDesc($proceeding['proceeding_type_id']);
						echo '<tr>';
							echo '<td colspan="1">'  . $proceeding['first_name'] . ' ' . $proceeding['last_name'] . '</td>';
							echo '<td colspan="3">' . $proc_outcome . '</td>';
							echo '<td colspan="1">' . $proceeding['proc_date'] . '</td>';
							echo '<td colspan="1">' . $procHeqcMeeting . '</td>';
							echo '<td colspan="29">' . $proceeding['proc_comments'] . '</td>';
						echo '</tr>';
					}
		?>
			</tr>
		<?php endif;?>	
		
	<?php } ?>
		</tbody>
	</table>
	<?php }else{ ?>
		<p>There is no data for this report.</p>
	<?php } ?>