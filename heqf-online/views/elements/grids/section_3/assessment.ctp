<?php
	echo '<div class="input required error"><label>' . $this->Heqf->section3Fields['s3_assessment'] . '</label>';
?>
<table class="offerings" id="programmeAssessment">
	<thead>
		<tr>
			<th colspan="5">Programme assessment approach (e.g. case-based assessment approach)</th>
		</tr>
		<tr>
			<td colspan="5"><?php echo $this->Form->textarea('HeqfQualification.s3_assessment', array('rows' => 5)); ?></td>
		</tr>
		<tr>
			<th colspan="5">Exit level outcomes</th>
		</tr>
		<tr>
			<th>Year level</th>
			<th>Assessment purpose</th>
			<th>Assessment methods</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php
		if (!empty($this->data['HeqfQualification']['ProgrammeAssessmentApproach'])) {
			foreach ($this->data['HeqfQualification']['ProgrammeAssessmentApproach'] as $key => $programme) {
				echo '<tr>';
				echo $this->element('grids/section_3/assessment_fields', compact('key'));
				echo '</tr>';
			}
		} else {
			echo '<tr>';
			echo $this->element('grids/section_3/assessment_fields', array('key' => 0));
			echo '</tr>';
		}
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td>
			<td class="actions bulkButtons">
				<?php echo $this->Html->link(__('Add', true), array('#'), array('class' => 'addButton', 'data-question' => 'programmeAssessment')); ?>
			</td>
		</tr>
	</tfoot>
</table>
<script id="programmeAssessmentTemplate" type="text/template"><?php echo $this->element('grids/section_3/assessment_fields', array('key' => '###'))?></script>
<?php
	if (isset($this->validationErrors['HeqfQualification']['s3_assessment'])) {
		echo '<div class="error-message">' . $this->validationErrors['HeqfQualification']['s3_assessment'] . '</div>';
	}
	echo '</div>';