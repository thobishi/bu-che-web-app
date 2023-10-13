<?php
	$willRequired = $information['HeqfQualification']['s3_has_wil'] == '1' ? true : false;
?>
<div id="evaluation-tabs">
	<ul>
		<?php foreach ($information['CompletedEvaluations'] as $key => $evaluation) { ?>
			 <li><a href="#evaluation-<?php echo $key; ?>">Evaluation <?php echo $key + 1; ?></a></li>
		<?php } ?>
	</ul>
	<?php foreach ($information['CompletedEvaluations'] as $key => $evaluation) { ?>	
		<div id="evaluation-<?php echo $key; ?>">
			<table  id="eval_form">
				<tr>
					<th>Intititution (question-answer)</th>
					<th>Evaluation (criteria-answer)</th>
				</tr>
				<tr>
					<td width="50%">
						<?php
							if (isset($information['HeqfQualification']['s3_curriculum'])) {
								echo $this->Heqf->displaySectionThree('s3_curriculum', $information);
							}
						?>
					</td>
					<td  width="50%">
						<?php
							echo $this->Heqf->displayCatBEvaluation('s3_curriculum_lkp_outcome_id', $evaluation, 'Question 1');
						?>
					</td>
				</tr>
				<tr>
					<td>
						<br><br>
					</td>
				</tr>		
				<tr>
					<td>
						<?php
							if (isset($information['HeqfQualification']['s3_modules'])) {
								echo $this->Heqf->displaySectionThree('s3_modules', $information);
							}
						?>
					</td>
					<td>
						<?php
							echo $this->Heqf->displayCatBEvaluation('s3_modules_lkp_outcome_id', $evaluation, 'Question 2');
						?>			
					</td>
				</tr>
				<tr>
					<td>
						<br><br>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							if (isset($information['HeqfQualification']['s3_assessment'])) {
								echo $this->Heqf->displaySectionThree('s3_assessment', $information);
							}
						?>
					</td>
					<td>
						<?php
							echo $this->Heqf->displayCatBEvaluation('s3_assessment_lkp_outcome_id', $evaluation, 'Question 3');
						?>			
					</td>
				</tr>
				<tr>
					<td>
						<?php
							if (isset($information['HeqfQualification']['s3_learning_activities'])) {
								echo $this->Heqf->displaySectionThree('s3_learning_activities', $information);
							}
						?>
					</td>
					<td>
						<?php
							echo $this->Heqf->displayCatBEvaluation('s3_learning_activities_lkp_outcome_id', $evaluation, 'Question 4');
						?>			
					</td>
				</tr>
				<?php if ($willRequired) { ?>
				<tr>
					<td>
						<br><br>
					</td>
				</tr>	
				<tr>
					<td>
						<?php
							if (isset($information['HeqfQualification']['s3_workplace_explained'])) {
								echo $this->Heqf->displaySectionThree('s3_workplace_explained', $information);
							}
						?>
					</td>
					<td>
						<?php
							echo $this->Heqf->displayCatBEvaluation('s3_workplace_explained_lkp_outcome_id', $evaluation, 'Question 5');
						?>			
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td>
						<br><br>
					</td>
				</tr>	
				<tr>
					<td colspan="2">
						<?php
							echo $this->Heqf->displayCatBEvaluation('eval_lkp_outcome_id', $evaluation, 'Evaluation Outcome');
						?>			
					</td>
				</tr>
			</table>
		</div>
	<?php 
		}
	?>
</div>
<script>
	$(function() {
		$( "#evaluation-tabs" ).tabs();
	});
</script>