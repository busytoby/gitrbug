<div class="processTableEntries form">
<?php echo $form->create('ProcessTableEntry');?>
	<fieldset>
 		<legend><?php __('Edit ProcessTableEntry');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('action');
		echo $form->input('argv');
		echo $form->input('priority');
		echo $form->input('status');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('ProcessTableEntry.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ProcessTableEntry.id'))); ?></li>
		<li><?php echo $html->link(__('List ProcessTableEntries', true), array('action' => 'index'));?></li>
	</ul>
</div>
