<?php
	$isProceeding = $this->data['Application']['application_status'] == 'Proceeding' ? true : false;
	if($isProceeding) { 
		$reviewArr = $this->Heqf->buildReviewHistory($this->data);
?>
<div id="review-tabs">
	<ul>
		<?php foreach ($reviewArr as $key => $review) {?>

			 <li><a href="#review-<?php echo $key; ?>"><?php echo $review['type']?></a></li>
		<?php } ?>
	</ul>

<?php foreach ($reviewArr as $key => $review) { ?>	
		<div id="review-<?php echo $key; ?>">
			<table  id="eval_form">
				<tr>
					<td width="50%">
						<?php
							echo $this->Heqf->displayReviewHistory($review);
						?>
					</td>
				</tr>
			</table>
		</div>
<?php } ?>
</div>
		<table id="eval_form">
			<tr>
				<td>
					<?php
						$proceedingType = $this->Heqf->getProceedingTypeDesc($this->data['ReviewProceeding']['proceeding_type_id']);
						$proc_lkp_outcome_id = $this->data['ReviewProceeding']['proc_lkp_outcome_id'];
						$proc_comments = $this->data['ReviewProceeding']['proc_comments'];
						echo $this->Form->hidden('ReviewProceeding.id');
						echo $this->Form->label('ReviewProceeding.proc_lkp_outcome_id', '<span><b>' . $proceedingType . ' Outcome:</b></span>', array('class' => 'requiredFields'));
						echo $this->Form->radio('ReviewProceeding.proc_lkp_outcome_id', $ReviewOutcome, array('legend' => false, 'value' => $proc_lkp_outcome_id));
					?>
				</td>
			</tr>
			<tr>
				<td>
				<?php
					echo $this->Form->input('ReviewProceeding.proc_comments', array(
						'label' => '<b>Comment for email to user:</b>', 
						'type' => 'textarea', 
						'after' => (($proc_lkp_outcome_id == 'ni' || $proc_lkp_outcome_id == 'nr') && $proc_comments == '') ? '<div class ="error-message">It is required to fill the comment field</div>' : ''
						)
					);
					?>
				</td>
			</tr>
		</table>
<?php	} else { ?>
		<table id="eval_form">
			<tr>
				<td>
					<?php
						
						$disabled = '';
						$needImprovement = false;
						$commentFields = array('s3_curriculum_lkp_outcome_id', 's3_modules_lkp_outcome_id', 's3_assessment_lkp_outcome_id');
						$review_outcome_id = $this->data['Application']['review_outcome_id'];

						foreach ($commentFields as $key => $commentField) {
							foreach ($this->data['CompletedEvaluations'] as $index => $evaluation) {
								if (isset($evaluation[$commentField]) && $evaluation[$commentField] == 'ni') {
									$needImprovement = true;
								}
							}
						}
						/* Uncomment this in case CHE wants to disable the aligned outcome for Evaluation with "NI" outcomes*/
						/*if ($needImprovement){
							unset($ReviewOutcome['a']);
						}*/
						// $disableValue = array('a');
				
						$reviewOptions = $ReviewOutcome;
						$reviewAttributes = array('legend' => false, 'value' => $review_outcome_id);

						echo $this->Form->label('Application.review_outcome_id', '<span><b>Review Outcome:</b></span>', array('class' => 'requiredFields'));
						echo $this->Form->radio('Application.review_outcome_id', $reviewOptions, $reviewAttributes);
						/*foreach ( $reviewOptions as $key => $value ) {
							echo $this->Form->radio('Application.lkp_outcome_id',
								array($key => $value),
								in_array($key, $disableValue) && $needImprovement ? $reviewAttributes + array('disabled' => true) : $reviewAttributes
							);
						}*/
						
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
						echo $this->Form->input('Application.review_comments', array(
							'label' => '<b>Comment for email to user:</b>', 
							'type' => 'textarea', 
							'after' => ($review_outcome_id == 'ni' || $review_outcome_id == 'nr') ? '<div class ="error-message">It is required to fill the comment field</div>' : ''
							)
						);
					?>
				</td>
			</tr>
		</table>

<?php	} ?>
<script>
	$(function() {
		$( "#review-tabs" ).tabs();
	});
</script>
			