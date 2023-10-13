<?php
		$hideLinksAction = array(
			'archive' => array(
				'requirements',
				'appendixb',
				'submitted'
			),
			'assign' => array(
				'appendixb',
			),
			'submit' => array(
				'appendixb',
				'requirements',
			),
			're_submit' => array(
				'corrections',
				'ready',
				'submitted',
				'appendixb'
			),
			'send_back' => array(
				'appendixb'
			),
			'take_back' => array(
				'appendixb'
			)
		);
		$currentPage = 'all';
	if (Auth::checkRole('inst_admin')) {
	?>
	<div id="application-types" class="bulkButtons">
		<?php
			if (isset($this->params['named']['error']) && isset($this->params['named']['status']) && $this->params['named']['error'] == true && $this->params['named']['status'] == 'New') {
				$currentPage = 'corrections';
			} elseif (isset($this->params['named']['status']) && $this->params['named']['status'] == 'New') {
				$currentPage = 'ready';
			} elseif (isset($this->params['named']['status']) && $this->params['named']['status'] == 'Submitted') {
				$currentPage = 'submitted';
			} elseif (isset($this->params['named']['status']) && $this->params['named']['status'] == 'Requirements') {
				$currentPage = 'requirements';
			} elseif (isset($this->params['named']['status']) && $this->params['named']['status'] == 'AppendixB') {
				$currentPage = 'appendixb';
			}/*elseif (isset($this->params['named']['status']) && $this->params['named']['status'] == 'Representation (Institution)') {
				$currentPage = 'representations';
			}elseif (isset($this->params['named']['status']) && $this->params['named']['status'] == 'Deferral (Institution)') {
				$currentPage = 'deferrals';
			}*/

			// echo $this->Html->link('Representations', array('error' => false, 'status' => 'Representation (Institution)', 'process-slug' => 'application'), array('id' => 'representations-link', 'class' => ($currentPage == 'representations' ? 'active' : '')));

			// echo $this->Html->link('Deferrals', array('error' => false, 'status' => 'Deferral (Institution)', 'process-slug' => 'application'), array('id' => 'deferrals-link', 'class' => ($currentPage == 'deferrals' ? 'active' : '')));

			echo $this->Html->link('Need corrections', array('error' => true, 'status' => 'New', 'process-slug' => 'application'), array('id' => 'corrections-link', 'class' => ($currentPage == 'corrections' ? 'active' : '')));
			echo $this->Html->link('Ready for submission', array('error' => false, 'status' => 'New', 'process-slug' => 'application'), array('id' => 'ready-link', 'class' => ($currentPage == 'ready' ? 'active' : '')));
			echo $this->Html->link('Submitted', array('status' => 'Submitted', 'process-slug' => 'application'),
			array('id' => 'submitted-link', 'class' => ($currentPage == 'submitted' ? 'active' : '')));
			echo $this->Html->link('Requirements', array('status' => 'Requirements', 'process-slug' => 'application'), array('id' => 'requirements-link', 'class' => ($currentPage == 'requirements' ? 'active' : '')));
			//echo $this->Html->link('Appendix B', array('status' => 'AppendixB', 'process-slug' => 'application'), array('id' => 'appendixb-link', 'class' => ($currentPage == 'appendixb' ? 'active' : '')));
			echo $this->Html->link('All', array('status' => false, 'process-slug' => 'application'), array('id' => 'all-link', 'class' => ($currentPage == 'all' ? 'active' : '')));
		?>
	</div>
	<?php
	}
	?>
<div class="listViews">
	<h2><?php __('List of Applications');?> - <?php echo (Auth::checkRole('inst_admin') ? 'Institution administrator' : 'Institution user')?></h2>
</div>

