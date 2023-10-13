<?php
	$this->set('title_for_layout', 'Report - HEQSF alignment outcomes per institution');
	$this->set('filename', 'Report - HEQSF alignment outcomes per institution');

	if(!empty($reportData)){
		$i = 0;
		foreach ($reportData as $institution => $data) {
		?>
			<h3>
				Institution: <?php echo $institution; ?>
			</h3>
			<table cellpadding="0" cellspacing="0">
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
						?>
							<tr>
								<td><?php echo $outcome; ?></td>
								<td><?php echo $category; ?></td>
								<td><?php echo count($applications); ?></td>
							</tr>
						<?php
							$totalCount += count($applications);
						}
					}
		?>			<tr>
						<td>Total number of applications submitted</td>
						<td></td>
						<td><?php echo $totalCount; ?></td>
					</tr>
				</tbody>
			</table>
			<table cellpadding="0" cellspacing="0">
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
			<div class="page-break"></div>
			<?php
		}
	}
	else{
?>
		<p>There is no data for this report.</p>
<?php
	}
?>

<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false
		});
	});
</script>