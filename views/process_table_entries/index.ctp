<div class="processTableEntries index">
<h2><?php __('ProcessTableEntries');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('action');?></th>
	<th><?php echo $paginator->sort('argv');?></th>
	<th><?php echo $paginator->sort('priority');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($processTableEntries as $processTableEntry):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['id']; ?>
		</td>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['action']; ?>
		</td>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['argv']; ?>
		</td>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['priority']; ?>
		</td>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['created']; ?>
		</td>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['modified']; ?>
		</td>
		<td>
			<?php echo $processTableEntry['ProcessTableEntry']['status']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $processTableEntry['ProcessTableEntry']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $processTableEntry['ProcessTableEntry']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $processTableEntry['ProcessTableEntry']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $processTableEntry['ProcessTableEntry']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New ProcessTableEntry', true), array('action' => 'add')); ?></li>
	</ul>
</div>
