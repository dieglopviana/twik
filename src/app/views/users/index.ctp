<!-- Index do usuário -->
<div class="users_index">
	
    <?php 
		if ($session->check('Message.flash')){ ?> 
    		<div class="showErrorMessage" style="width: 610px; height: 30px; color: #B00; margin: 15px 0px 15px 0px;">
    			<span class="txtErrorMessage" style="font: 11pt Arial; font-weight: bold; margin: 0px 0px 0px 40px;">
					<?php $session->flash('flash', array('div' => false)); ?>
                </span>
    		</div> 
	<?php } ?>
    
    <div id="quadro_menu_user">
    	<ul class="margin_rodape">
        	<li class="lista_rodape"><strong><?php echo $html->link('Meus dados','/enderecos/add'); ?></strong></li>
            <li class="lista_rodape"><strong> | </strong></li>
            <li class="lista_rodape"><strong><?php echo $html->link('Trocar senha','/users/changepassword'); ?></strong></li>
            <li class="lista_rodape"><strong> | </strong></li> 
            <li class="lista_rodape"><strong><?php echo $html->link('Arrematados','/users/arrematados'); ?></strong></li>           
        </ul>
    </div>
</div>