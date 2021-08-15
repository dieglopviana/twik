<?php echo $javascript->link('default'); ?>

<div id="auctions_view" class="auctions view">
	<div id="titulo_auction">
    	<?php echo $auction['Produto']['titulo_produto']; ?>
    </div>
    <div id="desc_produto">
    	&nbsp; <!-- Aqui caso seja necessário, deve-se colocar a descrição do produto -->
    </div>
    <div id="content_view">
    	<div id="imagens_auctions">
        	<div id="image_max">
            	<?php
					if (!empty($auction['ImagesAuction'])):
						echo $html->image('imagens_produtos/max/' . $auction['ImagesAuction'][0]['ProdutoImage']['image'], array(
							'class'=>'productImageMax',
							'alt' => $auction['Produto']['titulo_produto'],
							'title' => $auction['Produto']['titulo_produto'],
							'width' => '300px',
							'height' => '295px'
						));
					endif;
				?>
            </div>
            <div id="images_thumbs">
            	<?php 
					if (!empty($auction['ImagesAuction']) && count($auction['ImagesAuction']) > 1):?>
                    	<ul class="no-margin-padding">
                    		<?php 
								foreach($auction['ImagesAuction'] as $image):
							?>
                    			<li style="float: left;	margin: 10px 8px 0px 0px; border: 1px solid #ed5e00;">
                                	<?php 
										echo $html->link($html->image('imagens_produtos/thumbs/'.$image['ProdutoImage']['image'], array (
												'alt' => $auction['Produto']['titulo_produto'],
												'title' => $auction['Produto']['titulo_produto'],
												'width' => '95px',
												'height' => '95px',
												'border' => 0,
											)), 
											'/img/imagens_produtos/max/'.$image['ProdutoImage']['image'], array(
												'class' => 'productImageThumb'
											), null, false);
									?>
                                </li>
                            <?php 
								endforeach;
							?>
                        </ul>
                <?php 
					endif;				
				?>
            </div>
        </div>
        <div id="dados_auctions">
        	<div id="dados_topo" style="border: 0px;" class="quadro_auction" title="Código do leilão: <?php echo $auction['Auction']['id']; ?>">
            	<div id="valor_mercado">
                	valor de mercado <?php echo $auction['Produto']['valor_mercado']; ?>
                </div>
                <div id="quadro_aviso_<?php echo $auction['Auction']['id']; ?>" class="inicio_auction">
                	<strong>Início do Leilão:</strong> <?php echo $formatacao->dataHora(strtotime($auction['Auction']['data_inicio']), true); ?>
                </div>
                <div id="quadro_time_<?php echo $auction['Auction']['id']; ?>" class="quadro_time_view" style="display: none;">
            		<span id="time_<?php echo $auction['Auction']['id']; ?>" class="time">00</span>
                	<?php if(!strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')){	$txt_restantes = "padding-top: 10px;"; } else { $txt_restantes = ""; } ?>
                    <span id="txt_segundos_<?php echo $auction['Auction']['id']; ?>" class="txt_restantes" style="margin: 10px 0 0 50px; <?php echo $txt_restantes; ?>">
                	segundos restantes</span>
            	</div>
                <!--<div id="merchan">
                	<div id="logo_patrocinador">
                    	&nbsp;
                    </div>
                    <div id="txt_merchan">
                    	<span><strong>Não venceu o leilão?</strong></span><br />
                        <span><a href="#">Acesse agora nosso site e compre por lá.</a></span>
                    </div>
                </div>-->
            </div>
            <div id="history_bids">
                <?php 
					if($session->check('Auth.User')){
						$link = array('controller' => 'auctions', 'action' => 'bid', $auction['Auction']['id']);
						$title = 'dê seu lance';
					} else {
						$link = array('controller' => 'users', 'action' => 'login');
						$title = 'login';
					}
				?>
                <table class="table_lance" cellspacing="0" cellpadding="0">
                	<tr id="topo_inativo">
                    	<td class="btn_inativo" align="center">
                        	<?php echo $html->link('lance', $link, array('class' => 'btn_lance', 'title' => $title)); ?>
                        </td>
                    </tr>
                    <tr id="topo_ativo" style="display: none;">
                    	<td class="btn_ativo" align="center">
                        	<?php echo $html->link('lance', $link, array('class' => 'btn_lance', 'title' => $title)); ?>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                			<table class="history_bids" cellspacing="0" cellpadding="0">
                    			
                                <tr id="bids" class="first_bid">
                    				<td class="valor_bid" align="center"><span class="fisrt_bid"><strong>&nbsp;</strong></span></td>
                        			<td class="imagem_user" align="center">&nbsp;</td>
                        			<td class="username"><span class="username">&nbsp;</span></td>
                    			</tr>              
                			</table>
                		</td>
                	</tr>
                    <tr>
                    	<td align="center" valign="bottom" height="35">
                        	<span id="valor_por_lance">
								<?php 									
									echo "A cada lance, o valor terá o acréscimo de R$ " . $formatacao->formataMoeda($auction['Auction']['valor_lance']); 
								?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="quadro_descricao">
    	<div id="descricao_produto">
        	<?php echo $auction['Produto']['descricao']; ?>
        </div>
    </div>
</div>