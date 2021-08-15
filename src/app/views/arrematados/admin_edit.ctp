<div class="arrematados form">
<?php echo $form->create('Arrematado');?>
	<fieldset>
 		<legend><?php __('Depoimento');?></legend>
	<?php
		echo $form->input('id');
		//echo $form->input('auction_id', array('label' => 'Cod. Leilão'));
		//echo $form->input('user_id', array('label' => 'Cod. Usuário')););
		//echo $form->input('history_bid_id', array('label' => 'Cod. Último lance'));
		echo $form->input('depoimento');
	?>
	</fieldset>
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action'=>'delete', $form->value('Arrematado.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Arrematado.id'))); ?></li>
		<li><?php echo $html->link(__('Voltar', true), array('action'=>'index'));?></li>
	</ul>
</div>
<?php
	// OPÇÕES PARA PRESET (SIMPLES, INTERMEDIARIO E AVANCADO)
	echo $this->renderElement('tinymce', array('preset' => 'simples')); 
?>
