<div class="dashboard">
	<?php
		echo $this->element('reports/header');
		$categories = array(
			'A', 'B', 'C'
		);
	?>
	<h2>Outcome summary per institution</h2>
	
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
	?>
	<?php if (!empty($reportData)) { ?>
		<div id="accordion">
	<?php foreach ($reportData as $instInfo) { ?>
		<h3>
			<a href="#">Institution: <?php echo $instInfo['Institution']['hei_name']; ?></a>
		</h3>
		<div>
		<?php foreach ($categories as $category) { ?>
			<p>
				Number of category <?php echo $category; ?> applications received: 
				<?php echo $instInfo['Application']['category_' . $category . '_total']; ?>
			</p>
			<table width="100%">
				<thead>
					<tr class="tableHead">
						<th>
							Outcome
						</th>
						<th>
							Category
						</th>
						<th>
							Number
						</th>
					</tr>
				</thead>
				<tbody id="tableBody">
					<?php
					$count = 0;
					foreach ($categories as $subCategory) {
						$class = '';
						if ($count++ % 2 == 0) {
							$class = 'altrow';
						}
					?>
					<tr class="<?php echo $class; ?>">
						<td>
							<?php echo ($count == 1) ? 'Deemed accredited' : '';?>
						</td>
						<td>
							<?php echo $subCategory; ?>
						</td>
						<td>
							<?php echo $instInfo['Application']['accredited_' . $category . '_' . $subCategory . '_total']; ?>
						</td>
					</tr>
					<?php
					}
					$count = 0;
					foreach ($categories as $subCategory) {
						$class = 'altrow';
						if ($count++ % 2 == 0) {
							$class = '';
						}
					?>
						<tr class="<?php echo $class; ?>">
							<td>
								<?php echo ($count == 1) ? 'Re-categorised' : '';?>
							</td>
							<td>
								<?php echo $subCategory; ?>
							</td>
							<td>
								<?php echo $instInfo['Application']['re_categorised_' . $category . '_' . $subCategory]; ?>
							</td>
						</tr>
					<?php } ?>
					<tr class="altrow">
						<td>
							Not HEQSF-aligned
						</td>
						<td>
							<?php echo $category; ?>
						</td>
						<td>
							<?php echo $instInfo['Application']['not_aligned_' . $category]; ?>
						</td>
					</tr>
					<tr>
						<td>
							No outcome (not processed yet)
						</td>
						<td>
							<?php echo $category; ?>
						</td>
						<td>
							<?php echo $instInfo['Application']['no_outcome_' . $category]; ?>
						</td>
					</tr>
					<tr>
						<td>
							Archived
						</td>
						<td>
							<?php echo $category; ?>
						</td>
						<td>
							<?php echo $instInfo['Application']['archived_' . $category]; ?>
						</td>
					</tr>					
				</tbody>
			</table>
		<?php } ?>
		</div>
	<?php } ?>
		</div>
	<?php }	else { ?>
			<p>There is no data for this report.</p>
	<?php } ?>
</div>

<script>
	$(function() {
		$( "#accordion" ).accordion();
	});
</script>