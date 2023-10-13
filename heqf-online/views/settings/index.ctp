<div class="settings index">
<h2><?php __('Reminder settings');?></h2>
<?php if (!empty($settings)) { 	?>
<table>
	<thead>
		<tr class="tableHead">
			<th>setting</th>
			<th>Value</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		<?php foreach ($settings as $key => $setting) { 
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
				<tr <?php echo $class;?>>
					<td><?php echo $setting['Setting']['id'] ?></td>
					<td><?php echo $setting['Setting']['value'] ?></td>
					<td><?php echo $setting['Setting']['description'] ?></td>
					<td class="actions">
						<?php 
							// if($this->AuthLinks->checkPermission('read', 'application', 'process')) {
								echo $this->Html->link(__('Edit', true), array('controller' => 'settings', 'action' => 'edit', 'id' => $setting['Setting']['id']));
							// }

						?>
					</td>
				</tr>
		<?php } ?>
	</tbody>

</table>
<?php } else {
	echo '<p> No settings found</p>';
} ?>
</div>