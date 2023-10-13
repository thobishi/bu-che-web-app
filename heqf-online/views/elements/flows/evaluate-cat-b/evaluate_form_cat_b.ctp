<?php
	$format = array('before', 'label', 'error', 'between', 'input', 'after');
	$optionsy = array('Yes' => 'Yes','No' => 'No');
	$willRequired = $this->data['HeqfQualification']['s3_has_wil'] == '1' ? true : false;
	if( isset($this->params['referer'])
			&& strpos($this->params['referer'], 'list-process') ) {
		$format = array('before', 'label', 'between', 'input', 'after');
	}
?>

<?php
	echo $this->Form->hidden('Evaluation.id');
	$checkComments = 'None';
	if(isset($this->data['Application']['checklisting_comments']) && !empty($this->data['Application']['checklisting_comments'])){
		$checkComments = $this->data['Application']['checklisting_comments'];
	}
?>
<div id="alert" class="flash-messages">
	<div class="ui-state-good ui-corner-all"><b>Checklister comments:</b
		<p><?php echo $checkComments; ?></p>
	</div>
</div>
	

<table id="eval_form">
	<tr>
		<td width="50%">
			<?php
					if (isset($this->data['HeqfQualification']['s3_curriculum'])) {
						echo $this->Heqf->displaySectionThree('s3_curriculum', $this->data);
					}
			?>
		</td>
		<td width="50%">	
			<?php
				echo '<span><u><em><b>Criteria:</b></em></u></span><br><br>';
				echo '<p class = "bg-info">A.	The design maintains an appropriate balance of theoretical, practical and experiential knowledge and skills. It has sufficient disciplinary content and theoretical depth at the appropriate level, to serve its educational purposes. This design includes aspects of: learning outcomes, assessment criteria, degree of curriculum choice, modes of delivery, and ccompetencies expected of students who successfully complete the programme.</p>';

					echo '<span class="requiredFields"><span><b>Question 1:</b></span></span>';
					echo $this->Form->input('Evaluation.s3_curriculum_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $QuestionOutcome, 'format' => $format));
					echo $this->Form->input('Evaluation.s3_curriculum_comment', array('label' => '<b>Comments:</b>', 'type' => 'textarea'));								
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
					if (isset($this->data['HeqfQualification']['s3_modules'])) {
						echo $this->Heqf->displaySectionThree('s3_modules', $this->data);
					}
			?>
		</td>
		<td>
			<?php
				echo '<span><u><em><b>Criteria:</b></em></u></span><br><br>';
				echo '<p class = "bg-info">A.	Modules and/or courses in the programme are coherently planned with regard to content, level, credits, purpose, outcomes, rules of combination, relative weight and delivery.</p>';			
					echo '<span class="requiredFields"><span><b>Question 2:</b></span></span>';
					echo $this->Form->input('Evaluation.s3_modules_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $QuestionOutcome, 'format' => $format));
					echo $this->Form->input('Evaluation.s3_module_comment', array('label' => '<b>Comments:</b>', 'type' => 'textarea'));						
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
					if (isset($this->data['HeqfQualification']['s3_assessment'])) {
						echo $this->Heqf->displaySectionThree('s3_assessment', $this->data);
					}
			?>
		</td>
		<td>
			<?php
				echo '<span><u><em><b>Criteria:</b></em></u></span><br><br>';
				echo '<p class = "bg-info">A.	Assessment is an integral part of the teaching and learning process and is systematically and purposefully used to generate data for grading, ranking, selecting and predicting, as well as for providing timely feedback to inform teaching and learning and to improve the curriculum.<br>
					B.	The teaching and learning strategy is appropriate for the institutional type as reflected in its mission (programme types, research: teaching), mode(s) of delivery (contact / distance / e-learning), and its student composition (age, full-time / part-time, advantaged / disadvantaged), etc.
					</p>';			
					echo '<span class="requiredFields"><span><b>Question 3:</b></span></span>';
					echo $this->Form->input('Evaluation.s3_assessment_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $QuestionOutcome, 'format' => $format));
					echo $this->Form->input('Evaluation.s3_assessment_comment', array('label' => '<b>Comments:</b>', 'type' => 'textarea'));						
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
					if (isset($this->data['HeqfQualification']['s3_learning_activities'])) {
						echo $this->Heqf->displaySectionThree('s3_learning_activities', $this->data);
					}
			?>
		</td>
		<td>
			<?php
				echo '<span><u><em><b>Criteria:</b></em></u></span><br><br>';
				echo '<p class = "bg-info">A.	Modules and/or courses in the programme are coherently planned with regard to content, level, credits, purpose, outcomes, rules of combination, relative weight and delivery.  Outsourcing of delivery is not permitted.</p>';			
					echo '<span class="requiredFields"><span><b>Question 4:</b></span></span>';
					echo $this->Form->input('Evaluation.s3_learning_activities_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $QuestionOutcome, 'format' => $format));
					echo $this->Form->input('Evaluation.s3_learning_activities_comment', array('label' => '<b>Comments:</b>', 'type' => 'textarea'));						
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
					if (isset($this->data['HeqfQualification']['s3_guideline_explained'])) {
						echo $this->Heqf->displaySectionThree('s3_guideline_explained', $this->data);
					}
					if (isset($this->data['HeqfQualification']['s3_placement_explained'])) {
						echo $this->Heqf->displaySectionThree('s3_placement_explained', $this->data);
					}			
					if (isset($this->data['HeqfQualification']['s3_workplace_explained'])) {
						echo $this->Heqf->displaySectionThree('s3_workplace_explained', $this->data);
					}
			?>
		</td>
		<td>
			<?php
				echo '<span><u><em><b>Criteria:</b></em></u></span><br><br>';
				echo '<p class = "bg-info">A.	The coordination of workplace-based learning is done effectively in all components of applicable programmes. This includes an adequate infrastructure, effective communication, recording of progress made, monitoring, mentoring and assessment.</p>';									
					echo '<span"><span><b>Question 5:</b></span></span>';
					echo $this->Form->input('Evaluation.s3_workplace_explained_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $QuestionOutcome, 'format' => $format));
					echo $this->Form->input('Evaluation.s3_workplace_comment', array('label' => '<b>Comments:</b>', 'type' => 'textarea'));						
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
		<td colspan = '2'>
		      <table>
		      	<tr>
		      		<th>Question</th>
		      		<th>HEQSF-aligned and deemed accredited</th>
		      		<th>Not HEQSF-aligned</th>
		      		<th>Needs improvement</th>
		      	</tr>
		      	<tr class = "question1">
		      		<td>Question 1</td> 
		      		<td><div id ="question1_a" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		<td><div id ="question1_n" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		<td><div id ="question1_ni" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      	</tr>
		      	<tr  class = "question2">
		      		<td>Question 2</td>
		      		<td><div id ="question2_a" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		<td><div id ="question2_n" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		<td><div id ="question2_ni" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      	</tr>
		      	<tr class = "question3">
		      		<td>Question 3</td>
		      		 <td><div id ="question3_a" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		 <td><div id ="question3_n" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		 <td><div id ="question3_ni" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      	</tr>
		      	<tr class = "question4">
		      		<td>Question 4</td>
		      		 <td><div id ="question4_a" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		 <td><div id ="question4_n" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		 <td><div id ="question4_ni" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      	</tr>
		      	<?php if ($willRequired) { ?>
		      	<tr class = "question5">
		      		<td>Question 5</td>
		      		<td><div id ="question5_a" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		<td><div id ="question5_n" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      		<td><div id ="question5_ni" style = "display:none;"><?php echo $this->Html->image('check_mark.gif'); ?></div></td>
		      	</tr>
		      	<?php } ?>
		      </table>			
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
				$evalCommentError = (($this->data['Evaluation']['eval_lkp_outcome_id'] == 'nir' || $this->data['Evaluation']['eval_lkp_outcome_id'] == 'ni') && empty($this->data['Evaluation']['eval_outcome_comment'])) && ($this->data['Evaluation']['eval_status_id'] == 'Request' || $this->data['Evaluation']['eval_status_id'] == 'Complete') ? true : false;
				echo '<span class="requiredFields"><span><b>Recommended Evaluation Outcome:</b></span></span>';
				echo $this->Form->input('Evaluation.eval_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $FinalOutcome));
				echo $this->Form->input('Evaluation.eval_outcome_comment', array('label' => '<b>Evaluation Recommendations/Suggestions:</b>', 'type' => 'textarea', 'after' =>  $evalCommentError ? '<div class ="error-message">It is required to enter an evaluation recommendation/Suggestion</div>' : ''));
			?>
		</td>
		<td>
			<?php
				echo '<p id="complete-review-alert" class = "bg-danger">Please select <em><strong>Ready for review/Request second evaluation</strong></em> below when you are satisfied with your evaluation.  The application will be automatically returned to the administrator when you save.</span></span></p>';
				echo $this->Form->input('Evaluation.eval_status_id', array('label' => '<span class="requiredFields"><span><strong>Evaluation Status:</strong>', 'options' => $EvaluationStatus, 'format' => $format , 'selected' => $this->data['Evaluation']['request_second_evaluation'] == '1' ? 'Request' : $this->data['Evaluation']['eval_status_id']));
				echo $this->Form->input('Evaluation.request_second_evaluation_comment', array('label' => '<b>Please indicate why you request a second evaluation</b>', 'type' => 'textarea', 'div' => 'secondEvalRequestComment', 'after' => '<div class ="error-message">It is required to indicate why you request a second evaluation</div>'));
			?>
		</td>		
	</tr>
</table>
<script>
	$(function() {
		var mapId = {
		  'data[Evaluation][s3_curriculum_lkp_outcome_id]' : 'question1',
		  'data[Evaluation][s3_modules_lkp_outcome_id]' : 'question2',
		  'data[Evaluation][s3_assessment_lkp_outcome_id]' : 'question3' ,
		  'data[Evaluation][s3_learning_activities_lkp_outcome_id]' : 'question4' ,
		  'data[Evaluation][s3_workplace_explained_lkp_outcome_id]' : 'question5'
		},
		completeReviewAlert = "NOTE: Application will be returned to administrator when saving.\nTo keep this application select Evaluation status: Evaluating";


		$('input:radio').on('change', function() {		
			var radioValue = $(this).filter(':checked').val();
			var radioName = $(this).filter(':checked').attr('name');
			var divId = $("#" + mapId[radioName] + "_" + radioValue);	
			divId.show().parent().siblings().find('div').hide();
			
		}); 
		 
		 $('input:radio:checked').each(function(){
		 	var radioValue = $(this).val();
		 	var radioName = $(this).attr('name');
		 	var divId = $("#" + mapId[radioName] + "_" + radioValue);
		 	divId.show().parent().siblings().find('div').hide();
		 });


			 
		// $('#EvaluationEvalStatusId').val('Request');
		var evalStatusValue = $('#EvaluationEvalStatusId').val();
		
		if (evalStatusValue != 'Request') {
			$('.secondEvalRequestComment').hide();
		} 
		
		$('#EvaluationEvalStatusId').on('change', function (e){
			var 
				$this = $(this);
				if($this.val() === 'Request' || $this.val() === 'Complete') {
					alert(completeReviewAlert);
				}
			$('.secondEvalRequestComment').toggle($(this).val() == 'Request');
		});

	});			
</script>

		
			