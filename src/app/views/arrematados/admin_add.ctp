<div class="arrematados form">
<?php echo $form->create('Arrematado');?>
	<fieldset>
 		<legend><?php __('Add Arrematado');?></legend>
	<?php
		echo $form->input('auction_id', array('label' => 'Cod. Leilão'));
		echo $form->input('user_id', array('label' => 'Cod. Usuário')););
		echo $form->input('history_bid_id', array('label' => 'Cod. último lance'));
		echo $form->input('depoimento');
	?>
	</fieldset>
<?php echo $form->end('Cadastrar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Arrematados', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List History Bids', true), array('controller'=> 'history_bids', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New History Bid', true), array('controller'=> 'history_bids', 'action'=>'add')); ?> </li>
	</ul>
</div>
