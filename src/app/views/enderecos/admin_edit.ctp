<div class="enderecos form">
<?php echo $form->create('Endereco');?>
	<fieldset>
 		<legend><?php __('Edit Endereco');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('cidade_id');
		echo $form->input('cpf');
		echo $form->input('rg');
		echo $form->input('ddd_cel');
		echo $form->input('celular');
		echo $form->input('ddd_comercial');
		echo $form->input('tel_comercial');
		echo $form->input('estado_civil');
		echo $form->input('desc_endereco');
		echo $form->input('endereco');
		echo $form->input('numero');
		echo $form->input('complemento');
		echo $form->input('bairro');
		echo $form->input('cep');
	?>
	</fieldset>
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Endereco.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Endereco.id'))); ?></li>
		<li><?php echo $html->link(__('List Enderecos', true), array('action'=>'index'));?></li>
	</ul>
</div>
