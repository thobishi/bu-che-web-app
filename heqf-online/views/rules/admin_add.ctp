<div class="rules form">
<?php echo $this->Form->create('Rule');?>
	<fieldset>
 		<legend><?php __('Add Rule'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Rules', true), array('action' => 'index'));?></li>
	</ul>
</div>