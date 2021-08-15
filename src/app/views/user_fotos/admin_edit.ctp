<div class="userFotos form">
<?php echo $form->create('UserFoto');?>
	<fieldset>
 		<legend><?php __('Edit UserFoto');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('imagem');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('UserFoto.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('UserFoto.id'))); ?></li>
		<li><?php echo $html->link(__('List UserFotos', true), array('action'=>'index'));?></li>
	</ul>
</div>
