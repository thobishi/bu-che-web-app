<?php
	$data = array();
	
	if(!empty($processData['Application'])){
		foreach($processData['Application'] as $application){
			$title = (!empty($application['HeqfQualification']['qualification_title'])) ? $application['HeqfQualification']['qualification_title'] : $application['HeqfQualification']['s1_qualification_title'];

			$data[$AllApplicationOutcomes[$application['lkp_outcome_id']]][] = $title . ' (' . $application['HeqfQualification']['s1_qualification_reference_no'] . ')';
		}
	}
	if(!empty($data)){
?>
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span class="application_heading">Applications grouped by outcome</span>
		</div>
		<table>
				<tr>
					<th>
						Outcome
					</th>
					<th>
						Qualification title
					</th>
				</tr>
			<tbody>
<?php
			$count = 0;
			foreach($data as $outcome => $applicationTitles){
				$class = (($count++ % 2) == 0) ? 'altrow' : '';
				echo '<tr class="' . $class . '"><td><strong>' . $outcome . '</strong></td><td></td></tr>';
				foreach($applicationTitles as $title){
					$class = (($count++ % 2) == 0) ? 'altrow' : '';
					echo '<tr class="' . $class . '"><td></td><td>' . $title . '</td></tr>';
				}
			}
		}
?>
			</tbody>
		</table>
	</div>