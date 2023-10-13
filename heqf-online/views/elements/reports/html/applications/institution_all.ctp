<div class="dashboard">
<?php
	echo $this->element('reports/header');
?>
<h2>All programmes per institution</h2>
<br />
<?php

	/*
		Depending on role display the filter and results
			inst admin has different one, rest same
	*/
	echo '<div style="clear:both;"></div>';
	$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.id')  : '';
	if(Auth::checkRole('inst_admin') != 1){
		echo $this->element('search/institution_offerings_filter', array(
				'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
				'model' => $report['model'],
				'advancedOnly' => true,
				'searchText' => 'Filter ' . strtolower($report['name']),
				'clearSearch' => false
			)
		);
	}
	
	$this->set('title_for_layout', 'Report of all applications per institution');

	if(!empty($reportData)){
		$totalCount = 0;
		foreach($reportData as $countData){
			$totalCount += count($countData);
		}
		echo '<div style="float:right;font-size:12px;">Total applications: ' . $totalCount . '</div>';
?>
<h2>INSTITUTION NAME: <?php echo isset($this->params['named']['institution_id']) ? $Institution[$this->params['named']['institution_id']] : $Institution[$institution]; ?></h2>
<table class="offerings">
		<thead>
			<tr class="tableHead">
					<th rowspan="2">Institution Category</th>
					<th rowspan="2">Qualification reference number</th>
					<th rowspan="2">Original Qualification Name</th>
					<th rowspan="2">Authorised Qualification Name</th>
					<th rowspan="2">HEQSF reference number</th>
					<th rowspan="2">Abbreviation</th>
					<th rowspan="2">HEQSF Qual Type</th>
					<th rowspan="2">Designator</th>
					<th rowspan="1" align="center">Major Fields of Study</th>
					<th rowspan="2">SAQA qualification ID</th>
					<th rowspan="2">NQF Level</th>
					<th rowspan="1" colspan="3" align="center">NQF Credits</th>
					<th rowspan="1" align="center">Total Subsidy Units</th>
					<th rowspan="2">Funding Level</th>
					<th rowspan="2">Mode of Delivery (Contact/Distance)</th>
					<th rowspan="2">Outcome approval date</th>
					<th rowspan="2">Teachout date</th>
			</tr>
			<tr class="tableHead">
				<th>
					Description & CESM Code
				</th>
				<th>
					Total
				</th>
				<th>
					WIL/EL
				</th>
				<th>
					Research
				</th>
				<th>
					Total
				</th>
			</tr>
		</thead>
		<tbody id="tableBody">
<?php
			foreach($reportData as $qualType => $applications){
?>
				<tr class="rowHeading">
					<td colspan="19">
						<strong><?php echo isset($QualificationType[$qualType]) ? $QualificationType[$qualType] : ''; ?></strong>
					</td>
				</tr>
<?php
					foreach($applications as $application){
						$designatorValue = (isset($Designator[$application['lkp_designator_id']]) && $application['lkp_designator_id'] != 'Oth') ? $Designator[$application['lkp_designator_id']] : (
									 	(isset($Designator[$application['lkp_designator_id']]) && $application['lkp_designator_id'] == 'Oth') ? ($application['other_designator'] > ''  ? $Designator[$application['lkp_designator_id']] . ': ' . $application['other_designator'] : $Designator[$application['lkp_designator_id']]) : $application['lkp_designator_id']);
?>
						<tr>
							<td>
								<?php echo $application['s1_lkp_heqf_align_id']; ?>
							</td>
							<td>
								<?php echo $application['s1_qualification_reference_no']; ?>
							</td>
							<td>
								<?php echo $application['s1_qualification_title']; ?>
							</td>
							<td>
								<?php echo $application['qualification_title']; ?>
							</td>
							<td>
								<?php echo $application['heqf_reference_no']; ?>
							</td>
							<td>
								<?php echo $application['qualification_title_short']; ?>
							</td>
							<td>
								<?php echo isset($QualificationType[$qualType]) ? $QualificationType[$qualType] : ''; ?>
							</td>
							<td>
								<?php echo $designatorValue; ?>
							</td>
							<td>
								<?php
									$majors = $this->Heqf->reportMultiple($application['hemis_lkp_cesm3_code_id'], $HemisQualifier);
									echo $majors;
								?>
							</td>
							<td><?php echo $application['saqa_qualification_id']; ?></td>
							<td>
								<?php echo ($application['lkp_nqf_level_id'] > 0) ? $application['lkp_nqf_level_id'] : $application['s1_lkp_nqf_level_id']; ?>
							</td>
							<td>
								<?php echo ($application['credits_total'] > 0) ? $application['credits_total'] : $application['s1_credits_total']; ?>
							</td>
							<td>
								<?php echo $application['wil_el_credits']; ?>
							</td>
							<td>
								<?php echo $application['research_credits']; ?>
							</td>
							<td>
								<?php echo ($application['hemis_total_subsidy_units'] > 0) ? $application['hemis_total_subsidy_units'] : $application['s1_hemis_total_subsidy_units']; ?>
							</td>
							<td>
								<?php echo ($application['lkp_hemis_funding_level_id'] > 0) ? (isset($HemisFundingLevel[$application['lkp_hemis_funding_level_id']]) ? $HemisFundingLevel[$application['lkp_hemis_funding_level_id']] : $application['lkp_hemis_funding_level_id']) : (isset($HemisFundingLevel[$application['s1_lkp_hemis_funding_level_id']]) ? $HemisFundingLevel[$application['s1_lkp_hemis_funding_level_id']] : $application['s1_lkp_hemis_funding_level_id']) ; ?>
							</td>
							<td>
								<?php echo ($application['lkp_delivery_mode_id'] > 0) ? $DeliveryMode[$application['lkp_delivery_mode_id']] : $DeliveryMode[$application['s1_lkp_delivery_mode_id']]; ?>
							</td>
							<td>
								<?php echo $application['outcome_approval_date'] > '1970-01-01' ? date('d F Y', strtotime($application['outcome_approval_date'])) : ''; ?>
							</td>
							<td>
								<?php echo $application['s1_teachout_date'] > '1970-01-01' ? date('d F Y', strtotime($application['s1_teachout_date'])) : ''; ?>
							</td>
						</tr>
<?php
					}
			}
?>
		</tbody>
	</table>
<?php
	}
	else{
		if(!empty($this->params['named'])){
			echo '<p>There are no results matching the institution selected.</p>';
		}
		if(Auth::checkRole('inst_admin')){
			echo '<p>There are no results available for your institution.</p>';
		}
	}
?>
</div>