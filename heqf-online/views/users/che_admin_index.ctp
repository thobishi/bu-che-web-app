<div class="users index">
<h2><?php __('Users');?></h2>
<?php echo $this->Html->div('total', 'Total: ' . $this->Paginator->counter(array('format' => __('%count%', true))) . ' users'); ?>
<br />
<?php 
	$defaults = $this->FilterData->setDefaults('user_list');

	echo $this->element('search/user_search', array('defaults' => $defaults, 'url' => array('controller' => 'users', 'action' => $this->params['action'])));
	echo $this->Form->create('User', array('url' => $this->params['named']));
?>
<table>
<tr class="tableHead">
	<td>
		<div class="actions listActions">
			<ul>
				<?php echo $this->AuthLinks->pageActions(array('model' => 'User')); ?>
			</ul>
		</div>
	</td>
	<td colspan="6">
		<div class="search">
			<?php
				echo $this->Form->input('search', array('placeholder' => 'Search users', 'label' => false));
				echo '<div class="bulkButtons">' . $this->Form->button('Go') . '</div>';
			?>
		</div>
	</td>
	<td style="border:none;text-align:left;padding: 12px 0 0;">
		<?php
			echo '<a id="searchLink" href="#">Advanced search</a>';
		?>
	</td>
</tr>
<tr>
	<th><?php echo $this->Paginator->sort(__('Email address', true), 'User.email_address');?></th>
	<th><?php echo $this->Paginator->sort('first_name');?></th>
	<th><?php echo $this->Paginator->sort('last_name');?></th>
	<th><?php echo $this->Paginator->sort(__('Institution', true), 'institution_id');//$this->Filter->filter('Institution', 'institution_id');?></th>
	<th><?php echo __('Role', true);//$this->Filter->filter('Role', 'role_id');?></th>
	<th><?php echo $this->Paginator->sort('status');//$this->Filter->filter(__('Status', true), 'status', array(0 => __('Not authenticated', true), 1 => __('Deactivated', true), 2 => __('Active', true)));?></th>
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
				<?php echo $user['Institution']['hei_name']?>
			</td>
			<td>
				<?php echo $this->Text->toList(Set::extract('/Role/name', $user));?>
			</td>
			<td>
				<?php
				
					$status = __('Active', true);

					if($user['User']['active'] == 0) {
						$status = __('Deactivated', true);
					}
					elseif($user['User']['email_authenticated'] == 0) {
						$status = __('Not authenticated', true);
					}

					echo $status;
				?>
			</td>
			<td>
				<?php echo $user['User']['created']; ?>
			</td>
			<td class="actions">
				<?php
					if($user['User']['id'] !== Auth::get('User.id')) {
						echo $this->AuthLinks->recordActions($user['User'], array('delete' => false));
						if($user['User']['active'] == 1 && $user['User']['email_authenticated'] == 1) {
							echo $this->AuthLinks->link('Deactivate', array('action' => 'toggle_state', $user['User']['id']));
						}
						elseif($user['User']['active'] == 0 && $user['User']['email_authenticated'] == 1) {
							echo $this->AuthLinks->link('Activate', array('action' => 'toggle_state', $user['User']['id']));
						}
						elseif($user['User']['email_authenticated'] == 0) {
							echo $this->AuthLinks->link('Authenticate', array('action' => 'authenticate', $user['User']['id']));
						}

						$defaultRole = Set::extract('/Role[default=1]', $user);
						if(!empty($defaultRole)) {
							echo $this->AuthLinks->link('Make admin', array('action' => 'toggle_admin', $user['User']['id']), array('class' => 'makeAdmin'));
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

<div id="makeAdminDial">
The selected user will become the new institutional administrator
</div>

<script>
$(function() {
	var $makeAdmin = $(".makeAdmin");
	var $makeAdminDial = $("#makeAdminDial");
	$makeAdminDial.hide();
	$makeAdmin.click(function(e){
		$link = $(this).attr("href");
		e.preventDefault();
		$makeAdminDial.dialog({
			resizable: false,
			height:190,
			modal: true,
			title: 'Warning',
			buttons: {
				"Confirm": function() {
					confirm = true;
					window.location.replace($link)
					$(this).dialog("close");
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});
});
</script>
