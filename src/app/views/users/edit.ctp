<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('nome_user');
		echo $form->input('email_user');
		echo $form->input('username');
		echo $form->input('password');
		echo $form->input('ddd');
		echo $form->input('telefone');
		echo $form->input('nascimento');
		echo $form->input('sexo');
		echo $form->input('newsletter');
		echo $form->input('aviso');
		echo $form->input('status');
		echo $form->input('admin');
	?>
	</fieldset>
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.id'))); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></li>
	</ul>
</div>
