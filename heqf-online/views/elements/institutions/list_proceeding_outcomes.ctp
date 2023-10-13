<?php
$buttonAccept = $this->Form->button('Accept proceeding outcomes', array('value' => 'proceeding_outcome_accept', 'name' => 'action', 'class' => 'dialogButton'));
$buttonNotify = $this->Form->button('Notify institutions of proceeding outcomes', array('value' => 'proceeding_outcome_notify', 'name' => 'action', 'class' => 'dialogButton'));

echo $this->element('search/proceeding_outcome_filter');
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
				<td colspan="13">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if (count($list)) {
									if ($this->AuthLinks->checkPermission('admin', 'application', 'process')) {
										echo $buttonAccept;
										echo $buttonNotify;
									}
								}
							?>
						</div>
					</div>
					<?php
						echo '<a id="searchLink" style="float:right" href="#">Advanced search</a>';
					?>
				</td>
			</tr>
			<tr>
					<th rowspan="2"></th>
					<th rowspan="2">Institution</th>
					<th rowspan="2">HEQC meeting</th>
					<th rowspan="2">Number applications assigned to meeting</th>
					<th rowspan="2">Proceeding type</th>
					<th rowspan="1" colspan="6" style="text-align:center;">Outcomes</th>
					<th rowspan="2">Outcomes accepted</th>
					<th rowspan="2">Institution notified</th>
					<th rowspan="2" class="actions"><?php __('Actions');?></th>
			</tr>
			<tr>
				<th>Deemed accredited</th>
				<th>Re-categorised</th>
				<th>Not HEQSF aligned</th>
				<th>Needs Improvement</th>
				<th>Not HEQSF-aligned and Re-categorised to Category C</th>
				<th>Needs Improvement(Return to institution for revision)</th>
			</tr>
		</thead>
		<?php if (count($list)) {?>
			<tbody id="tableBody">
				<?php
				$i = 0;
				foreach ($list as $key => $data) {
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow_';
					}
					$accepted = $data['Proceeding']['outcome_accepted'] > 0 ? true : false;
					$notified = $data['Proceeding']['notified'] > 0 ? true : false;
					$classCat = ($accepted && $notified) ? 'outcomeComplete' : ((!$accepted && !$notified) ? 'outcomeNotComplete' : 'outcomeAlmostComplete');
					$class = $class . $classCat;
					$disabled  = ($accepted && $notified) ? true : false;
				?>
				<tr <?php echo 'class="' . $class . '"';?>>
					<td style="width: 16px">
						<?php
							echo $this->Form->input(
								'Institution.selected.' . $data['HeqcMeeting']['date'] . '_' . $data['Application']['institution_id'] . '_' . $data['ProceedingType']['id'],
								array(
									'value' => $data['Application']['institution_id'],
									'label' => '',
									'type' => 'checkbox',
									'checked' => false,
									'disabled' => $disabled,
								)
							);
						?>
					</td>
					<td>
						<?php echo $data['Institution']['hei_name'] . '(' . $data['Institution']['hei_code'] . ')'; ?>
					</td>
					<td>
						<?php echo $data['HeqcMeeting']['date'] ?>
					</td>
					<td>
						<?php echo $data[0]['total_assigned']; ?>
					</td>
					<td>
						<?php echo $data['ProceedingType']['description']; ?>
					</td>
					<td>
						<?php echo $data[0]['outcome_aligned']; ?>
					</td>
					<td>
						<?php echo $data[0]['outcome_recat']; ?>
					</td>
					<td>
						<?php echo $data[0]['outcome_notaligned']; ?>
					</td>
					<td>
						<?php echo $data[0]['outcome_ni']; ?>
					</td>
					<td>
						<?php echo $data[0]['outcome_recat_to_c']; ?>
					</td>
					<td>
						<?php echo $data[0]['outcome_return_to_inst']; ?>
					</td>
					<td>
						<?php echo ($accepted) ? 'Yes' : 'No'; ?>
					</td>
					<td>
						<?php echo ($notified) ? 'Yes' : 'No'; ?>
					</td>
					<td class="actions bulkButtons">
						<?php
							if ($this->AuthLinks->checkPermission('read', 'application', 'process')) {
								echo $this->Html->link(__('View', true), array('controller' => 'institutions', 'action' => 'view', 'id' => $data['Application']['institution_id'], 'date' => $data['HeqcMeeting']['date'], 'procType' => $data['ProceedingType']['id']));
							}
							if ($this->AuthLinks->checkPermission('create', 'document', 'process')) {
								echo $this->Html->link(__('Generate letter', true), array('controller' => 'documents', 'ext' => 'docx', 'action' => 'generate', 'proceeding-outcome-notifications-letter', $data['Application']['institution_id'], $data['HeqcMeeting']['date'], $data['ProceedingType']['id']));
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
					<td style="border:none;" colspan="13">
						<div class="listActions">
							<p class="table_selected">With selected:</p>
							<div class="bulkButtons">
								<?php
									if ($this->AuthLinks->checkPermission('admin', 'application', 'process')) {
											echo $buttonAccept;
											echo $buttonNotify;
									}
								?>
							</div>
						</div>
					</td>
				</tr>
			</tfoot>
			<?php
			} else {
				$message = 'There is no informationn available.';
				if (!empty($_SESSION['search']) && count($_SESSION['search']) > 1) {
					$message = 'Your search criteria found no information.';
				}
		?>
			<p><?php echo $message; ?></p>
		<?php 
			}
		?>
	</table>
</div>