<?php
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
				<td style="width:16px;text-align:center;color:#8C8B8B;font-size:12px;">
					<?php
						echo $this->Form->label('submitAll', 'All:');
						echo $this->Form->checkbox("submitAll");
					?>
				</td>
				<td style="white-space: nowrap;">
					<?php
						echo '<a id="searchLink" style="float:right" href="#">Advanced search</a>';
					?>
				</td>
				<td colspan="6">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if (count($list)) {
									if ($this->AuthLinks->checkPermission('delete', 'application', 'process')) {
										echo (in_array($currentPage, $hideLinksAction['archive'])) ? '' : $this->Form->button('Delete', array('value' => 'archive', 'name' => 'action'));
									}

									if ($this->AuthLinks->checkPermission('inst_admin', 'application', 'process')) {
										echo (in_array($currentPage, $hideLinksAction['assign'])) ? '' : $this->Form->button('Assign to user', array('value' => 'assign', 'name' => 'action', 'class' => 'dialogButton'));
										echo (in_array($currentPage, $hideLinksAction['submit'])) ? '' : $this->Form->button('Submit to CHE', array('value' => 'submit', 'name' => 'action'));
										echo (in_array($currentPage, $hideLinksAction['re_submit'])) ? '' : $this->Form->button('Re-submit to CHE', array('value' => 're_submit', 'name' => 'action'));
										echo (in_array($currentPage, $hideLinksAction['take_back'])) ? '' : $this->Form->button('Take back', array('value' => 'take_back', 'name' => 'action'));
									} else {
										echo (in_array($currentPage, $hideLinksAction['send_back'])) ? '' : $this->Form->button('Send to administrator', array('value' => 'send_back', 'name' => 'action'));
									}
								}
							?>
						</div>
					</div>
				</td>
				<td style="border:none;">
					<div class="search actions ui-buttonset">
						<?php
							echo $this->Form->text('Process.search.search', array('placeholder' => 'Search'));
							echo $this->Form->button('Go', array('id' => 'quickSearchButton', 'value' => 'search', 'class' => 'ui-button ui-widget ui-state-default ui-button-text-only ui-corner-left ui-corner-right'));
						?>
					</div>
				</td>
			</tr>
			<tr>
					<th></th>
					<th><?php echo $this->Paginator->sort('Ref', 'HeqfQualification.qualification_reference_no') ?></th>
					<th><?php echo $this->Paginator->sort('Qualification name', 'HeqfQualification.qualification_title') ?></th>
					<th><?php echo $this->Paginator->sort('Qualification category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>
					<th><?php echo $this->Paginator->sort('Date submitted', 'Application.submission_date') ?></th>
					<th><?php echo $this->Paginator->sort('Status', 'Application.application_status') ?></th>
					<th><?php echo $this->Paginator->sort('Outcome', 'Outcome.outcome_desc') ?></th>
					<th><?php echo $this->Paginator->sort('User assigned to', 'User.last_name') ?></th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>
		</thead>
		<?php if (count($list)) { ?>
		<tbody id="tableBody">
		<?php
		$i = 0;
		foreach ($list as $key => $application):
			$rowError = $application['HeqfQualification']['s1_error'] || $application['HeqfQualification']['s2_error'] || $application['HeqfQualification']['s3_error'];
			$preventCatBSubmission = $this->Heqf->preventCatBSubmission($application);
			$class = '';
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}

			$class .= $this->Status->statusClass($application, $rowError);

		?>
		<tr <?php echo 'class="' . $class . '"';?>>
			<td style="width: 16px">
				<?php
					$disabled = $this->Status->statusDisabled($application) || $preventCatBSubmission;
					$checked = isset($this->data['Process']['selected']) && is_array($this->data['Process']['selected']) && in_array($application['Application']['id'], $this->data['Process']['selected']);
					echo $this->Form->input(
						'Process.selected.' . $key,
						array(
							'value' => $application['Application']['id'],
							'label' => '',
							'type' => 'checkbox',
							'disabled' => $disabled,
							'checked' => $checked,
						)
					);
				?>
			</td>
			<td><?php echo !empty($application['HeqfQualification']['qualification_reference_no']) ? $application['HeqfQualification']['qualification_reference_no'] : $application['HeqfQualification']['s1_qualification_reference_no'] ?></td>
			<td><?php echo !empty($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] : $application['HeqfQualification']['s1_qualification_title'] ?></td>
			<td><?php echo isset($AppHeqfAlign[$application['HeqfQualification']['s1_lkp_heqf_align_id']]) ? $AppHeqfAlign[$application['HeqfQualification']['s1_lkp_heqf_align_id']] : 'Not set' ?></td>
			<td>
				<?php
					echo $this->Status->submittedDate($application['Application']['submission_date']);
				?>
			</td>
			<td class="column_category_<?php echo $application['HeqfQualification']['s1_lkp_heqf_align_id']; ?>">
				<?php
					echo $this->Status->instStatus($application, $rowError);
				?>
			</td>
			<td>
				<?php
					if ($application['Application']['outcome_accepted'] && $application['Application']['notified']) {
						echo $application['Outcome']['outcome_desc'];
					}
				?>
			</td>
			<td>
				<?php
					echo $this->Status->getUserAssigned($application);
				?>
			</td>
			<td class="actions bulkButtons">
				<?php
					/*
						need a popup link here
						need to have the popup, popup in the edit pages if the status is the correct one for it to merit it
						maybe at the bottom of the page in the dialog, but verything else editable, or completely in a new window???
					*/
						/*removing link to make corrections to category B*/
					/*if ($this->AuthLinks->checkPermission('update', 'application', 'process') && $this->Status->checkAppendixB($application)) {
						echo $this->Html->link(
							__('Appendix B corrections', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'appendix',
								'id' => $application['Application']['id']
							));
					}*/
					if (($this->AuthLinks->checkPermission('update', 'application', 'process') || $this->AuthLinks->checkPermission('update', 'application-cat-b', 'process')) && $this->Status->checkActionsUpdate($application)) {
						echo $this->Html->link(
							__('Edit', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								// 'process-slug' => ($application['Application']['review_error']) ? 'application-requirements' : 'application',
								'process-slug' => $this->Heqf->editSlugSelect($application),
								'id' => $application['Application']['id']
							));
					}
					if ($this->AuthLinks->checkPermission('read', 'application', 'process')) {
						echo $this->Html->link(__('View', true), array('controller' => 'process', 'action' => 'view', 'process-slug' => 'application', 'id' => $application['Application']['id']));
					}

					if ($this->AuthLinks->checkPermission('inst_admin', 'application', 'process') && $application['Application']['submission_date'] == '1970-01-01' && !$rowError && Auth::checkRole('inst_admin') && $application['Application']['user_id'] == Auth::get('User.id') && !$preventCatBSubmission ) {
						echo $this->Html->link(
							__('Submit', true),
							array_merge(
								$this->params['named'],
								array(
									'controller' => 'process',
									'action' => 'perform_action',
									'process-slug' => 'application',
									'action-slug' => 'submit',
									'id' => $application['Application']['id']
								)
							),
							array(
								'class' => 'dialogLink',
								'rel' => 'submit'
							)
						);
					}
					if ($this->AuthLinks->checkPermission('delete', 'application', 'process') && $application['Application']['submission_date'] == '1970-01-01' && $application['Application']['user_id'] == Auth::get('User.id') && $application['HeqfQualification']['disable_delete'] == false) {
						echo $this->Html->link(
							__('Delete', true),
							array_merge(
								$this->params['named'],
								array(
									'controller' => 'process',
									'action' => 'perform_action',
									'process-slug' => 'application',
									'action-slug' => 'archive',
									'id' => $application['Application']['id']
								)
							),
							array(
								'class' => 'dialogLink',
								'rel' => 'archive'
							)
						);
					}

					if ($this->AuthLinks->checkPermission('inst_admin', 'application', 'process') && $application['Application']['review_error'] && !$rowError  && !$preventCatBSubmission ) {
						echo $this->Html->link(
							__('Re-submit', true),
							array_merge(
								$this->params['named'],
								array(
									'controller' => 'process',
									'action' => 'perform_action',
									'process-slug' => 'application',
									'action-slug' => 're_submit',
									'id' => $application['Application']['id']
								)
							),
							array(
								'class' => 'dialogLink',
								'rel' => 're_submit'
							)
						);
					}

					if (($this->AuthLinks->checkPermission('inst_admin', 'application', 'process') && $application['Application']['review_error']) || ($this->AuthLinks->checkPermission('inst_admin', 'application', 'process') && $application['Application']['returned_from_checklisting'] && !empty($application['Application']['checklisting_comments']))) {
						echo $this->Html->link(
							__('View comments', true),
							array(
								'controller' => 'process',
								'action' => 'view',
								'process-slug' => 'application',
								'id' => $application['Application']['id'],
								'sectionView' => 'comments'
							),
							array(
								'class' => 'dialogViewLink',
								'rel' => 'comments',
								'target' => '_blank'
							)
						);
					}

					/*if($this->AuthLinks->checkPermission('update', 'upload-proceeding-document', 'process') && $application['Application']['lkp_proceeding_type_id'] == 'r') {
						echo $this->Html->link(
							__('Upload Representation', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'upload-proceeding-document',
								'id' => $application['Application']['id']
							)
						);						
					}

					if($this->AuthLinks->checkPermission('update', 'upload-proceeding-document', 'process') && $application['Application']['lkp_proceeding_type_id'] == 'd') {
						echo $this->Html->link(
							__('Upload Deferral', true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'upload-proceeding-document',
								'id' => $application['Application']['id']
							)
						);						
					}*/
					
				?>
			</td>
		</tr>

	<?php 
		endforeach;
	?>
		</tbody>

		<tfoot>
			<tr class="tableHead">
				<td>
				</td>
				<td colspan="8"  style="border:none;">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if (count($list)) {
									if ($this->AuthLinks->checkPermission('delete', 'application', 'process')) {
										echo (in_array($currentPage, $hideLinksAction['archive'])) ? '' : $this->Form->button('Delete', array('value' => 'archive', 'name' => 'action'));
									}

									if ($this->AuthLinks->checkPermission('inst_admin', 'application', 'process')) {
										echo (in_array($currentPage, $hideLinksAction['assign'])) ? '' : $this->Form->button('Assign to user', array('value' => 'assign', 'name' => 'action', 'class' => 'dialogButton'));
										echo (in_array($currentPage, $hideLinksAction['submit'])) ? '' : $this->Form->button('Submit to CHE', array('value' => 'submit', 'name' => 'action'));
										echo (in_array($currentPage, $hideLinksAction['re_submit'])) ? '' : $this->Form->button('Re-submit to CHE', array('value' => 're_submit', 'name' => 'action'));
										echo (in_array($currentPage, $hideLinksAction['take_back'])) ? '' : $this->Form->button('Take back', array('value' => 'take_back', 'name' => 'action'));
									} else {
										echo (in_array($currentPage, $hideLinksAction['send_back'])) ? '' : $this->Form->button('Send to administrator', array('value' => 'send_back', 'name' => 'action'));
									}
								}
							?>
						</div>
					</div>
				</td>
			</tr>
		</tfoot>
		<?php } else { ?>
			<p>There are no applications available.</p>
		<?php } ?>
	</table>
</div>
<?php	echo $this->element('paging', array('plugin' => 'octoplus', 'extraParams' => array('process-slug'))); ?>

<?php
	$sidebar = array();


	if ($this->AuthLinks->checkPermission('read', 'HeqcExtractions', 'Heqc')) {
		$sidebar[] = $this->AuthLinks->link('Extract HEQC data', array('controller' => 'heqc_extractions', 'plugin' => 'heqc'));
	}

	if ($this->AuthLinks->checkPermission('create', 'application', 'process')) {
		$sidebar[] = $this->AuthLinks->link('Download template for bulk import', array('controller' => 'heqf_qualifications', 'action' => 'download_template'));
		$sidebar[] = $this->AuthLinks->link('Bulk import of applications', array('action' => 'import', 'controller' => 'heqf_qualifications'));
	}
	$sidebar[] = $html->link('Help', array('controller' => 'pages', 'action' => 'display', 'help'));

	$this->set('sidebar', $sidebar);