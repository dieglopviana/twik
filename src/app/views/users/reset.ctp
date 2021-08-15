<?php echo $form->create('User', array('action' => 'reset')); ?>
                            
<fieldset>
	<legend>Esqueceu a senha?</legend>
    <p>Informe abaixo seu email cadastrado que uma nova senha será enviada a você.</p><br />
<?php 
	  if($session->check('Message.flash')){ ?> 
       	 <div class="showErrorMessage">
           	<span class="txtErrorMessage"><?php $session->flash('flash', array('div' => false)); ?></span>
         </div> 
<?php } 				
	
	echo $form->input('email', array('label' => 'Digite seu email *'));

?>
</fieldset>
<?php
	echo $form->end('Enviar');
?>
