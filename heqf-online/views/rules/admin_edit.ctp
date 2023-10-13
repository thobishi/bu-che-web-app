<div class="rules form">
<?php echo $this->Form->create('Rule');?>
	<fieldset>
 		<legend><?php __('Edit Rule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('rule');
		echo $this->Form->input('custom_function');
		echo $this->Form->input('values');
		echo $this->Form->input('model_name');
		echo $this->Form->input('column_name');
		echo $this->Form->input('message');
		echo $this->Form->input('type', array('options' => array('required' => 'Required', 'optional' => 'Optional')));
		echo $this->Form->input('active');
		echo $this->Form->input('compulsory');
		echo $this->Form->input('public');
		echo $this->Form->input('private');		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Rule.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Rule.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Rules', true), array('action' => 'index'));?></li>
	</ul>
</div>