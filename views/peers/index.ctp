<div class="peers index">
<h2><?php __('Peers');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('ip');?></th>
	<th><?php echo $paginator->sort('port');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($peers as $peer):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $peer['Peer']['id']; ?>
		</td>
		<td>
			<?php echo $peer['Peer']['name']; ?>
		</td>
		<td>
			<?php echo $peer['Peer']['ip']; ?>
		</td>
		<td>
			<?php echo $peer['Peer']['port']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $peer['Peer']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $peer['Peer']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $peer['Peer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $peer['Peer']['id'])); ?>
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
		<li><?php echo $html->link(__('New Peer', true), array('action' => 'add')); ?></li>
	</ul>
</div>
