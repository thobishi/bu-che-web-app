<td>
	<?php
		echo $this->Form->input('HeqfQualification.ProgrammeAssessmentApproach.' . $key . '.id', array('type' => 'hidden'));
		echo $this->Form->input('HeqfQualification.ProgrammeAssessmentApproach.' . $key . '.year', array('label' => false, 'class' => 'numeric'));
	?>
</td>
<td>
	<?php echo $this->Form->input('HeqfQualification.ProgrammeAssessmentApproach.' . $key . '.purpose', array('label' => false)); ?>
</td>
<td>
	<?php echo $this->Form->input('HeqfQualification.ProgrammeAssessmentApproach.' . $key . '.methods', array('label' => false)); ?>
</td>
<td class="actions bulkButtons">
	<?php echo $this->Html->link(__('Remove', true), array('#'), array('class' => 'removeButton')); ?>
</td>