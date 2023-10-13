<?php
	echo '<div class="input required error"><label>' . $this->Heqf->section3Fields['s3_learning_activities'] . '</label>';
?>
<table class="offerings question_5">
	<tr>
		<th>
			Types of learning activities
		</th>
		<th>
			Hours
		</th>
		<th>
			% Learning time
		</th>
	</tr>
	<tr>
		<td>
			<?php echo $this->Heqf->section3Fields['s3_direct_contact_time']; ?>
		</td>
		<td>
			<?php
				echo $this->Form->input('HeqfQualification.s3_direct_contact_time', array('label' => '', 'class' => 'leading-zero set-hours numeric'));
			?>
		</td>
		<td>
			<span class="percentTotal"></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $this->Heqf->section3Fields['s3_wil_time']; ?>
		</td>
		<td>
			<?php
				echo $this->Form->input('HeqfQualification.s3_wil_time', array('label' => '', 'class' => 'leading-zero set-hours numeric'));
			?>
		</td>
		<td>
			<span class="percentTotal"></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $this->Heqf->section3Fields['s3_workplace_learning_time']; ?>
		</td>
		<td>
			<?php
				echo $this->Form->input('HeqfQualification.s3_workplace_learning_time', array('label' => '', 'class' => 'leading-zero set-hours numeric'));
			?>
		</td>
		<td>
			<span class="percentTotal"></span>
		</td>
	</tr>
	<tr>
		<td>				
			<?php echo $this->Heqf->section3Fields['s3_self_study_time']; ?>
		</td>
		<td>
			<?php
				echo $this->Form->input('HeqfQualification.s3_self_study_time', array('label' => '', 'class' => 'leading-zero set-hours numeric'));
			?>
		</td>
		<td>
			<span class="percentTotal"></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $this->Heqf->section3Fields['s3_learning_assessment_time']; ?>
		</td>
		<td>
			<?php
				echo $this->Form->input('HeqfQualification.s3_learning_assessment_time', array('label' => '', 'class' => 'leading-zero set-hours numeric'));
			?>
		</td>
		<td>
			<span class="percentTotal"></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $this->Heqf->section3Fields['s3_learning_other_time']; ?>
		</td>
		<td>
			<?php
				echo $this->Form->input('HeqfQualification.s3_learning_other_time', array('label' => '', 'class' => 'leading-zero set-hours numeric'));
			?>
		</td>
		<td>
			<span class="percentTotal"></span>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Total</strong>
		</td>
		<td>
			<span id="totalHours"></span>
		</td>
		<td>
			100%
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<?php
				echo $this->Form->input('HeqfQualification.s3_learning_other_text', array('label' => $this->Heqf->section3Fields['s3_learning_other_text']));
			?>
		</td>
	</tr>
</table>
<?php
if (isset($this->validationErrors['HeqfQualification']['s3_learning_activities'])) {
	echo '<div class="error-message">' . $this->validationErrors['HeqfQualification']['s3_learning_activities'] . '</div>';
}
echo '</div>';