<?php if(Auth::get()) { ?>
<div id="menu">
	<ul>
		<li><?php echo $this->Html->link('Home', '/'); ?></li>
		<?php 
			if(
				$this->AuthLinks->checkPermission('read', 'application', 'process') //Has read permission for applications
				/*&& (
					(
						!Auth::checkRole('evaluator') //Not a evaluator
						&& !Auth::checkRole('checklister') //Not a checklister
						&& !Auth::checkRole('reviewer') //Not a reviewer
						&& !Auth::checkRole('heqc_member') //Not a heqc member
					) 
					|| Auth::checkRole('che_admin') //Override above checks if a che admin
				)*/
			) { 
		?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Applications', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'application', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>
		<?php if($this->AuthLinks->checkPermission('read', 'Settings')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Configure reminder settings', array('controller' => 'settings', 'action' => 'index', 'plugin' => '', 'admin' => false)); ?></li>
		<?php } ?>

		<?php if($this->AuthLinks->checkPermission('read', 'upload-proceeding-document', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Upload Representation/Deferral', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'upload-proceeding-document', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>

		<?php if($this->AuthLinks->checkPermission('read', 'module', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Modules', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'module', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>		
		<?php if($this->AuthLinks->checkPermission('read', 'outcome', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Accept application outcomes', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'outcome', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>
		<?php if($this->AuthLinks->checkPermission('read', 'outcome', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Accept proceeding outcomes', array('controller' => 'institutions', 'action' => 'listProceedingOutcomes')); ?></li>
		<?php } ?>
		<?php //Limit to UNISA only (Institution: 54)
		if($this->AuthLinks->checkPermission('create', 'application', 'process')) { ?>
		<li class="menu-separator">&nbsp;</li>
		<li>
			<?php 
				echo $this->Html->link('Bulk Import', array('controller' => 'heqf_qualifications', 'action' => 'import')); 
			?>
		</li>
		<?php } ?>
		<?php if($this->AuthLinks->checkPermission('read', 'checklist', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Checklist', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'checklist', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>
		<?php if($this->AuthLinks->checkPermission('read', 'evaluate', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Evaluate', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'evaluate', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>
		<?php if($this->AuthLinks->checkPermission('read', 'review', 'process')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Review', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'review', 'admin' => false, 'plugin' => '')); ?></li>
		<?php } ?>
		<?php if($this->AuthLinks->checkPermission('read', 'Users') && $this->AuthLinks->checkPermission('inst_admin', 'Users')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index', 'inst_admin' => true, 'plugin' => '', 'admin' => false)); ?></li>
		<?php } ?>
		
		<?php if($this->AuthLinks->checkPermission('read', 'Users') && $this->AuthLinks->checkPermission('che_admin', 'Users')) { ?>
			<li class="menu-separator">&nbsp;</li>
			<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index', 'che_admin' => true, 'plugin' => '', 'admin' => false)); ?></li>
		<?php } ?>
		<li class="menu-separator">&nbsp;</li>
		<li><?php echo $this->Html->link('Your Account', array('plugin' => 'octo_users', 'controller' => 'users', 'action' => 'edit', 'admin' => false)); ?></li>
		<li class="menu-separator">&nbsp;</li>
		<li><?php echo $this->Html->link('Help', array('controller' => 'pages', 'action' => 'display', 'help', 'plugin' => '', 'admin' => false)); ?></li>
		<li class="menu-separator">&nbsp;</li>
		<li><?php echo $this->Html->link('Logout', array('plugin' => 'octo_users', 'controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
	</ul>
</div>
<?php } ?>