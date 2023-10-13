<?php	
	$data = (isset($processData)) ? $processData : $this->data;
	if(isset($data) && !empty($data['Application'])){
		$i = 0;
?>
	<div id="commentsList">
		<table style="margin:5px;">
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
			
			<?php
				

				if ($this->Heqf->isCatB($data)) {
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}
					$count = count($data['CompletedEvaluations']);

			?>		<?php foreach ($data['CompletedEvaluations'] as $key => $evaluation) { ?>
					<tr>
						<th colspan="2"><?php echo ($count > 1) ? 'Evaluator ' . ($key + 1) . ' comments' : 'Evaluator comments'; ?></th>
					</tr>			
					<tr>
						<th>
							Comment type
						</th>
						<th>
							Comment
						</th>
					</tr>			
					<?php 
						foreach ($this->Heqf->catBCommentFields as $questionType => $commentField) {
							if (!empty($evaluation[$commentField])) {
					?>
								<tr class="<?php echo $class; ?>">
									<td><?php echo $questionType; ?></td>
									<td><?php echo $evaluation[$commentField] ?></td>
								</tr>								
					<?php
							}
						}	
					}
					?>
			<?php
				} else {
					if (!empty($data['Application']['edited_evaluation_comments'])) {
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
								Evaluation comments
							</td>
							<td>
								<?php echo nl2br($data['Application']['edited_evaluation_comments']); ?>
							</td>
						</tr>
			<?php   }						
				}
			?>
			<?php
				if(!empty($data['Application']['checklisting_comments'])) {
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