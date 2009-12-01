<div class="files index">
<h2><?php __('Files');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('path');?></th>
	<th><?php echo $paginator->sort('hash');?></th>
	<th><?php echo $paginator->sort('plugin_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($files as $file):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $file['File']['id']; ?>
		</td>
		<td>
			<?php echo $file['File']['path']; ?>
		</td>
		<td>
			<?php echo $file['File']['hash']; ?>
		</td>
		<td>
			<?php echo $file['File']['plugin_id']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $file['File']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $file['File']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $file['File']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $file['File']['id'])); ?>
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
		<li><?php echo $html->link(__('New File', true), array('action' => 'add')); ?></li>
	</ul>
</div>
