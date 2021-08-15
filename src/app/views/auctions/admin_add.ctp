<div class="auctions form">
<?php echo $form->create('Auction');?>
	<fieldset>
 		<legend><?php __('Inserir Leilão');?></legend>
	<?php
		echo $form->input('produto_id', array('type' => 'select') );
		//echo $form->day('data_inicio');
		//echo $form->month('data_inicio');
		
		echo $form->input('data_inicio', array(
			'label' => 'Data de início', 
			'dateFormat' => 'DMY', 
			'minYear' => date('Y'), 
			'maxYear' => date('Y'), 
			'timeFormat' => '24',
			)
		);
			
		echo $form->input('tempo_cronometro', array('label' => 'tempo do cronômetro. (em segundos)') );
		echo $form->input('valor_inicial', array('label' => 'Valor inicial do leilão') );
		echo $form->input('valor_lance', array('label' => 'Valor do lance') );
		echo $form->input('busca', array('label' => 'Palavras chave') );
	?>
    	<div class="hint">
        	Digite as possíveis palavras chaves que o usuário possa digitar para realizar uma busca.<br />
            Ex.: impressora, multifuncional, jato, tinta, pen, pen drive, iphone, etc...
        </div>
    <?php
		echo $form->input('destaque', array('label' => 'Inserir como destaque', 'type' => 'checkbox'));
		//echo $form->input('status_cronometro');
		echo $form->input('status_auction', array('label' => 'Ativar esse leilão') );
		//echo $form->input('arrematado');
	?>
	</fieldset>
<?php echo $form->end('Cadastrar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Leilões', true), array('action'=>'index'));?></li>
	</ul>
</div>
