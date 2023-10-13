<?php
	$categories = array(
		'A', 'B', 'C'
	);
	if(!empty($reportData)){
		foreach($reportData as $instInfo){
		?>
		<h3>
			Institution: <?php echo $instInfo['Institution']['hei_name']; ?>
		</h3>
		<?php
			foreach($categories as $category){
		?>
		<p>Number of category <?php echo $category; ?> applications received: <?php echo $instInfo['Application']['category_' . $category .'_total']; ?></p>
		<table cellpadding="0" cellspacing="0" width="100%">
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
				foreach($categories as $subCategory){
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
						<?php echo $instInfo['Application']['accredited_' . $category . '_' . $subCategory. '_total']; ?>
					</td>
				</tr>
				<?php
				}
				$count = 0;
				foreach($categories as $subCategory){
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
				<?php
				}
				?>
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
			</tbody>
			</table>
		<?
			}
		?>
		<div class="page-break"></div>
		<?php
		}
	}
	$this->set('title_for_layout', 'Report - Outcome summary per institution');
	$this->set('filename', 'Report - Outcome summary per institution');
	?>