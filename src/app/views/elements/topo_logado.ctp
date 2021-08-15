<?php
//print_r($session->read('Auth'));
$name_user = explode(' ', $session->read('Auth.User.nome_user'));
$name_user = $name_user[0];
?>
<div id="logado">
	<div id="avatar_logado">
    	<?php
        	if($session->read('Auth.UserFoto.image') != ''){ 
				echo $html->image('/img/imagens_users/max/' . $session->read('Auth.UserFoto.image'), array(
					'width' => 70, 
					'height' => 70,
					'border' => 0,
					'url' => '/user_fotos/edit/'));
			} else { 
				echo $html->image('/img/no_avatar.gif', array(
					'alt' => 'avatar',
					'border' => 0,
					'url' => '/user_fotos/add'));
          	}
        ?>
        
    </div>
    <div id="dados_logado">
    	<div id="bem_vindo">
        	<div id="ola_user">
            	<strong>olá <?php echo $name_user; ?></strong>
                <a href="/users/logout" title="Sair">
                	<img src="/img/logout.gif" alt="Sair" border="0" />
                </a>
            </div>
            <div id="meus_lances">
            	<div id="img_lances_topo">
                	<img src="/img/lances.jpg" alt="lances" style="width: 40px; height: 40px;" />
                </div>
                <div id="txt_meus_lances">
                	<div id="txt_lances">
                    	você tem <strong><span id="qtd_lances_<?php echo $session->read('Auth.User.id'); ?>">
						<?php echo $session->read('Auth.UserBid.quantidade'); ?> </span> lances</strong><br />
                        <?php
							if ($session->read('Auth.User.admin') == 1):
						?>
                        		<a class="compre_mais_lances" href="/admin"><strong>painel de controle</strong></a>
                        <?php
							else:
						?>
                        		<a class="compre_mais_lances" href="#"><strong>compre mais lances</strong></a>
                        <?php
							endif;
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>