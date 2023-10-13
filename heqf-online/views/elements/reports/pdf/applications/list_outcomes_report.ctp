<?php
	$this->set('title_for_layout', 'Report - List of outcomes per institution');
	$this->set('filename', 'Report - List of outcomes per institution');
	$this->setOption('orientation', 'Landscape');
	
	
		if(!empty($reportData)){
			foreach($reportData as $instName => $data){
	?>
			<h3>
				Institution: <?php echo $instName; ?>
			</h3>
			<?php
				foreach($data as $outcome => $info){
			?>
					<table>
						<tr>
							<th colspan="8">
								Outcome: <?php echo $outcome;?>
							</th>
							<th>
								Total: <?php echo count($info);?>
							</th>
						</tr>
						<tr>
							<th>
								Existing qualification name
							</th>
							<th>
								Aligned qualification name
							</th>
							<th>
								Qualification title abbreviation
							</th>
							<th>
								SAQA qualification ID
							</th>
							<th>
								NQF
							</th>
							<th>
								Total credits
							</th>
							<th>
								CESM
							</th>
							<th>
								Mode of delivery
							</th>
							<th>
								Major field of study
							</th>
							<th>
								Category
							</th>
							<th>
								Outcome
							</th>
						</tr>
					<?php
						foreach($info as $application){
					?>
							<tr>
								<td>
									<?php echo $application['Existing qualification name']; ?>
								</td>
								<td>
									<?php echo $application['Aligned qualification name']; ?>
								</td>
								<td>
									<?php echo $application['Qualification title abbreviation']; ?>
								</td>
								<td>
									<?php echo $application['SAQA qualification ID']; ?>
								</td>
								<td>
									<?php
										$NqfLevelDesc = isset($NqfLevel[$application['NQF']]) ? $NqfLevel[$application['NQF']] : '';
										echo $NqfLevelDesc;
									?>
								</td>
								<td>
									<?php echo $application['Total credits']; ?>
								</td>
								<td>
									<?php 
										$cesms = $this->Heqf->reportMultiple($application['CESM'], $CesmCode);
										echo $cesms;
									?>
								</td>
								<td>
									<?php
										$deliveryModeDesc = isset($DeliveryMode[$application['Mode of delivery']]) ? $DeliveryMode[$application['Mode of delivery']] : '';
										echo $deliveryModeDesc;
									?>
								</td>
								<td>
									<?php 
										$majors = $this->Heqf->reportMultiple($application['Major field of study'], $HemisQualifier);
										echo $majors;
									?>
								</td>
								<td>
									<?php echo $application['Category']; ?>
								</td>
								<td>
									<?php echo $outcome; ?>
								</td>
							</tr>
					<?php
						}
					?>
					</table>
			<?php
				}
			?>
			<div class="page-break"></div>
	<?php
			}
		}
?>