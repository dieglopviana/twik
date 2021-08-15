<div class="pages form">
<?php echo $form->create('Page');?>
	<fieldset>
 		<legend><?php __('Adicionar Página');?></legend>
	<?php
		echo $form->input('name', array('label' => 'Nome *'));
		echo $form->input('titulo', array('label' => 'Título *'));
		echo $form->input('link', array('label' => 'Link *'));
	?>
    	<div class="hint">
        	Para o link, digite o mesmo que você digiou no nome, só que tudo em minúsculo e substitua o <br />
            espaço por "-". Ex.: sobre-o-twik; termo-de-uso; politica-de-privacidade (sem acentos).
        </div>
    <?php
		echo $form->input('content', array('label' => 'Conteúdo *', 'type' => 'textarea', 'cols' => 30, 'rows' => 30));
		echo $form->input('top_show', array('label' => 'Exibir link no topo'));
		echo $form->input('bottom_show', array('label' => 'Exibir link no rodapé'));
	?>
	</fieldset>
<?php echo $form->end('Cadastrar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Páginas', true), array('action'=>'index'));?></li>
	</ul>
</div>
<?php 

// OPÇÕES PARA PRESET (SIMPLES, INTERMEDIARIO E AVANCADO)
echo $this->renderElement('tinymce', array('preset' => 'avancado')); 

?>
