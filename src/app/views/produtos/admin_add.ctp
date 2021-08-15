<div class="produtos form">
<?php echo $form->create('Produto');?>
	<fieldset>
 		<legend><?php __('Adicionar Produto');?></legend>
	<?php
		echo $form->input('categoria_id', array('type' => 'select') );
		echo $form->input('titulo_produto');
		echo $form->input('descricao', array('cols' => 35, 'rows' => 20));
		echo $form->input('valor_mercado');
	?>
	</fieldset>
<?php echo $form->end('Cadastrar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Produtos', true), array('action'=>'index'));?></li>
	</ul>
</div>
<?php 

// OPÇÕES PARA PRESET (SIMPLES, INTERMEDIARIO E AVANCADO)
echo $this->renderElement('tinymce', array('preset' => 'avancado')); 

?>