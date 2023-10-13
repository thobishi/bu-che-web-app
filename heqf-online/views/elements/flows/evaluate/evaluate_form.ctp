<?php
	$format = array('before', 'label', 'error', 'between', 'input', 'after');
	$optionsy = array('Yes' => 'Yes','No' => 'No');
	if( isset($this->params['referer'])
			&& strpos($this->params['referer'], 'list-process') ) {
		$format = array('before', 'label', 'between', 'input', 'after');
	}


?>

<table id="eval_form">
	<tr>
		<td width="50%">
			<?php
				echo $this->Form->hidden('Evaluation.id');
				echo '<span class="requiredFields"><span><b>1. Is the application for HEQSF alignment correctly categorised?</b></span></span>';
				echo $this->Form->input('Evaluation.application_correctly_categorised', array('type' => 'radio', 'legend'=> false, 'options' => $optionsy, 'format' => $format));
			?>
		</td>
		<td width="50%">
			<div id="propCat">
			<?php
				$selectedCat = (!empty($this->data['Evaluation']['eval_lkp_heqf_align_id'])) ? $this->data['Evaluation']['eval_lkp_heqf_align_id'] : $this->data['HeqfQualification']['s1_lkp_heqf_align_id'];
				echo '<span class="requiredFields"><span><b>Please specify the HEQSF alignment category:</b></span></span>';
				echo "<br />The institution specified HEQSF alignment category:  " . $this->data['HeqfQualification']['s1_lkp_heqf_align_id'];
				echo $this->Form->input('Evaluation.eval_lkp_heqf_align_id', array('type' => 'radio', 'legend'=> false, 'options' => $AppHeqfAlign, 'format' => $format, 'value' =>  $selectedCat));
			?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php
				echo '<span class="requiredFields"><span><b>2. Is the qualification type aligned with HEQSF requirements?</b></span></span>';
				echo $this->Form->input('Evaluation.qualification_type_aligned', array('type' => 'radio', 'legend'=> false, 'options' => $optionsy, 'format' => $format));
			?>
		</td>
		<td>
			<?php
				echo '<span class="requiredFields"><span><b>3. Is the exit NQF level correctly aligned to HEQSF requirements?</b></span></span>';
				echo $this->Form->input('Evaluation.nqf_level_aligned', array('type' => 'radio', 'legend'=> false, 'options' => $optionsy, 'format' => $format));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
				echo '<span class="requiredFields"><span><b>4. Are the total credits correctly aligned to HEQSF requirements?</b></span></span>';
				echo $this->Form->input('Evaluation.total_credits_aligned', array('type' => 'radio', 'legend'=> false, 'options' => $optionsy, 'format' => $format));
			?>
		</td>
		<td>
			<?php
				echo '<span class="requiredFields"><span><b>5. Is the programme correctly titled in terms of HEQSF requirements?</b></span></span>';
				echo $this->Form->input('Evaluation.programme_correctly_titled', array('type' => 'radio', 'legend'=> false, 'options' => $optionsy, 'format' => $format));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
				$checkComments = 'None';
				if(isset($this->data['Application']['checklisting_comments']) && !empty($this->data['Application']['checklisting_comments'])){
					$checkComments = $this->data['Application']['checklisting_comments'];
				}
				
				echo $this->Form->input('Evaluation.eval_comments', array('label' => '<b>Comments / suggestions</b>', 'format' => $format));
			?>
		</td>
		<td>
			<div id="alert" class="flash-messages">
				<div class="ui-state-good ui-corner-all"><b>Checklister comments:</b>
					<p><?php echo $checkComments; ?></p>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php
				echo '<span class="requiredFields"><span><b>Evaluator Recommendation:</b></span></span><br />';
				echo 'It is recommended that this programme is:';
				echo $this->Form->input('Evaluation.eval_lkp_outcome_id', array('type' => 'radio', 'legend'=> false, 'options' => $Outcome, 'format' => $format));
			?>
		</td>
		<td>
			<?php
				echo $this->Form->input('Evaluation.eval_status_id', array('label' => '<span class="requiredFields"><span><b>Please select <i>Ready for review</i> below when you are satisfied with your evaluation.  The application will be automatically returned to the administrator when you save.</b></span></span>', 'options' => $EvaluationStatus, 'format' => $format));
			?>
		</td>
	</tr>
</table>


<script>
$(function() {
	$("#propCat").hide();
	if($("input[name='data[Evaluation][application_correctly_categorised]']:checked").val() == 'Yes'){
		$("#propCat").hide();
	}
	else{
		if($("input[name='data[Evaluation][application_correctly_categorised]']:checked").val() == 'No'){
			$("#propCat").show();
		}
	}
	
	$("input[name='data[Evaluation][application_correctly_categorised]']").on('change', function(){
		if($("input[name='data[Evaluation][application_correctly_categorised]']:checked").val() == 'Yes'){
			$("#propCat").fadeOut("fast");
		}
		else{
			$("#propCat").fadeIn("fast");
		}
	});
});
</script>
