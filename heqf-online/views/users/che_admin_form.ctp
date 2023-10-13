<div class="actions">
	<ul>
		<?php echo $this->AuthLinks->pageActions(array('model' => 'User')); ?>
	</ul>
</div>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo sprintf(__('%s User', true), __($this->action == 'che_admin_edit'? 'Edit' : 'Add', true));?></legend>
	<?php
		echo $this->Form->input('id');

			echo $this->Form->input('email_address', array(
				'label' => __d('octo-user', 'Email address', true),
				'between' => '<span class="between">' . __d('octo-user', 'The email address needs to be a valid, working email.', true) . '</span>',
				'autocomplete' => 'off'
			));

			echo $this->Form->input('clean_password', array(
				'type' => 'password',
				'label' => __d('octo-user', 'Account password', true),
				'between' => $this->action == 'inst_admin_edit' ?
					'<span class="between">'.__d('octo-user', 'The password needs to be a minimum of 6 characters long. Leave blank if you don\'t want to change it.', true).'</span>'
					: '<span class="between">'.__d('octo-user', 'The password needs to be a minimum of 6 characters long.', true).'</span>',
				'autocomplete' => 'off'
			));

			echo $this->Form->input('first_name', array(
				'label' => __d('octo-user', 'First name', true),
			));

			echo $this->Form->input('last_name', array(
				'label' => __d('octo-user', 'Last name', true),
			));

			if($this->data['User']['id'] !== $this->Session->read('UserAuth.User.id')) {
				echo $this->Form->input('institution_id');

				echo $this->Form->input('Role.Role', array(
					'multiple' => 'checkbox'
				));

				echo $this->Form->input('active', array(
					'label' => __d('octo-user', 'User status', true),
					'options' => array(
						0 => 'Inactive',
						1 => 'Active'
					),
					'default' => 1
				));
			}
	?>
	</fieldset>
<?php echo $this->Form->end('Save user');?>
</div>