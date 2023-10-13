<?php
	$ignoreCells = array(
		'Inactive'
	);

	$headings = array();
	$meetingDates = array();
	foreach ($applicationsInformation[0]['Application'] as $key => $value) {
		if (in_array($key, $ignoreCells)) {
			continue;
		}

		if (strpos($key, 'meeting-') === false) {
			$headings[$key] = array(
				$key,
				array('rowspan' => 2)
			);
		} else {
			$date = strtotime(str_replace('meeting-', '', $key));
			$year = date('Y', $date);
			$meetingDates[] = $date;
			$heading = 'HEQC meetings ' . $year;
			if (isset($headings[$heading])) {
				$headings[$heading][1]['colspan']++;
			} else {
				$headings[$heading] = array(
					$heading,
					array('colspan' => 1)
				);
			}
		}
	}
?>

<div style="margin:auto;width:1400px;">
	<h3 align="center">Qualification summary</h3>
	<table class="application-summary-table">
		<tr>
			<th rowspan="2">
			</th>
			<?php
				foreach ($headings as $heading) {
					echo $this->Html->tag('th', $heading[0], $heading[1]);
				}
			?>
		</tr>
		<tr>
			<?php
				foreach ($meetingDates as $meetingDate) {
					echo $this->Html->tag('th', date('d/m', $meetingDate));
				}
			?>
		</tr>
<?php
	$i = 0;
	if (!empty($applicationsInformation)) {
		$classes = array(
			'Total', 'NewSub', 'NewSub', 'NewSub', 'Check', 'Check', 'Check', 'Check', 'Eval', 'Eval', 'Eval', 'Review', 'Review', 'Review', 'Review', 'Review', 'Review', 'Meeting', 'Meeting', 'Meeting', 'Meeting', 'Meeting', 'Meeting', 'Meeting', 'Meeting', 'Accepted', 'Notified'
		);
		$totals = array();
		$tableRows = array();
		foreach ($applicationsInformation as $applicationInfo) {
			if (empty($applicationInfo['HeqfQualification']['s1_lkp_heqf_align_id'])) {
				continue;
			}

			$rowCells = array(
				$applicationInfo['HeqfQualification']['s1_lkp_heqf_align_id']
			);
			$cellCount = 0;
			foreach ($applicationInfo['Application'] as $key => $count) {
				if (!isset($totals[$key])) {
					$totals[$key] = 0;
				}
				$totals[$key] += $count;
				if (!in_array($key, $ignoreCells)) {
					$class = isset($classes[$cellCount]) ? $classes[$cellCount] : '';
					$rowCells[] = array(
						$count,
						array('class' => 'appStatus' . $class)
					);
					$cellCount++;
				}
			}
			$tableRows[] = $rowCells;
			?>
			<?php
		}

		$rowCells = array(
			array('Totals', array('class' => 'appTotals'))
		);
		foreach ($totals as $key => $total) {
			if (!in_array($key, $ignoreCells)) {
				$rowCells[] = array(
					$total,
					array('class' => 'appTotals')
				);
			}
		}
		$tableRows[] = $rowCells;

		echo $this->Html->tableCells($tableRows, null, null, true);
	}
?>
	</table>
</div>

<div class="totalList">
	Excluded applications:
	<ul>
		<li>
			New: <?php echo $totals['New']; ?>
		</li>
		<li>
			Institution review: <?php echo $totals['Institution review']?>
		</li>
		<li>
			Archived: <?php echo $totals['Archived']; ?>
		</li>
	</ul>
	Which gives a total of <strong><?php echo $totals['New'] + $totals['Institution review'] + $totals['Archived']; ?></strong> applications that have been excluded from the list below.
</div>