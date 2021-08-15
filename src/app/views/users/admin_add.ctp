<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Cadastrar Usuário');?></legend>
		<?php 
			if(isset($erros)){ ?> 
            	<div class="showErrorMessage">
                	<span class="txtErrorMessage">O seu cadastro não pode ser realizado. Por favor, verifique seus dados!</span>
                </div> 
		<?php } ?>
	<?php
		echo $form->input('nome_user', array('label' => 'Nome Completo *', 'error' => false) );
		echo $form->input('email_user', array('label' => 'Email *', 'error' => false) );
		echo $form->input('username', array('label' => 'Login *', 'error' => false) );
		echo $form->input('senha', array('label' => 'Senha *', 'type' => 'password', 'error' => false) );
		echo $form->input('conf_senha', array('label' => 'Confirme a senha *', 'type' => 'password', 'error' => false) );
	    //echo $form->input('ddd', array('label' => 'DDD *', 'maxlength' => 2) );
		//echo $form->input('telefone', array('label' => 'telefone *', 'maxlength' => 8) );
	?>
    	<div class="input text">
        	<label for="UserDdd">DDD - Telefone *</label>
        	<input name="data[User][ddd]" type="text" maxlength="2" style="width: 2em;" value="" id="UserDdd" /> - 
            <input name="data[User][telefone]" type="text" maxlength="8" style="width: 257px;" value="" id="UserTelefone" />
        </div>	
	<?php
        echo $form->input('nascimento', array(
				'label' => 'Data de nascimento *',
				'dateFormat' => 'DMY', 
				'minYear' => date('Y') - 70, 
				'maxYear' => date('Y') - 18,
				'error' => false
			) 
		);
		echo $form->input('sexo', array('label' => 'Sexo', 'type' => 'select', 'options' => array('M' => 'Masculino', 'F' => 'Feminino') ) );
		echo $form->input('newsletter', array('label' => 'Vai receber nossos informativos?', 'checked' => 'checked') );
		//echo $form->input('aviso');
		echo $form->input('status', array('label' => 'Ativar este usuário.'));
		echo $form->input('admin', array('label' => 'Vai ser um usuário administrador.'));
	?>
	</fieldset>
<?php echo $form->end('Cadastrar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
<?php
	if(isset($erros)){ 
?>
		<div class="txtErrorMessage" style="color: #D20000; margin-left: 100px; margin-top: 25px;">
        <?php
			foreach($erros as $erro){
				echo "* " . $erro ."<br />";				
			}
		?>
        </div>
<?	
	}
?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Usuários', true), array('action'=>'index'));?></li>
	</ul>
</div>
