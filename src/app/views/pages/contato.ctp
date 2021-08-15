<?php echo $form->create(null, array('url' => '/contato')); ?>
                            
<fieldset>
	<legend>Contato</legend>
<?php 
	  if($session->check('Message.flash')){ ?> 
       	 <div class="showErrorMessage">
           	<span class="txtErrorMessage"><?php $session->flash('flash', array('div' => false)); ?></span>
         </div> 
<?php } 				
	
	echo $form->input('nome', array('label' => 'Nome *'));
	echo $form->input('email', array('label' => 'Email *'));
	echo $form->input('assunto', array(
		'options' => array(
			'Dúvidas' => 'Dúvidas',
			'Sugestão' => 'Sugestão',
			'Reclamação' => 'Reclamação',
			'Outros' => 'Outros'
		)
	));
	echo $form->input('mensagem', array('label' => 'Mensagem *', 'type' => 'textarea'));
?>
</fieldset>
<?php
	echo $form->end('Enviar');
?>
