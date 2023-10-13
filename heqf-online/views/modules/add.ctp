<div class="modules form">
<?php echo $this->Form->create('Module');?>
	<fieldset>
 		<legend><?php __('Add Module'); ?></legend>
	<?php
		echo $this->Form->input('qualification_ref_no');
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

		<li><?php echo $this->Html->link(__('List Modules', true), array('action' => 'index'));?></li>
	</ul>
</div>