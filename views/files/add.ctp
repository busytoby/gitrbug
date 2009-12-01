<div class="files form">
<?php echo $form->create('File');?>
	<fieldset>
 		<legend><?php __('Add File');?></legend>
	<?php
		echo $form->input('path');
		echo $form->input('hash');
		echo $form->input('plugin_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Files', true), array('action' => 'index'));?></li>
	</ul>
</div>
