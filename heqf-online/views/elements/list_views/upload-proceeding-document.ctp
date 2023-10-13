<div class="listViews">
	<h2><?php __('List of Applications');?></h2>
</div>

<?php
	echo $this->element('search/application_representation_search');
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
				<td colspan="3">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if (count($list)) {
									if($this->AuthLinks->checkPermission('update', 'upload-proceeding-document', 'process')) {
										echo $this->Form->button('Submit Representation/Deferral to CHE', array('value' => 'inst_submit_proceeding', 'name' => 'action', 'class' => 'dialogButton'));
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
					<th>Representation/Deferral Document</th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>
		</thead>
		<?php if (count($list)) { ?>
		<tbody id="tableBody">
		<?php
		$i = 0;
		foreach ($list as $key => $application):
			$class = '';
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}

		?>
		<tr <?php echo 'class="' . $class . '"';?>>
			<td style="width: 16px">
				<?php
					$checked = isset($this->data['Process']['selected']) && is_array($this->data['Process']['selected']) && in_array($application['Application']['id'], $this->data['Process']['selected']);
					echo $this->Form->input(
						'Process.selected.' . $key,
						array(
							'value' => $application['Application']['id'],
							'label' => '',
							'type' => 'checkbox',
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
					$proceedingType = $this->Heqf->getProceedingTypeDesc($application['Proceeding']['proceeding_type_id']);
					$hei_code = $this->Heqf->getInstitutionCode($application['Application']['institution_id']);

					$this->Heqf->showProceedingFile($application['Proceeding']['proc_document'], 'View Uploaded ' . $proceedingType, $hei_code);
				?>
			</td>
			<td class="actions bulkButtons">
				<?php
				// debug($application);
					if ($this->AuthLinks->checkPermission('read', 'application', 'process')) {
						echo $this->Html->link(__('View', true), array('controller' => 'process', 'action' => 'view', 'process-slug' => 'application', 'id' => $application['Application']['id']));
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

					if($this->AuthLinks->checkPermission('update', 'upload-proceeding-document', 'process')) {
						$uploadLabel = ($application['Application']['lkp_proceeding_type_id'] == 'r') ? 'Upload/Edit Representation' : 'Upload/Edit Deferral';
						echo $this->Html->link(
							__($uploadLabel, true),
							array(
								'controller' => 'process',
								'action' => 'continue_process',
								'process-slug' => 'upload-proceeding-document',
								'id' => $application['Application']['id']
							)
						);						
					}
					
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
				<td colspan="5"  style="border:none;">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if (count($list)) {
									if($this->AuthLinks->checkPermission('update', 'upload-proceeding-document', 'process')) {
										echo $this->Form->button('Submit Representation/Deferral to CHE', array('value' => 'inst_submit_proceeding', 'name' => 'action', 'class' => 'dialogButton'));
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