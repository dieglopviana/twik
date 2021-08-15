<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Editar Usuário');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('nome_user', array('label' => 'Nome Completo *', 'error' => false) );
		echo $form->input('email_user', array('label' => 'Email *', 'error' => false) );
		echo $form->input('username', array('label' => 'Login *', 'error' => false) );
	?>
    	<div class="input text">
        	<label for="UserDdd">DDD - Telefone *</label>
        	<input name="data[User][ddd]" type="text" maxlength="2" style="width: 2em;" value="<?php echo $form->data['User']['ddd']; ?>" id="UserDdd" /> - 
            <input name="data[User][telefone]" type="text" maxlength="8" style="width: 257px;" value="<?php echo $form->data['User']['telefone']; ?>" id="UserTelefone" />
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
		echo $form->input('UserBid.quantidade', array('label' => 'Qtd. de lances'));
		echo $form->input('UserBid.id');
		echo $form->input('newsletter');
		//echo $form->input('aviso');
		echo $form->input('status');
		echo $form->input('admin', array('label' => 'Administrador'));
	?>
	</fieldset>
<?php echo $form->end('Alterar') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action'=>'delete', $form->value('User.id')), null, sprintf(__('Deseja mesmo apagar este usuário?', true), $form->value('User.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Usuários', true), array('action'=>'index'));?></li>
	</ul>
</div>
