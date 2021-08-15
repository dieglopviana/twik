<div class="produtoImages form">
<?php echo $form->create('ProdutoImage', array('type' => 'file', 'url' => '/admin/produto_images/add/' . $produto_id) );?>
	<fieldset>
 		<legend><?php __('Add ProdutoImage');?></legend>
	<?php
		//echo $form->input('produto_id');
		echo $form->input('image', array('label' => 'Imagem', 'type' => 'file') );
	?>
	</fieldset>
<?php echo $form->end('Enviar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ProdutoImages', true), array('action'=>'index'));?></li>
	</ul>
</div>
