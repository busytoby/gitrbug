<div class="peers form">
<?php echo $form->create('Peer');?>
	<fieldset>
 		<legend><?php __('Add Peer');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('ip');
		echo $form->input('port');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Peers', true), array('action' => 'index'));?></li>
	</ul>
</div>
