<?php echo $form->create('User', array('action' => 'changepassword')); ?>
	<fieldset>
		<legend><?php __('Trocar senha'); ?></legend>
		<p>Para trocar sua senha é preciso que você digite a nova senha e a confime.</p><br />
		<?php 
	 		if ($session->check('Message.flash')){ ?> 
       	 		<div class="showErrorMessage">
           			<span class="txtErrorMessage"><?php $session->flash('flash', array('div' => false)); ?></span>
         		</div> 
	    <?php }
			echo $form->input('senha', array('label' => 'Nova senha *', 'type' => 'password') );
			echo $form->input('conf_senha', array('label' => 'Confirme a senha *', 'type' => 'password') );
	?>
	</fieldset>
<?php echo $form->end('Trocar senha') . ' &nbsp; &nbsp; ' . $form->button('Cancelar', array('class' => 'cancelar', 'onclick' => 'history.back(-1);')); ?>