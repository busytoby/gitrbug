<div class="peers view">
<h2><?php  __('Peer');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peer['Peer']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peer['Peer']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ip'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peer['Peer']['ip']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Port'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peer['Peer']['port']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Peer', true), array('action' => 'edit', $peer['Peer']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Peer', true), array('action' => 'delete', $peer['Peer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $peer['Peer']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Peers', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Peer', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
