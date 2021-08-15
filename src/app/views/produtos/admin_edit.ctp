<div class="produtos form">
<?php echo $form->create('Produto');?>
	<fieldset>
 		<legend><?php __('Editar Produto');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('categoria_id', array('type' => 'select') );
		echo $form->input('titulo_produto');
		echo $form->input('descricao', array('cols' => 35, 'rows' => 20));
		echo $form->input('valor_mercado');
	?>
	</fieldset>
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action'=>'delete', $form->value('Produto.id')), null, sprintf(__('Deseja mesmo apagar este produto?', true), $form->value('Produto.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Produtos', true), array('action'=>'index'));?></li>
	</ul>
</div>
<?php 

// OPÇÕES PARA PRESET (SIMPLES, INTERMEDIARIO E AVANCADO)
echo $this->renderElement('tinymce', array('preset' => 'avancado')); 

?> 