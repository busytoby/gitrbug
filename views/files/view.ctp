<div class="files view">
<h2><?php  __('File');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $file['File']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Path'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $file['File']['path']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hash'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $file['File']['hash']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Plugin Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $file['File']['plugin_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit File', true), array('action' => 'edit', $file['File']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete File', true), array('action' => 'delete', $file['File']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $file['File']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Files', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New File', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
