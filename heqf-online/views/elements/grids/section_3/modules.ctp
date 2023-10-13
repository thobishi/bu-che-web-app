<?php
	$moduleHeadings = '<tr>
					<th>Module</th>
					<th>NQF level</th>
					<th>Credits</th>
					<th>Year level</th>
					<th>Compulsory</th>
					<th>Electives</th>
					<th>Module status: Removed / Added / Modified / Unchanged</th>
				</tr>';
?>

<table class="offerings" id="programmeDesign">
	<thead>
		<tr>
			<th colspan="7" class="large">Programme design details</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$totalElective = 0;
			$totalCompulsoryCredits = 0;

			$modules = Set::combine($modules, '{n}.id', '{n}', '{n}.year');
			ksort($modules);
			foreach ($modules as $year => $yearModules) {
				echo '<tr><th colspan="7" class="medium">Modules for year ' . $year . '</th></tr>';
				echo $moduleHeadings;
				$yearModules = Set::sort(array_values($yearModules), '{n}.nqf_level_id', 'desc');
				foreach ($yearModules as $module) {
					$totalCompulsoryCredits += ($module['compulsory']) ? $module['InstitutionModule']['credits'] : 0;
					$totalElective += ($module['elective']) ? (int)$module['elective'] : 0;
					echo '<tr>';
					echo $this->element('grids/section_3/modules_fields', compact('module'));
					echo '</tr>';
				}
				echo '<tr class="row-separator"><td colspan="7">&nbsp;</td></tr>';
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"></td>
			<td><strong>Total Compulsory Credits: </strong><span id="compulsoryTotalCredits"><?php echo $totalCompulsoryCredits; ?></span></td>
			<td><strong>Total Elective Modules: </strong><span id="electivesTotal"><?php echo $totalElective; ?></span></td>
		</tr>
	</tfoot>
</table>