<div class="listViews">
<h2><?php __('List of Applications to evaluate');?></h2>
</div>
<?php
	
	echo $this->element('search/eval_check_search');
	
	$totalDispplay = $this->Paginator->counter(array(
		'format' => 'Total: %current% of %count% application(s)'
	));
	echo $this->Html->div('total', $totalDispplay);
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
				<td colspan="7">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if(count($list)){
									echo $this->Form->button('Return to administrator without evaluating', array('value' => 'return_evaluation', 'name' => 'action', 'class' => 'dialogButton'));
								}
								echo $html->link('Help - How to evaluate', array('controller' => 'pages', 'action' => 'download_help', 'evaluate_catB'));
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
					<th></th>
					<th><?php echo $this->Paginator->sort('Institution', 'Institution.hei_name'); ?></th>
					<th><?php echo $this->Paginator->sort('Ref', 'HeqfQualification.qualification_reference_no'); ?></th>
					<th><?php echo $this->Paginator->sort('Qualification name', 'HeqfQualification.qualification_title'); ?></th>
					<th><?php echo $this->Paginator->sort('Date submitted', 'Application.submission_date'); ?></th>
					<th><?php echo $this->Paginator->sort('HEQSF reference', 'HeqfQualification.heqf_reference_no'); ?></th>
					<th><?php echo $this->Paginator->sort('Qualification type', 'HeqfQualification.lkp_qualification_type_id'); ?></th>
					<th><?php echo $this->Paginator->sort('Institution alignment category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>

					<!-- <th><?php //echo $this->Paginator->sort('Proposed HEQSF category', 'Application.lkp_heqf_align_id');  ?></th>
					<th><?php //echo $this->Paginator->sort('Outcome', 'Application.lkp_outcome_id');  ?></th>
					<th><?php //echo $this->Paginator->sort('Date evaluation completed', 'Application.evaluation_date'); ?></th> -->
					<th class="actions"><?php __('Actions');?></th>
			</tr>
		</thead>
		<?php if(count($list)) { ?>
		<tbody id="tableBody">
		<?php
		$i = 0;
		foreach ($list as $key => $application) {
			$class = '';
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}
			$qualification_type = isset($QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']]) ? $QualificationType[$application['HeqfQualification']['lkp_qualification_type_id']] : '';
			//$heqf_align_catg = (!empty($application['Application']['lkp_heqf_align_id'])) ? $application['Application']['lkp_heqf_align_id'] : $application['HeqfQualification']['s1_lkp_heqf_align_id'];
			$outcome = $application['Outcome']['outcome_desc'];
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
			<td><?php echo !empty($application['HeqfQualification']['qualification_reference_no']) ? $application['HeqfQualification']['qualification_reference_no'] : $application['HeqfQualification']['s1_qualification_reference_no'] ?></td>
			<td><?php echo !empty($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] : $application['HeqfQualification']['s1_qualification_title'] ?></td>
			<td><?php echo $application['Application']['submission_date']; ?></td>
			<td><?php echo $application['HeqfQualification']['heqf_reference_no']; ?></td>
			<td><?php echo $qualification_type; ?></td>
			<td><?php echo $application['HeqfQualification']['s1_lkp_heqf_align_id']; ?></td>
			<!-- <td><?php //echo ($application['Application']['lkp_heqf_align_id']) ? $application['Application']['lkp_heqf_align_id'] : ''; ?></td>			
			<td><?php //echo $outcome; ?></td>
			<td><?php //echo ($application['Application']['evaluation_date'] > '1970-01-01') ? $application['Application']['evaluation_date'] : '&nbsp;' ?></td> -->
			<td class="actions bulkButtons">
				<?php
					$evaluateProcessSlug = $this->Heqf->isCatB($application) ? 'evaluate-cat-b' :  'evaluate';
					if($this->AuthLinks->checkPermission('update', 'evaluate', 'process') || $this->AuthLinks->checkPermission('update', 'evaluate-cat-b', 'process')) {
						echo $this->Html->link(
							__('Evaluate', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => $evaluateProcessSlug,
								'id' => $application['Application']['id']
							)
						);
					}
				?>
			</td>
		</tr>
	<?php } ?>
		</tbody>

		<tfoot>
			<tr class="tableHead">
				<td>
				</td>
				<td style="border:none;"  colspan="9">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								echo $this->Form->button('Return to administrator', array('value' => 'return_evaluation', 'name' => 'action', 'class' => 'dialogButton'));
							?>
						</div>
					</div>
				</td>
			</tr>
		</tfoot>
	<?php } else { 		
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
