<div class="users form" style="width: 634px; height: auto;">
<?php echo $form->create('User', array('action' => 'login'));?>
	<fieldset>
 		<legend><?php __('Entre e comece a dar lances!');?></legend>
        <?php 
			if($session->check('Message.auth')){ ?> 
            	<div class="showErrorMessage">
                	<span class="txtErrorMessage"><?php $session->flash('auth', array('div' => false)); ?></span>
                </div> 
		<?php } else  
			if($session->check('Message.flash')){ ?> 
            	<div class="showErrorMessage">
                	<span class="txtErrorMessage"><?php $session->flash('flash', array('div' => false)); ?></span>
                </div> 
		<?php } ?>
        
	<?php
		echo $form->input('username', array('label' => 'Login *', 'error' => false) );
		echo $form->input('password', array('label' => 'Senha *', 'type' => 'password', 'error' => false) );
	?>
	</fieldset>
<?php echo $form->end('Login');?>

</div>

