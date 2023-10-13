<?php	
	$data = (isset($processData)) ? $processData : $this->data;

	if(isset($data) && !empty($data['Application'])){
		$i = 0;
?>
	<div id="commentsList">
		<table style="margin:5px;">
			<?php
				$proceedingArr = $this->Heqf->getProceedingHistory($data['Application']['id']);
				if(!empty($proceedingArr)){
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}
			?>
					<tr>
						<th>
							Comment type
						</th>
						<th>
							Comment
						</th>
					</tr>
			<?php
					foreach ($proceedingArr as $proceeding) {
						$proceedingType = $this->Heqf->getProceedingTypeDesc($proceeding['Proceeding']['proceeding_type_id']);
						?>
							<tr class="<?php echo $class; ?>">
								<td><?php echo $proceedingType . ' Comments'; ?></td>
								<td><?php echo $proceeding['Proceeding']['proc_comments'] ?></td>
							</tr>								
						<?php
					}
				}
			?>

			<?php
				if(!empty($data['Application']['review_comments'])) {
			?>
					<tr>
						<th>
							Comment type
						</th>
						<th>
							Comment
						</th>
					</tr>	
			<?php				
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}
			?>
					<tr class="<?php echo $class; ?>">
						<td>
							Review comments
						</td>
						<td>
							<?php echo nl2br($data['Application']['review_comments']); ?>
						</td>
					</tr>					
			<?php } ?>

			<?php if (!empty($data['Application']['edited_evaluation_comments'])) { ?>
					<tr>
						<th>
							Comment type
						</th>
						<th>
							Comment
						</th>
					</tr>
			<?php						
						$class = '';
						if ($i++ % 2 == 0) {
							$class = 'altrow';
						}									
			?>
						<tr class="<?php echo $class; ?>">
							<td>
								Evaluation comments
							</td>
							<td>
								<?php echo nl2br($data['Application']['edited_evaluation_comments']); ?>
							</td>
						</tr>
			<?php   }	?>

			<?php
				if(!empty($data['Application']['checklisting_comments'])  && $data['Application']['returned_from_checklisting']) {
			?>
					<tr>
						<th>
							Comment type
						</th>
						<th>
							Comment
						</th>
					</tr>	
			<?php						
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}
			?>
					<tr class="<?php echo $class; ?>">
						<td>
							Checklisting comments
						</td>
						<td><?php echo nl2br($data['Application']['checklisting_comments']); ?></td>
					</tr>
			<?php }	?>			
		</table>
	</div>
<?php
	}
?>