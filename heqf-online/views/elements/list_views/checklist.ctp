<div class="listViews">
<h2><?php __('List of Applications');?> - <?php echo (Auth::checkRole('checklister') ? 'CHE checklister' : '')?></h2>
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
				<td colspan="8">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if(count($list)){
									if($this->AuthLinks->checkPermission('admin', 'application', 'process')) {
										echo $this->Form->button('Return to institution', array('value' => 'return_inst', 'name' => 'action', 'class' => 'dialogButton'));
										echo $this->Form->button('Assign to checklister', array('value' => 'assign_checklister', 'name' => 'action', 'class' => 'dialogButton'));
									}
								}
							?>
						</div>
					</div>
				</td>
				<td style="border:none;">
					<div class="search actions ui-buttonset">
						<?php
							echo $this->Form->text('search', array('placeholder' => 'Search'));
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
					<th><?php echo $this->Paginator->sort('Institution', 'Institution.hei_name') ?></th>
					<th><?php echo $this->Paginator->sort('Qualification type', 'HeqfQualification.lkp_qualification_type_id') ?></th>
					<th><?php echo $this->Paginator->sort('HEQSF ref', 'HeqfQualification.heqf_reference_no') ?></th>
					<th><?php echo $this->Paginator->sort('Qualification name', 'HeqfQualification.qualification_title') ?></th>
					<th><?php echo $this->Paginator->sort('Date submitted', 'Application.submission_date') ?></th>
					<th><?php echo $this->Paginator->sort('Proposed HEQSF category', 'Application.lkp_heqf_align_id') ?></th>
					<th><?php echo $this->Paginator->sort('Institution alignment category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>
					<th><?php echo $this->Paginator->sort('Checklist status', 'Application.checklisting_status_id') ?></th>
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
		$institution = $application['Institution']['hei_name'] . ' (' .$application['Institution']['hei_code']. ')';
		$heqf_ref = (!empty($application['HeqfQualification']['heqf_reference_no'])) ? $application['HeqfQualification']['heqf_reference_no'] : '&nbsp;';
		$qualification_title = !empty($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] : $application['HeqfQualification']['s1_qualification_title'];
		$submission_date = ($application['Application']['submission_date'] !== '1970-01-01') ? $application['Application']['submission_date'] : 'Not submitted';
		$heqf_align_catg = (!empty($application['Application']['lkp_heqf_align_id'])) ? $application['Application']['lkp_heqf_align_id'] : '';
		$inst_align_catg = $application['HeqfQualification']['s1_lkp_heqf_align_id'];
		$checklist_status = $application['Application']['checklisting_status_id'];
		$checked = isset($this->data['Process']['selected']) && is_array($this->data['Process']['selected']) && in_array($application['Application']['id'], $this->data['Process']['selected']);
		$select_checkbox =  $this->Form->input(
								'Process.selected.'.$key,
								array(
									'value'=>$application['Application']['id'],
									'label' => '',
									'type' => 'checkbox',
									'checked' => $checked,
								)
							);
		$checklist_button = "&nbsp;";
		if($this->AuthLinks->checkPermission('update', 'checklist', 'process')) {
			$checklist_button =  $this->Html->link(
							__('Checklist', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'checklist',
								'id' => $application['Application']['id']
							)
						);
		}

		$html = <<<HTML
		<tr class="$class">
			<td style="width: 16px">$select_checkbox</td>
			<td>$institution</td>
			<td>$qualification_type</td>
			<td>$heqf_ref</td>
			<td>$qualification_title</td>
			<td>$submission_date</td>
			<td>$heqf_align_catg</td>
			<td>$inst_align_catg</td>
			<td>$checklist_status</td>
			<td class="actions bulkButtons">$checklist_button</td>
		</tr>
HTML;
		echo $html;		
	} 
	?>
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
								if($this->AuthLinks->checkPermission('admin', 'application', 'process')) {
									echo $this->Form->button('Return to institution', array('value' => 'return_inst', 'name' => 'action', 'class' => 'dialogButton'));
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
