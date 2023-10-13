<div class="dashboard">
<?php
	echo $this->element('reports/header');
	$this->set('title_for_layout', 'List of outcomes per institution');
?>
<h2>List of outcomes per institution</h2>
<?php
	echo '<div style="clear:both;"></div>';
	echo $this->element('search/outcomes_filter', array(
			'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
			'model' => $report['model'],
			'advancedOnly' => true,
			'searchText' => 'Filter ' . strtolower($report['name']),
			'clearSearch' => false
		)
	);

	if(!empty($reportData)){
	?>
		<div id="accordion">
	<?php
			foreach($reportData as $instName => $data){
	?>
			<h3>
				<a href="#">Institution: <?php echo $instName; ?></a>
			</h3>
			<div>
			<?php
				foreach($data as $outcome => $info){
			?>
					<table>
						<tr>
							<th colspan="10">
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
						$i = 0;
						foreach($info as $application){
							$class = '';
							if ($i++ % 2 == 0) {
								$class = 'altrow';
							}
					?>
							<tr class="<?php echo $class; ?>">
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
			</div>
	<?php
			}
	?>
		</div>
	<?php
		}
		else{ ?>
			<p>There is no data for this report.</p>
	<?php }
	?>
</div>

<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false
		});
	});
</script>