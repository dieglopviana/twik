<div id="login">
	<?php echo $form->create('User', array('action' => 'login') ); ?>
	<?php echo $form->input('username', array(
				'label' => false, 
				'div' => 'quadro_login', 
				'value' => 'login', 
				'class' => 'login', 
				'id' => 'username', 
				'error' => false,
				'onfocus' => "this.value = ''"
		  )); 
	?>
	<?php echo $form->input('password', array(
				'type' => 'password', 
				'label' => false, 
				'div' => 'quadro_login', 
				'value' => 'senha', 
				'class' => 'login', 
				'id' => 'senha',
				'onfocus' => "this.value = ''"
	 	  )); 
	?>
	<div class="login_ok">
		<input name="button" type="image" id="login_ok" src="/img/bt_ok.gif" />
	</div>
	<div class="login_duvida">
		<a href="/users/reset">
			<?php echo $html->image('bt_duvidas.gif', array('width' => 17, 'height' => 17, 'alt' => 'Dúvidas', 'title' => 'Esqueceu', 'border' => 0) ); ?>
		</a>
	</div>
	<?php echo $form->end(); ?>
</div><!--div login -->      

<div id="div_cadastro">
	<a href="/users/add" title="Cadastre-se">
		<?php echo $html->image('bt_cadastre.gif', array('width' => 300, 'height' => 46, 'alt' => 'cadastre-se', 'border' => 0) ); ?>
	</a>
</div><!--div cadastro -->
