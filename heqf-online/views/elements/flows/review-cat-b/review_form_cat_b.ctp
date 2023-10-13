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
				$disableValue = array('a');
				$reviewOptions = $ReviewOutcome;
				$reviewAttributes=array('legend'=>false, 'value' => false);

				echo $this->Form->label('Application.review_outcome_id', '<span><b>Review Outcome:</b></span>', array('class' => 'requiredFields'));
				foreach ( $reviewOptions as $key => $value ) {
					echo $this->Form->radio('Application.review_outcome_id',
						array($key => $value),
						in_array($key, $disableValue) && $needImprovement ? $reviewAttributes + array('disabled' => true) : $reviewAttributes
					);
				}
				
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
		
			