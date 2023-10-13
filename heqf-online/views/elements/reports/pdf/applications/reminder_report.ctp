<div class="dashboard">
<h2>Reminder report</h2>
<?php 
	$title = 'Report - Evaluator/Reviewer reminder - ' . date('Y-m-d H:i');
	$this->set('title_for_layout', $title);
	$this->set('filename', 'Report - Evaluator/Reviewer reminder');
	$this->setOption('orientation', 'Landscape');
?>
</div>
<?php if (!empty($reportData)) { 	
?>
	<div class="list_view_table">	
		<table>
			<thead>
				<tr class="tableHead">
					<th>Institution</th>
					<th>Qualification title (Section 2)</th>
					<th>Institution alignment category</th>
					<th>Application status</th>
					<th>User assigned to</th>
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
<?php } else { ?>
<p>There is no data for this report.</p>
<?php } ?>