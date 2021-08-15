<div class="categorias form">
<?php echo $form->create('Categoria');?>
	<fieldset>
 		<legend><?php __('Editar Categoria');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('titulo_categoria', array('label' => 'Titulo da categoria') );
	?>
	</fieldset>
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action'=>'delete', $form->value('Categoria.id')), null, sprintf(__('Tem certeza que quer apagar esta categoria?', true), $form->value('Categoria.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Categorias', true), array('action'=>'index'));?></li>
	</ul>
</div>
