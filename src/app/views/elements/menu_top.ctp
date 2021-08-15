<?php $pages = $this->requestAction('/pages/getpages/top'); ?>
<div id="menu">
	<ul class="margin_rodape">

    <?php 
		 if($session->check('Auth.User.id')){ 
		  	 			  
			  for($i = 0; $i < count($pages); $i++): 
			 			if($i == 0){
	?>
             				<li class="lista_rodape"><strong><?php echo $html->link('minha conta', '/users/index'); ?></strong></li>			
                        	<li class="lista_rodape"><strong> | </strong></li>
    <?php
						} else {
	?>
                        	<li class="lista_rodape">
								<strong><?php echo $html->link($pages[$i]['Page']['name'], array('controller' => 'pages', 'action' => 'view', $pages[$i]['Page']['link'])); ?></strong>
                        	</li>
                            <li class="lista_rodape"><strong> | </strong></li>
    <?php 
						}
			  endfor; 			
		 } else {	
			  for($i = 0; $i < count($pages); $i++): ?>
            			<li class="lista_rodape">
							<strong><?php echo $html->link($pages[$i]['Page']['name'], array('controller' => 'pages', 'action' => 'view', $pages[$i]['Page']['link'])); ?></strong>
                        </li>
                        <li class="lista_rodape"><strong> | </strong></li>
    <?php 	  endfor; 
		 } 
	?>
    
		<li class="lista_rodape"><strong><?php echo $html->link('contato', '/contato'); ?></strong></li>
	</ul>
</div><!--div menu -->