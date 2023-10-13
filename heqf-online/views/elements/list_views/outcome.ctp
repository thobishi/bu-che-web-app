<?php
	/*
		For the permissions to perform the actions:

		Took the outcome controller id from the available controllers
		Searched for it in the permissions table
		where the role id was the che admin, made the _admin column = 1
	*/
	$buttonAccept = $this->Form->button('Accept outcomes', array('value' => 'outcome_accept', 'name' => 'action', 'class' => 'dialogButton'));
	$buttonNotify = $this->Form->button('Notify institutions of outcomes', array('value' => 'outcome_notify', 'name' => 'action', 'class' => 'dialogButton'));

	$adjustedList = array();
	$count = 0;
	foreach ($list as $listKey => $institutionData) {
		if (!empty($institutionData['Application'])) {
			$name = $institutionData['Institution']['hei_name'] . ' (' . $institutionData['Institution']['hei_code'] . ')';
			$id = $institutionData['Institution']['id'];
			foreach ($institutionData['Application'] as $application) {
				$outcome = (isset($application['Outcome']['outcome_desc'])) ? $application['Outcome']['outcome_desc'] : 'No outcome assigned';
				$adjustedList[$id][$name][$application['HeqcMeeting']['date']][$outcome][$count]['align'] = isset($application['HeqfQualification']['s1_lkp_heqf_align_id']) ? $application['HeqfQualification']['s1_lkp_heqf_align_id'] : '';
				$adjustedList[$id][$name][$application['HeqcMeeting']['date']][$outcome][$count]['outcome'] = $application['outcome_accepted'];
				$adjustedList[$id][$name][$application['HeqcMeeting']['date']][$outcome][$count]['notified'] = $application['notified'];
				$count++;
			}
		}
	}

	$HeqcMeeting = array_flip($HeqcMeeting);

	echo $this->element('search/outcome_filter');
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
				<td colspan="12">
					<div class="listActions">
						<p class="table_selected">With selected:</p>
						<div class="bulkButtons">
							<?php
								if (count($adjustedList)) {
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
					<th rowspan="1" colspan="6">Outcomes</th>
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
				<th>No outcome assigned</th>
			</tr>
		</thead>
		<?php if (count($adjustedList)) { ?>
		<tbody id="tableBody">
		<?php
		$i = 0;
		foreach ($adjustedList as $instID => $adjustedListData) {
			foreach ($adjustedListData as $instName => $information) {
				foreach ($information as $date => $outcomes) {
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow_';
					}
					/*if ($instID == '209') {
						debug($outcomes);
					}*/
					$count = 0;
					$acceptedCount = 0;
					$notifiedCount = 0;
					foreach ($AllApplicationOutcomes as $OutcomeLookUp) {
						if (isset($outcomes[$OutcomeLookUp])) {
							$count = $count + count($outcomes[$OutcomeLookUp]);
							foreach ($outcomes[$OutcomeLookUp] as $appInfo) {
								$acceptedCount = (!($appInfo['outcome'])) ? $acceptedCount + 1 : $acceptedCount;
								$notifiedCount = (!($appInfo['notified'])) ? $notifiedCount + 1 : $notifiedCount;
							}
						}
					}
					$accepted = ($acceptedCount > 0) ? false : true;
					$notified = ($notifiedCount > 0) ? false : true;

					$classCat = ($accepted && $notified) ? 'outcomeComplete' : ((!$accepted && !$notified) ? 'outcomeNotComplete' : 'outcomeAlmostComplete');

					$class = $class . $classCat;

					$disabled = (isset($outcomes['No outcome assigned']) && count($outcomes['No outcome assigned'])) ? true : false;
				?>
				<tr <?php echo 'class="' . $class . '"';?>>
					<td style="width: 16px">
						<?php
							// $disabled = false;//$this->Status->accepted($outcomes, $Outcomes);
							echo $this->Form->input(
								'Process.selected.' . $date . '_' . $instID, //$HeqcMeeting[$date],
								array(
									'value' => $instID,
									'label' => '',
									'type' => 'checkbox',
									'checked' => false,
									'disabled' => $disabled,
								)
							);
						?>
					</td>
					<td>
						<?php echo $instName; ?>
					</td>
					<td>
						<?php echo $date; ?>
					</td>
					<td>
						<?php echo $count; ?>
					</td>
					<td>
						<?php echo isset($outcomes['HEQSF-aligned and deemed Accredited']) ? count($outcomes['HEQSF-aligned and deemed Accredited']) : 0; ?>
					</td>
					<td>
						<?php echo isset($outcomes['Re-categorised']) ? count($outcomes['Re-categorised']) : 0; ?>
					</td>
					<td>
						<?php echo isset($outcomes['Not HEQSF-aligned']) ? count($outcomes['Not HEQSF-aligned']) : 0; ?>
					</td>
					<td>
						<?php echo isset($outcomes['Needs Improvement']) ? count($outcomes['Needs Improvement']) : 0; ?>
					</td>
					<td>
						<?php echo isset($outcomes['Not HEQSF-aligned and Re-categorised to Category C']) ? count($outcomes['Not HEQSF-aligned and Re-categorised to Category C']) : 0; ?>
					</td>
					<td>
						<?php echo isset($outcomes['No outcome assigned']) ? count($outcomes['No outcome assigned']) : 0; ?>
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
								echo $this->Html->link(__('View', true), array('controller' => 'process', 'action' => 'view', 'process-slug' => 'outcome', 'id' => $instID, 'date' => $date));
							}
							if ($this->AuthLinks->checkPermission('create', 'document', 'process')) {
								echo $this->Html->link(__('Generate letter', true), array('controller' => 'documents', 'ext' => 'docx', 'action' => 'generate', 'outcome-notifications-letter', $instID, $date));
							}
						?>
					</td>
				</tr>
			<?php
				}
			}
		}
		?>
		</tbody>
		<tfoot>
			<tr class="tableHead">
				<td>
				</td>
				<td style="border:none;" colspan="12">
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

