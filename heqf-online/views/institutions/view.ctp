<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Outcomes summary</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading">
		<?php
				$instName = $instData['Institution']['hei_name'] . ' (' . $instData['Institution']['hei_code'] . ')';
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$meetingDate = (!empty($this->params['named']['date'])) ? $this->params['named']['date'] : '';
				echo 'HEQC meeting date <strong>' . $meetingDate . '</strong><br />';
		?>
	</div>
</div>

<?php

	$data = array();
	
	if(!empty($processData)){
		foreach($processData as $row){
			$title = (!empty($row['Application']['HeqfQualification']['qualification_title'])) ? $row['Application']['HeqfQualification']['qualification_title'] : $row['Application']['HeqfQualification']['s1_qualification_title'];

			$data[$outcomes[$row['Proceeding']['proc_lkp_outcome_id']]][] = $title . ' (' . $row['Application']['HeqfQualification']['s1_qualification_reference_no'] . ')';
		}
	}
	if(!empty($data)){
?>
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span class="application_heading">Proceedings grouped by outcome</span>
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