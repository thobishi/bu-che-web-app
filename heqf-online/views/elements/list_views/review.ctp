<div class="listViews">
<h2><?php __('List of Applications');?> - <?php echo (Auth::checkRole('reviewer') ? 'CHE reviewer' : '')?></h2>
</div>
<?php
	echo $this->element('search/application_review_search');
	$totalDisplay = $this->Paginator->counter(array(
		'format' => 'Total: %current% of %count% application(s)'
	));
	echo $this->Html->div('total', $totalDisplay);
?>
<div class="list_view_table">	
	<table>
		<thead>
			<tr class="tableHead">
				<td style="width:16px;text-align:center;color:#8C8B8B;font-size:12px;">
					<?php
						echo $this->Form->label('submitAll', 'All:');
						echo $this->Form->checkbox("submitAll");
					?>
				</td>
				<td colspan="17">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if(count($list)){
									if($this->AuthLinks->checkPermission('update', 'review', 'process')) {
										echo $this->Form->button('Mark as reviewed and return to administrator', array('value' => 'mark_reviewed', 'name' => 'action', 'class' => 'dialogButton'));
										echo $this->Form->button('Set application(s) as aligned', array('value' => 'set_review_outcome', 'name' => 'action', 'class' => 'dialogButton'));
										echo $this->Form->button('Return to administrator without reviewing', array('value' => 'return_without_review', 'name' => 'action', 'class' => 'dialogButton'));
									}
								}
								echo $html->link('Help - How to review', array('controller' => 'pages', 'action' => 'download_help', 'review'));
							?>
						</div>
					</div>
				</td>
				<td style="border:none;">
					<div class="search actions ui-buttonset">
						<?php
							echo $this->Form->text('Process.search.basic', array('placeholder' => 'Search'));
							echo $this->Form->button('Go', array('id' => 'searchButton', 'value' => 'search', 'class' => 'ui-button ui-widget ui-state-default ui-button-text-only ui-corner-left ui-corner-right'));
						?>
					</div>
					<?php
						echo '<a id="searchLink" style="float:right" href="#">Advanced search</a>';
					?>
				</td>
			</tr>
			<tr>
					<th rowspan="2"></th>
					<th rowspan="2"><?php echo $this->Paginator->sort('Institution', 'Institution.hei_name') ?></th>
					<th rowspan="2"><?php echo $this->Paginator->sort('Qualification name', 'HeqfQualification.s1_qualification_title') ?></th>
					<th rowspan="2"><?php echo $this->Paginator->sort('Qualification type', 'HeqfQualification.lkp_qualification_type_id') ?></th>
					<th rowspan="2"><?php echo $this->Paginator->sort('HEQSF ref', 'HeqfQualification.heqf_reference_no') ?></th>
					<th rowspan="2"><?php echo $this->Paginator->sort('CESM', 'HeqfQualification.lkp_cesm1_code_id') ?></th>
					<th rowspan="2"><?php echo $this->Paginator->sort('Institution alignment category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>
					<th rowspan="2">Evaluator name</th>
					<th rowspan="1" colspan="5"><?php echo 'Evaluator Questions'; ?></th>
					<th rowspan="2">Evaluation Outcome</th>
					<th rowspan="2"><?php echo $this->Paginator->sort('Review Outcome', 'Application.review_outcome_id') ?></th>

					<th rowspan="2">Proc type</th>
					<th rowspan="2">Proc Document</th>
					<th rowspan="2">Proc Outcome</th>

					<th rowspan="2" class="actions"><?php __('Actions');?></th>
			</tr>
			<tr>
				<th>Q1</th>
				<th>Q2</th>
				<th>Q3</th>
				<th>Q4</th>
				<th>Q5</th>
			</tr>
		</thead>
		<?php if(count($list)) { ?>
		<tbody id="tableBody">
		<?php
			$applicationIdArr = Set::extract('/Application/id', $list);
			$evaluationArr = $this->Heqf->evaluationHistory($applicationIdArr);
			$proceedingArr = $this->Heqf->getProceedingHistory($applicationIdArr);
			if(!empty($evaluationArr)){
				foreach ($list as $list_key => $application) {				
					foreach ($evaluationArr  as $eval_key => $evaluation) {
						if($application['Application']['id'] == $evaluation['Evaluation']['application_id']){
							$combineData = array_merge($evaluation['Evaluation'],$evaluation['EvalUser']);
							$list[$list_key]['evaluationHistory'][] = $combineData;
						}
					}

					foreach ($proceedingArr  as $proc_key => $proceeding) {
						if($application['Application']['id'] == $proceeding['Proceeding']['application_id']){
							$combineProc = array_merge($proceeding['Proceeding'],$proceeding['ProcUser']);
							$list[$list_key]['proceedingHistory'][] = $combineProc;
						}
					}
				}
			}
		
		$i = 0;
		
		foreach ($list as $key => $application) {

			$class = '';
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}

			$outcome = $application['Outcome']['outcome_desc'];
			$rowspan = !empty($application['evaluationHistory']) ? count($application['evaluationHistory']) : 1;
			$procRowSpan = !empty($application['proceedingHistory']) ? count($application['proceedingHistory']) : 1;

		?>
		<?php
			if (!empty($application['evaluationHistory'])) {
				foreach ($application['evaluationHistory'] as  $evalIndex => $evaluation) {
					if($evalIndex == 0) {
		?>
		<tr <?php echo 'class="'.$class.'"';?>>
			<td rowspan= <?php echo $rowspan; ?> style="width: 16px">
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
			
			<td rowspan= <?php echo $rowspan; ?> ><?php echo $application['Institution']['hei_name'] . ' (' .$application['Institution']['hei_code']. ')' ?></td>
			<td rowspan= <?php echo $rowspan; ?> ><?php echo !empty($application['HeqfQualification']['s1_qualification_title']) ? $application['HeqfQualification']['s1_qualification_title'] : '&nbsp;' ?></td>
			<td rowspan= <?php echo $rowspan; ?> ><?php echo isset($application['HeqfQualification']['QualificationType']['qualification_type_desc']) ? $application['HeqfQualification']['QualificationType']['qualification_type_desc'] : '&nbsp;' ?></td>			
			<td rowspan= <?php echo $rowspan; ?> ><?php echo (!empty($application['HeqfQualification']['heqf_reference_no'])) ? $application['HeqfQualification']['heqf_reference_no'] : '&nbsp;'  ?></td>
			<td rowspan= <?php echo $rowspan; ?> >
				<?php
						$cesms = $this->Heqf->reportMultiple($application['HeqfQualification']['lkp_cesm1_code_id'], $CesmCode);
						echo $cesms;
					?>
			</td>
			<td rowspan= <?php echo $rowspan; ?>><?php echo $application['HeqfQualification']['s1_lkp_heqf_align_id']; ?></td>
			
			<?php
				}
			?>	
				<td rowspan= <?php echo count($application['evaluationHistory']) > 0 ? 1 : $rowspan; ?> ><?php echo $evaluation['first_name'] . ' ' . $evaluation['last_name'] ?></td>
			<?php
				$evaluation_outcome = isset($AllOutcome[$evaluation['eval_lkp_outcome_id']]) ? $AllOutcome[$evaluation['eval_lkp_outcome_id']] : '';
				if ($this->Heqf->isCatB($application)) {
			?>
				<td><?php echo $evaluation['s3_curriculum_lkp_outcome_id']; ?></td>
				<td><?php echo $evaluation['s3_modules_lkp_outcome_id']; ?></td>
				<td><?php echo $evaluation['s3_assessment_lkp_outcome_id']; ?></td>
				<td><?php echo $evaluation['s3_learning_activities_lkp_outcome_id']; ?></td>
				<td><?php echo $evaluation['s3_workplace_explained_lkp_outcome_id']; ?></td>
			<?php
				} else {
			?>
				<td><?php echo $evaluation['application_correctly_categorised']; ?></td>
				<td><?php echo $evaluation['qualification_type_aligned']; ?></td>
				<td><?php echo $evaluation['nqf_level_aligned']; ?></td>
				<td><?php echo $evaluation['total_credits_aligned']; ?></td>
				<td><?php echo $evaluation['programme_correctly_titled']; ?></td>
			<?php }	?>
			<td rowspan= <?php echo count($application['evaluationHistory']) > 0 ? 1 : $rowspan; ?> ><?php echo $evaluation_outcome ?></td>
			<?php if($evalIndex == 0) { ?>
			<td rowspan= <?php echo $rowspan; ?>><?php echo isset($AllOutcome[$application['Application']['review_outcome_id']]) ? $AllOutcome[$application['Application']['review_outcome_id']] : ''; ?></td>
			<td rowspan= <?php echo $rowspan; ?>> 
				<?php 
					$proceedingType = $this->Heqf->getProceedingTypeDesc($application['ReviewProceeding']['proceeding_type_id']);
					echo isset($application['ReviewProceeding']['proceeding_type_id']) && $application['ReviewProceeding']['proceeding_type_id'] > '' ? $proceedingType : ''; 
				?>
			</td>
			<td rowspan= <?php echo $rowspan; ?>> <?php $this->Heqf->showProceedingFile($application['ReviewProceeding']['proc_document'], 'View ' . $proceedingType, $application['Institution']['hei_code']); ?></td>
			<td rowspan= <?php echo $rowspan; ?>>
				<?php
					echo isset($AllOutcome[$application['ReviewProceeding']['proc_lkp_outcome_id']]) ? $AllOutcome[$application['ReviewProceeding']['proc_lkp_outcome_id']] : '';
				?>
			 </td>
			<td rowspan= <?php echo $rowspan; ?> class="actions bulkButtons">
				<?php
					if($this->AuthLinks->checkPermission('read', 'review', 'process')) {
						echo $this->Html->link(__('View application', true), 
							array(
								'controller' => 'process', 
								'action' => 'view',
								'process-slug' => 'application', 
								'id' => $application['Application']['id']
							),
							array(
								'target' => '_blank'
							)
						);

						echo '<br>';
						echo $this->Html->link(__('View comments', true), 
							array(
								'controller' => 'process', 
								'action' => 'view',
								'process-slug' => 'application', 
								'id' => $application['Application']['id'],
								'sectionView' => 'commentHistory'
							),
							array(
								'class' => 'dialogViewLink',
								'rel' => 'comments',
								'target' => '_blank'
							)
						);
						if ($this->Heqf->isCatB($application)) {
							echo '<br>';
							echo $this->Html->link(__('View evaluation', true), 
								array(
									'controller' => 'process', 
									'action' => 'view',
									'process-slug' => 'application', 
									'id' => $application['Application']['id'],
									'sectionView' => 'evaluation'
								),
								array(
									'target' => '_blank'
								)
							);
						}
						echo '<br>';
						if($application['Application']['application_status'] == 'Proceeding') {
							echo $this->Html->link(__('Review ' . $proceedingType . ' outcome', true),
								array(
									'controller' => 'process',
									'action' => 'continue_process',
									'process-slug' => 'review',
									'id' => $application['Application']['id']
								)
							);
						} else {
							echo $this->Html->link(__('Review outcome', true),
								array(
									'controller' => 'process',
									'action' => 'continue_process',
									'process-slug' => 'review',
									'id' => $application['Application']['id']
								)
							);
						}
						
							
					}
				?>
			</td>
			<?php } ?>
		</tr>
		<?php
			}
			if (isset($application['proceedingHistory']) && !empty($application['proceedingHistory'])) :?>
			<tr <?php echo 'class="'.$class.' comments"';?>>
					<td></td>
					<td colspan="3">
						<b>Previous Representation/Deferral Outcome</b>
					</td>
					<td colspan="2">
						<b>Date</b>
					</td>
					<td colspan="2">
						<b>Proc Document</b>
					</td>
					<td colspan="16">
						<b>Review Comments</b>
					</td>
					<?php foreach ($application['proceedingHistory'] as $proceeding) {
						$proc_outcome = isset($AllOutcome[$proceeding['proc_lkp_outcome_id']]) ? $AllOutcome[$proceeding['proc_lkp_outcome_id']] : '';
						$procType = $this->Heqf->getProceedingTypeDesc($proceeding['proceeding_type_id']);
						echo '<tr class = "'.$class.' comments">';
						echo '<td></td>';
							echo '<td colspan="3">' . $proc_outcome . '</td>';
							echo '<td colspan="2">' . $proceeding['proc_date'] . '</td>';?>
							<td colspan="2"> <?php $this->Heqf->showProceedingFile($proceeding['proc_document'], 'View ' . $procType, $application['Institution']['hei_code']) ?></td>
							<?php
							echo '<td colspan="16">' . $proceeding['proc_comments'] . '</td>';
						echo '</tr>';
					}
					?>
			</tr>
		<?php endif;
		}
		?>
		
	<?php } ?>
		</tbody>

		<tfoot>
			<tr class="tableHead">
				<td>
				</td>
				<td style="border:none;"  colspan="18">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if(count($list)){
									if($this->AuthLinks->checkPermission('update', 'review', 'process')) {
										echo $this->Form->button('Mark as reviewed and return to administrator', array('value' => 'mark_reviewed', 'name' => 'action', 'class' => 'dialogButton'));
										echo $this->Form->button('Set application(s) as aligned', array('value' => 'set_review_outcome', 'name' => 'action', 'class' => 'dialogButton'));
										echo $this->Form->button('Return to administrator without reviewing', array('value' => 'return_without_review', 'name' => 'action', 'class' => 'dialogButton'));
									}
								}
							?>
						</div>
					</div>
				</td>
			</tr>
		</tfoot>
	<?php }else{ 
		$message = 'There are no applications available.';
		if(!empty($_SESSION['search']) && count($_SESSION['search']) > 1){
			$message = 'Your search criteria found no applications.';
		}
	?>
		<p><?php echo $message; ?></p>
	<?php } ?>
	</table>
</div>
	<?php echo $this->element('paging', array('plugin' => 'octoplus', 'extraParams' => array('process-slug'))); ?>
