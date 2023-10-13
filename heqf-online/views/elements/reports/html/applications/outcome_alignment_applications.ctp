<div class="dashboard">
<?php
	echo $this->element('reports/header');
?>
<h2>HEQSF alignment outcomes per institution</h2>
<?php

	/*
		Depending on role display the filter and results
			inst admin has different one, rest same
	*/
	echo '<div style="clear:both;"></div>';
	$institution = (Auth::checkRole('inst_admin')) ? Auth::get('Institution.hei_code')  : '';
	if(Auth::checkRole('inst_admin') != 1){
		echo $this->element('search/outcome_alignment_report_filter', array(
				'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
				'model' => $report['model'],
				'advancedOnly' => true,
				'searchText' => 'Filter ' . strtolower($report['name']),
				'clearSearch' => false
			)
		);
	}

	$this->set('title_for_layout', 'Report of HEQSF alignment applications');

	if(!empty($reportData)){
?>
		<div id="accordion">
			<?php
			$i = 0;
			foreach ($reportData as $institution => $data) {
			?>
				<h3>
					<a href="#">Institution: <?php echo $institution; ?></a>
				</h3>
				<div>
					<table>
						<thead>
							<tr class="tableHead">
								<th>Outcome</th>
								<th>Category</th>
								<th>Number</th>
							</tr>
						</thead>
						<tbody id="tableBody">
				<?php
							$totalCount = 0;
							foreach($data as $outcome => $catData){
								foreach($catData as $category => $applications){
									$class = '';
									if ($i++ % 2 == 0) {
										$class = 'altrow';
									}
								?>
									<tr <?php echo 'class="'.$class.'"';?>>
										<td><?php echo $outcome; ?></td>
										<td><?php echo $category; ?></td>
										<td><?php echo count($applications); ?></td>
									</tr>
								<?php
									$totalCount += count($applications);
								}
							}
							$class = '';
							if ($i % 2 == 0) {
								$class = 'altrow';
							}
				?>			<tr <?php echo 'class="'.$class.'"';?>>
								<td>Total number of applications submitted</td>
								<td></td>
								<td><?php echo $totalCount; ?></td>
							</tr>
						</tbody>
					</table>
					<table>
						<thead>
							<tr class="tableHead">
								<th>Existing qualification name</th>
								<th>Aligned qualification name</th>
								<th>Qualification reference number</th>
								<th>HEQSF reference number</th>
								<th>SAQA qualification ID</th>
								<th>NQF</th>
								<th>Total credits</th>
								<th>Category</th>
								<th>Outcome</th>
							</tr>
						</thead>
						<tbody id="tableBody">
						<?php
							foreach($data as $outcome => $catData){
								foreach($catData as $category => $applications){
									foreach($applications as $application){
										$class = '';
										if ($i++ % 2 == 0) {
											$class = 'altrow';
										}
								?>
										<tr <?php echo 'class="'.$class.'"';?>>
											<td><?php echo $application['Existing qualification name']; ?></td>
											<td><?php echo $application['Aligned qualification name']; ?></td>
											<td><?php echo $application['Qualification reference number']; ?></td>
											<td><?php echo $application['HEQSF reference number']; ?></td>

											<td><?php echo $application['SAQA qualification ID']; ?></td>
											<td>
												<?php
													$NqfLevelDesc = isset($NqfLevel[$application['NQF']]) ? $NqfLevel[$application['NQF']] : '';
													echo $NqfLevelDesc;
												?>
											</td>
											<td><?php echo $application['Total credits']; ?></td>
											
											<td><?php echo $category; ?></td>
											<td><?php echo $outcome; ?></td>
										</tr>
								<?php
									}
								}
							}
						?>
						</tbody>
					</table>
				</div>
				<?php
			} 
			?>
		</div>
<?php
	}
	else{
?>
		<p>There is no data for this report.</p>
<?php
	}
?>
</div>
<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false
		});
	});
</script>