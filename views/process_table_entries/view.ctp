<div class="processTableEntries view">
<h2><?php  __('ProcessTableEntry');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Action'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['action']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Argv'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['argv']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Priority'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['priority']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $processTableEntry['ProcessTableEntry']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProcessTableEntry', true), array('action' => 'edit', $processTableEntry['ProcessTableEntry']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProcessTableEntry', true), array('action' => 'delete', $processTableEntry['ProcessTableEntry']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $processTableEntry['ProcessTableEntry']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ProcessTableEntries', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New ProcessTableEntry', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
