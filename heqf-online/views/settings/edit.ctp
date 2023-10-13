<div class="actions">
	<ul>
		<?php echo $this->Html->link(__('Back to list of reminder settings', true), array('controller' => 'settings', 'action' => 'index')); ?>
	</ul>
</div>
<div class="users form">
<?php echo $this->Form->create('Setting'); ?>	
	<fieldset>
		<legend>Edit Setting value for <em><?php echo $this->params['id']; ?></em></legend>
		<?php
			echo $this->Form->input('id');
		    echo $this->Form->input('value', array('label' => false));
		?>
	</fieldset>
<?php echo $this->Form->end('Save Setting');?>	
</div>