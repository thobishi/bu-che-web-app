<div class="rules index">
	<h2><?php __('Rules');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('rule');?></th>
			<th><?php echo $this->Paginator->sort('custom_function');?></th>
			<th><?php echo $this->Paginator->sort('values');?></th>
			<th><?php echo $this->Paginator->sort('model_name');?></th>
			<th><?php echo $this->Paginator->sort('column_name');?></th>
			<th><?php echo $this->Paginator->sort('message');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('compulsory');?></th>
			<?php /* ?><th><?php echo $this->Paginator->sort('created');?></th><?php */ ?>
			<?php /* ?><th><?php echo $this->Paginator->sort('modified');?></th><?php */ ?>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($rules as $rule):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $rule['Rule']['id']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['rule']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['custom_function']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['values']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['model_name']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['column_name']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['message']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['type']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['active']; ?>&nbsp;</td>
		<td><?php echo $rule['Rule']['compulsory']; ?>&nbsp;</td>
		<?php /* ?><td><?php echo $rule['Rule']['created']; ?>&nbsp;</td><?php */ ?>
		<?php /* ?><td><?php echo $rule['Rule']['modified']; ?>&nbsp;</td><?php */ ?>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $rule['Rule']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $rule['Rule']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rule['Rule']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Rule', true), array('action' => 'add')); ?></li>
	</ul>
</div>