<div class="dashboard">
<?php
	echo $this->element('reports/header');
	$this->set('title_for_layout', 'Reminder report');
?>
<h2>Reminder report</h2>
<?php 
	echo '<div style="clear:both;"></div>';
	echo $this->element('search/reminder_filter', array(
			'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
			'model' => $report['model'],
			'advancedOnly' => true,
			'searchText' => 'Filter ' . strtolower($report['name']),
			'clearSearch' => false
		)
	);

	if (!empty($reportData)) {
		$totalDisplay = $this->Paginator->counter(array(
			'format' => 'Total: %current% of %count% application(s) in Evaluation/Review'
		));
		echo $this->Html->div('total', $totalDisplay);
	}
?>
</div>
<?php if (!empty($reportData)) { 	
?>
	<div class="list_view_table">	
		<table>
			<thead>
				<tr class="tableHead">
					<th><?php echo $this->Paginator->sort('Institution', 'Institution.hei_name') ?></th>
					<th><?php echo $this->Paginator->sort('Qualification title (Section 2)', 'HeqfQualification.qualification_title') ?></th>
					<th><?php echo $this->Paginator->sort('Institution alignment category', 'HeqfQualification.s1_lkp_heqf_align_id') ?></th>
					<th><?php echo $this->Paginator->sort('Application status', 'Application.application_status') ?></th>
					<th><?php echo $this->Paginator->sort('User assigned to', 'User.last_name') ?></th>
					<th>Assigned date</th>
					<th>Due date</th>
					<th>Days outstanding</th>
					<th>First reminder</th>
					<th>Second reminder</th>
					<th>First Overdue reminder</th>
					<th>Second Overdue reminder</th>
				</tr>
			<thead>
			<tbody id="tableBody">
				<?php
					$i = 0;
					foreach ($reportData as $key => $application) {
						$applicationStatus = $this->Status->getStatus($application['Application']);
						$class = $this->Status->getClass($applicationStatus) . '';
						if ($i++ % 2 == 0) {
							$class .= '_altrow';
						}
				?>
				<tr <?php echo 'class="'.$class.'"';?>>
					<td><?php echo $application['Institution']['hei_name'] . ' (' .$application['Institution']['hei_code']. ')' ?></td>
					<td>
						<?php 
							$QualRefNo = '';
							$QualRefNo = !empty($application['HeqfQualification']['qualification_reference_no']) ? $application['HeqfQualification']['qualification_reference_no'] : $application['HeqfQualification']['s1_qualification_reference_no'];
							$QualRefNo = (!empty($QualRefNo)) ? ' (' . $QualRefNo . ')' : '';						
							echo !empty($application['HeqfQualification']['qualification_title']) ? $application['HeqfQualification']['qualification_title'] . $QualRefNo : '';
						?>
					</td>
					<td>
						<?php
							echo $application['HeqfQualification']['s1_lkp_heqf_align_id'];
						?>
					</td>
					<td><?php echo $applicationStatus; ?></td>
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
							$assignedDate =  $this->Heqf->getAssignedDate($application, $applicationStatus); 
							echo $assignedDate;
						?>
					</td>
					<td>
						<?php 
							$dueDate =  $this->Heqf->getDueDate($application, $applicationStatus); 
							echo $dueDate;
						?>
					</td>
					<td>
						<?php
							$daysOutstanding =  $this->Heqf->getDaysOutstanding($application, $applicationStatus); 
							echo $daysOutstanding;
						?>
					</td>
					<td>
						<?php 
							$first_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'first_reminder');
							echo $first_reminder;
						?>
					</td>
					<td>
						<?php 
							$second_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'second_reminder');
							echo $second_reminder;
						?>
					</td>
					<td>
						<?php 
							$third_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'third_reminder');
							echo $third_reminder;
						?>
					</td>
					<td>
						<?php 
							$fourth_reminder = $this->Heqf->getReminders($application, $applicationStatus, 'fourth_reminder');
							echo $fourth_reminder;
						?>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
<?php echo $this->element('paging', array('plugin' => 'octoplus', 'extraParams' => array('process-slug'))); ?>
<?php } else { ?>
<p>There is no data for this report.</p>
<?php } ?>