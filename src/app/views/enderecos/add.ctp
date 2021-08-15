<?php 
echo $javascript->link('prototype');
?>
<div class="enderecos form">
<?php echo $form->create('Endereco');?>
	<fieldset>
 		<legend><?php __('Meu dados');?></legend>
    
    <?php 
		if($session->check('Message.flash')){ ?> 
        	<div class="showErrorMessage">
            	<span class="txtErrorMessage"><?php $session->flash('flash', array('div' => false)); ?></span>
            </div> 
	<?php } ?>
	<?php
		echo $form->input('estados', array('label' => 'Estado *', 'type' => 'select'));
		echo $form->input('cidades', array('label' => 'Cidade *', 'type' => 'select', 'div' => array('id' => 'cidades')));
		echo $ajax->observeField('EnderecoEstados', array(
        	'update' => 'EnderecoCidades',
        	'url' => array('controller' => 'cidades', 'action' => 'cidades')
        ));

		echo $form->input('cpf', array('label' => 'CPF *'));
		echo $form->input('rg', array('label' => 'RG'));
	?>
    	<div class="input text">
        	<label for="EnderecoDddCel">Celular</label>
        	<input name="data[Endereco][ddd_cel]" type="text" maxlength="2" style="width: 2em;" value="" id="EnderecoDddCel" /> - 
            <input name="data[Endereco][celular]" type="text" maxlength="8" style="width: 257px;" value="" id="EnderecoCelular" />
        </div>	
    	
        <div class="input text">
        	<label for="EnderecoDddComercial">Tel. comercial</label>
        	<input name="data[Endereco][ddd_comercial]" type="text" maxlength="2" style="width: 2em;" value="" id="EnderecoDddComercial" /> - 
            <input name="data[Endereco][tel_comercial]" type="text" maxlength="8" style="width: 257px;" value="" id="EnderecoTelComercial" />
        </div>	
	<?php
		echo $form->input('estado_civil', array(
			'options' => array(
				'Solteiro' => 'Solteiro',
				'Casado' => 'Casado'
			)
		));
		echo $form->input('desc_endereco', array('label' => 'Desc. Endereço'));
	?>
    	<div class="hint">Descreva seu endereço se quiser. Ex.: Minha casa; Edifício Tal de Tal; etc...</div>
    <?php
		echo $form->input('endereco', array('label' => 'Endereço *'));
		echo $form->input('numero', array('label' => 'Número *'));
		echo $form->input('complemento', array('label' => 'Complemento'));
		echo $form->input('bairro', array('label' => 'Bairro *'));
		echo $form->input('cep', array('label' => 'CEP *'));
	?>
	</fieldset>
<?php echo $form->end('Cadastrar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>