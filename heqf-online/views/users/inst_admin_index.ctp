<div class="users index">
<h2><?php __('Users');?></h2>
<?php echo $this->Html->div('total', 'Total: ' . $this->Paginator->counter(array('format' => __('%count%', true))) . ' users'); ?>

<?php echo $this->Form->create('User', array('url' => $this->params['named'])); ?>
<table>
<tr class="tableHead">
	<td>
		<div class="actions listActions">
			<ul>
				<?php echo $this->AuthLinks->pageActions(array('model' => 'User')); ?>
			</ul>
		</div>
	</td>
	<td colspan="7">
		<div class="search">
			<?php
				echo $this->Form->input('search', array('placeholder' => 'Search users', 'label' => false));
				echo '<div class="bulkButtons">' . $this->Form->button('Go') . '</div>';
			?>
		</div>
	</td>
</tr>
<tr>
	<th><?php echo $this->Paginator->sort('email_address');?></th>
	<th><?php echo $this->Paginator->sort('first_name');?></th>
	<th><?php echo $this->Paginator->sort('last_name');?></th>
	<th><?php echo $this->Paginator->sort('Role', 'Role.name');?></th>
	<th><?php echo $this->Paginator->sort('Status', 'active');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>
		<tr<?php echo $class;?>>
			<td>
				<?php echo $user['User']['email_address']; ?>
			</td>
			<td>
				<?php echo $user['User']['first_name']; ?>
			</td>
			<td>
				<?php echo $user['User']['last_name']; ?>
			</td>
			<td>
				<?php echo $this->Text->toList(Set::extract('/Role/name', $user));?>
			</td>
			<td>
				<?php echo $user['User']['active'] == 1 ? 'Active' : 'Inactive'?>
			</td>
			<td>
				<?php echo $user['User']['created']; ?>
			</td>
			<td class="actions">
				<?php 
					if($user['User']['id'] !== Auth::get('User.id')) {
						echo $this->AuthLinks->recordActions($user['User'], array('delete' => false)); 
						if($user['User']['active'] == 1) {
							echo $this->AuthLinks->link('Deactivate', array('action' => 'toggle_state', $user['User']['id']));
						}
						else {
							echo $this->AuthLinks->link('Activate', array('action' => 'toggle_state', $user['User']['id']));						
						}
					}
				?>
			</td>
		</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('paging', array('plugin' => 'octoplus')); ?>
<?php echo $this->Form->end(); ?>
</div>