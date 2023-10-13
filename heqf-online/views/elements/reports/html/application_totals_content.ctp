<?php
	if (!empty($reportData)) {
		foreach ($reportData as $category => $applications) {
			if (!empty($reportData[$category])) {
			$data = $this->Report->totalsReportData($reportData[$category]);
			$statusCols = (!empty($data['status']) && count($data['status']) > 1) ? count($data['status']) : 1;
			$showAppendixHeading = (!empty($data['status']) && (in_array('appB', $data['status']) || in_array('appA', $data['status']))) ? true :false;
			$statusTotals = array();
		?>
			<h3>Category <?php echo $category; ?></h3>
			<table class="totalsReport">
				<thead>
					<tr class="tableHead">
						<th rowspan="2">Qualification type</th>
						<th rowspan="1" colspan="<?php echo $statusCols; ?>"><?php echo ($showAppendixHeading) ? 'Appendices':''; ?></th>
						<th rowspan="1" colspan="4">Outcomes</th>
						<th  rowspan="2">Accepted</th>
						<th  rowspan="2">Notified</th>
						<th rowspan="2">Total Qualifications</th>
					</tr>
					<tr class="tableHead">
						<?php
							if ($statusCols > 1) {
								foreach ($data['status'] as $status) {
									$statusTotals[$status] = 0;
									echo '<th>' . $this->Report->totalHeadings['status'][$status] . '</th>';
								}
							}
						?>
						<th>Accredited</th><th>Re-categorised</th><th>Not accredited</th><th>No outcome</th>
					</tr>
				</thead>
				<tbody>
		<?php
			$totals = array();
			foreach ($reportData[$category] as $count => $applicationData) {
				$class = '';
				if ($count % 2 == 0) {
					$class = 'altrow';
				}
				foreach ($applicationData['Application'] as $key => $count) {
					if (!isset($totals[$key])) {
						$totals[$key] = 0;
					}
					$totals[$key] += $count;
				}
			?>
					<tr class="<?php echo $class; ?>">
						<td><?php echo (isset($QualificationType[$applicationData['HeqfQualification']['lkp_qualification_type_id']])) ? $QualificationType[$applicationData['HeqfQualification']['lkp_qualification_type_id']] : 'None'; ?></td>
						<?php
							if ($statusCols > 1) {
								foreach ($data['status'] as $status) {
									$statusTotals[$status] = $statusTotals[$status] + $applicationData['Application'][$status];
									echo '<td class="appendices">' . $applicationData['Application'][$status] . '</td>';
								}
							}
						?>
						<td class="outcomes"><?php echo $applicationData['Application']['accred']; ?></td>
						<td class="outcomes"><?php echo $applicationData['Application']['recat']; ?></td>
						<td class="outcomes"><?php echo $applicationData['Application']['notAccred']; ?></td>
						<td class="outcomes"><?php echo $applicationData['Application']['noOutcome']; ?></td>
						<td><?php echo $applicationData['Application']['outAccepted']; ?></td>
						<td><?php echo $applicationData['Application']['notified']; ?></td>
						<td><?php echo $applicationData['Application']['Total']; ?></td>
					</tr>
		<?php
			}
		?>
					<tr class="rowTotal">
						<td></td>
						<?php
							if ($statusCols > 1) {
								foreach ($statusTotals as $total) {
									echo '<td class="appendices">' . $total . '</td>';
								}
							}
						?>
						<td class="outcomes"><?php echo $totals['accred']; ?></td>
						<td class="outcomes"><?php echo $totals['recat']; ?></td>
						<td class="outcomes"><?php echo $totals['notAccred']; ?></td>
						<td class="outcomes"><?php echo $totals['noOutcome']; ?></td>
						<td><?php echo $totals['outAccepted']; ?></td>
						<td><?php echo $totals['notified']; ?></td>
						<td class="totalTotal"><?php echo $totals['Total']; ?></td>
					</tr>
				</tbody>
			</table>
			<?php
			}else{
				echo '<p>No category ' . $category . ' applications</p>';
			}
		}
	} else {
		echo '<p>There is no data for this report.</p>';
	}