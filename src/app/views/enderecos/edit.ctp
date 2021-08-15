<?php 
echo $javascript->link('prototype');
?>
<div class="enderecos form">
<?php echo $form->create('Endereco');?>
	<fieldset>
 		<legend><?php __('Meus dados');?></legend>
    
    <?php 
		if($session->check('Message.flash')){ ?> 
        	<div class="showErrorMessage">
            	<span class="txtErrorMessage">
					<?php $session->flash('flash', array('div' => false)); ?> 
                </span>
            </div>
	<?php } ?>
	
	<div class="input select">
    	<label for="EnderecoEstados">Estado *</label>
        <select name="data[Endereco][estados]" id="EnderecoEstados">
        <?php
			for($i = 1; $i <= count($estados); $i++):
		?>
        		<option value="<?php echo $i; ?>" <?php if($i == $myAddress['Cidade']['estado_id']) echo "selected = 'selected'"; ?>><?php echo $estados[$i]; ?></option>
        <?
			endfor;
		?>	
		</select>
    </div>
	
	<?php
		//echo $form->input('estados', array('label' => 'Estado *', 'type' => 'select'));
		echo $form->input('cidade_id', array('label' => 'Cidade *', 'type' => 'select', 'div' => array('id' => 'cidades')));
		echo $ajax->observeField('EnderecoEstados', array(
        	'update' => 'EnderecoCidadeId',
        	'url' => array('controller' => 'cidades', 'action' => 'cidades')
        ));

		echo $form->input('cpf', array('label' => 'CPF *'));
		echo $form->input('rg', array('label' => 'RG'));
	?>
    	<div class="input text">
        	<label for="EnderecoDddCel">Celular</label>
        	<input name="data[Endereco][ddd_cel]" type="text" maxlength="2" style="width: 2em;" value="<? echo $form->data['Endereco']['ddd_cel']; ?>" id="EnderecoDddCel" /> - 
            <input name="data[Endereco][celular]" type="text" maxlength="8" style="width: 257px;" value="<? echo $form->data['Endereco']['celular']; ?>" id="EnderecoCelular" />
        </div>	
    	
        <div class="input text">
        	<label for="EnderecoDddComercial">Tel. comercial</label>
        	<input name="data[Endereco][ddd_comercial]" type="text" maxlength="2" style="width: 2em;" value="<? echo $form->data['Endereco']['ddd_comercial']; ?>" id="EnderecoDddComercial" /> - 
            <input name="data[Endereco][tel_comercial]" type="text" maxlength="8" style="width: 257px;" value="<? echo $form->data['Endereco']['tel_comercial']; ?>" id="EnderecoTelComercial" />
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
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>