<?php
	if($this->action !== 'edit') {
		echo $this->Form->input('User.heqc_institution_id', array('label' => 'Select your institution', 'empty' => '-- Select your institution --', 'options' => $heqc_institutions));
	}
	
	if($this->action !== 'edit' && $this->action !== 'admin_edit') {
		echo $this->Form->input('User.institution_name', array('label' => 'Institution name'));

		echo $this->Form->input('User.institution_other', array('type' => 'checkbox', 'label' => 'My institution is not in the list.'));
	}
?>
<span id="instSource" class="ui-helper-hidden"><?php echo $this->Html->url(array('controller' => 'heqc_institutions', 'plugin' => 'heqc', 'action' => 'search', 'ext' => 'json')); ?></span>
<?php $this->Html->script('users/user_fields', array('inline' => false)); ?>
