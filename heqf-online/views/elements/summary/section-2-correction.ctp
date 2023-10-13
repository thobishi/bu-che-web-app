<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Application summary</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading">
		<?php
			if(empty($this->data) && isset($processData)){
				$instName = $processData['Institution']['hei_name'] . ' (' . $processData['Institution']['hei_code'] . ')';
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$title = (!empty($processData['HeqfQualification']['qualification_title'])) ? $processData['HeqfQualification']['qualification_title'] : $processData['HeqfQualification']['s1_qualification_title'];
				echo 'Qualification reference <strong>' . $title . ' ('.$processData['HeqfQualification']['s1_qualification_reference_no'].')</strong>';
			}
			else{
				$instName = $this->data['Institution']['hei_name'];
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$title = (!empty($this->data['HeqfQualification']['qualification_title'])) ? $this->data['HeqfQualification']['qualification_title'] : $this->data['HeqfQualification']['s1_qualification_title'];
				echo 'Qualification reference <strong>' . $title . ' ('.$this->data['HeqfQualification']['s1_qualification_reference_no'].')</strong>';
			}
		?>
	</div>
</div>
<?php
	if(isset($historyData) && !empty($historyData)){
		$filteredHistory = array();
		$lkpCorrectionFields = array('lkp_cesm1_code_id' , 'hemis_lkp_cesm3_code_id', 'qualification_title', 'qualification_title_short', 'lkp_designator_id', 'credits_total');
		foreach($historyData as $key => $data){			
			foreach ($lkpCorrectionFields as $lkpCorrectionField) {
				if(strpos($data['AuditLog']['data'], $lkpCorrectionField) && !isset($filteredHistory[$key])){
					$filteredHistory[$key] = $historyData[$key];
				}				
			}						
	
		}
		if(!empty($filteredHistory)){
?>
<div class="reportActions btn-group">
	<?php
		echo $this->Html->link(__('Show/hide Sections 2 corrections history', true), array(), array('class' => 'btn', 'id' => 'historyBtn'));
	?> 
</div>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary historyDiv">	
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Section 2 Corrections History</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading history_details">

				<div class="history_table">
					<table>
						<thead>
							<tr class = "tblHistoryHead">
								<th colspan= "2">Qualification title</th>
								<th colspan= "2">Qualification Abbreviation</th>
								<th colspan= "2">CESM</th>
								<th colspan= "2">Major field of study</th>
								<th colspan= "2">Qualification designator</th>
								<th colspan= "2">Total credits</th>
								<th rowspan = "2">Modified by</th>
							</tr>
							<tr class = "tblHistorySubHead">
								<th>Before</th>
								<th>After</th>
								
								<th>Before</th>
								<th>After</th>
								
								<th>Before</th>
								<th>After</th>
								
								<th>Before</th>
								<th>After</th>

								<th>Before</th>
								<th>After</th>
								
								<th>Before</th>
								<th>After</th>														
							</tr>
						</thead>
						<tbody id="tableBody">
		<?php		
				foreach($filteredHistory as $data){
					$dataChangedArr	= json_decode($data['AuditLog']['data'], true);			
					/*$cesmCodeBefore = isset($dataChangedArr['lkp_cesm1_code_id']['before']) ? $this->Heqf->getMultipleSelectValues($cesm_codes, $dataChangedArr['lkp_cesm1_code_id']['before']) : '';
					$cesmCodeAfter = isset($dataChangedArr['lkp_cesm1_code_id']['before']) ? $this->Heqf->getMultipleSelectValues($cesm_codes, $dataChangedArr['lkp_cesm1_code_id']['after']): '';
					
					$fieldOfStudyCodeBefore = isset($dataChangedArr['hemis_lkp_cesm3_code_id']['before']) ? $this->Heqf->getMultipleSelectValues($hemis_qualifiers, $dataChangedArr['hemis_lkp_cesm3_code_id']['before']) : '';
					$fieldOfStudyCodeAfter = isset($dataChangedArr['hemis_lkp_cesm3_code_id']['after']) ? $this->Heqf->getMultipleSelectValues($hemis_qualifiers, $dataChangedArr['hemis_lkp_cesm3_code_id']['after']) : '';*/
					$cesmCodeBefore = isset($dataChangedArr['lkp_cesm1_code_id']['before']) ? $this->Heqf->reportMultiple($dataChangedArr['lkp_cesm1_code_id']['before'], $cesm_codes): '';
					$cesmCodeAfter = isset($dataChangedArr['lkp_cesm1_code_id']['after']) ? $this->Heqf->reportMultiple($dataChangedArr['lkp_cesm1_code_id']['after'], $cesm_codes): '';
					
					$fieldOfStudyCodeBefore = isset($dataChangedArr['hemis_lkp_cesm3_code_id']['before']) ? $this->Heqf->reportMultiple($dataChangedArr['hemis_lkp_cesm3_code_id']['before'], $hemis_qualifiers) : '';
					$fieldOfStudyCodeAfter = isset($dataChangedArr['hemis_lkp_cesm3_code_id']['after']) ? $this->Heqf->reportMultiple($dataChangedArr['hemis_lkp_cesm3_code_id']['after'], $hemis_qualifiers) : '';
				
							echo '<tr>';
							
								echo '<td>';
									echo isset($dataChangedArr['qualification_title']['before']) ? $dataChangedArr['qualification_title']['before'] : '';
								echo '</td>';
								echo '<td>';
									echo isset($dataChangedArr['qualification_title']['after']) ? $dataChangedArr['qualification_title']['after'] : '';
								echo '</td>';
								

								echo '<td>';
									echo  isset($dataChangedArr['qualification_title_short']['before']) ? $dataChangedArr['qualification_title_short']['before'] : '';
								echo '</td>';
								echo '<td>';
									echo  isset($dataChangedArr['qualification_title_short']['after']) ? $dataChangedArr['qualification_title_short']['after'] : '';
								echo '</td>';
								
								echo '<td>';
									echo $cesmCodeBefore;
								echo '</td>';
								echo '<td>';
									echo $cesmCodeAfter;
								echo '</td>';								

								echo '<td>';
									echo $fieldOfStudyCodeBefore;
								echo '</td>';
								echo '<td>';
									echo $fieldOfStudyCodeAfter;
								echo '</td>';

								echo '<td>';
									echo  isset($dataChangedArr['lkp_designator_id']['before']) ? $designators[$dataChangedArr['lkp_designator_id']['before']] : '';
								echo '</td>';
								echo '<td>';
									echo  isset($dataChangedArr['lkp_designator_id']['after']) ? $designators[$dataChangedArr['lkp_designator_id']['after']] : '';
								echo '</td>';
								echo '<td>';
									echo  isset($dataChangedArr['credits_total']['before']) ? $dataChangedArr['credits_total']['before'] : '';
								echo '</td>';
								echo '<td>';
									echo  isset($dataChangedArr['credits_total']['after']) ? $dataChangedArr['credits_total']['after'] : '';
								echo '</td>';								

								echo '<td>';
									echo $data['User']['first_name'] . ' ' . $data['User']['last_name'] . " on " . $data['AuditLog']['created'];
								echo '</td>';								
							echo '</tr>';
					}		
							
						echo '</tbody>';
					echo '</table>';
				echo '</div>';
			
				

	echo '</div>';
echo '</div>';

		}

	}
/*	echo $this->Html->script(array(
		'/js/application/section-2-correction'
	));*/
