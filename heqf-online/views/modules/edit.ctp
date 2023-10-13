<div class="modules form">
<?php echo $this->Form->create('Module');?>
	<fieldset>
 		<legend><?php __('Edit Module'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('qualification_ref_no');
		//echo $this->Form->input('alignment_id');
		echo $this->Form->input('module_code');
		echo $this->Form->input('module_name');
		echo $this->Form->input('module_type');
		echo $this->Form->input('credit_weighting');
		echo $this->Form->input('nqf_level');
		echo $this->Form->input('year_of_study');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Module.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Module.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Modules', true), array('action' => 'index'));?></li>
	</ul>
</div>