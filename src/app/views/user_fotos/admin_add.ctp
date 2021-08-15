<div class="userFotos form">
<?php echo $form->create('UserFoto');?>
	<fieldset>
 		<legend><?php __('Add UserFoto');?></legend>
	<?php
		echo $form->input('user_id');
		echo $form->input('imagem');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List UserFotos', true), array('action'=>'index'));?></li>
	</ul>
</div>
