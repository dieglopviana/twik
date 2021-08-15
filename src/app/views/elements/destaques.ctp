<?php 
$destaques = $this->requestAction('/auctions/destaques/' . $limite); ?>
<?php
if(!empty($destaques)):
?>
<div style="clear: both; margin: 10px 0px 10px 0px; padding-top: 5px; width: 1000px;">
	<div style="border-top: 3px solid #f1f2ed; margin: 10px 25px 20px 20px; padding-top: 15px;">
    	<h1><span style="color: #666;"><strong>produtos em destaque</strong></span></h1>
    </div>
    <div style="margin: 20px 0px 5px 20px; padding: 0px;">      
       <?php
			$i = 1;
			foreach ($destaques as $destaque):
				if($i == 1):
					$frame_geral = 'frame_destaque_geral';
				elseif($i == 2):
					$frame_geral = 'frame_destaque_geral2';
				elseif($i == 3):
					$frame_geral = 'frame_destaque_geral3';
				endif;
		?>
                <div id="destaque_<?php echo $destaque['Auction']['id']; ?>" class="<?php echo $frame_geral; ?>">
                	<div id="quadro_destaque_<?php echo $destaque['Auction']['id']; ?>" class="quadro_auction_destaque" title="Código do leilão: <?php echo $destaque['Auction']['id']; ?>">
                    	<div id="image_destaque_<?php echo $destaque['Auction']['id']; ?>" class="image_auction">
							<? echo $html->image('imagens_produtos/thumbs/' . $destaque['ProdutoImage']['image'], array(
								'alt' => $destaque['Produto']['titulo_produto'], 
								'title' => $destaque['Produto']['titulo_produto'],
								'border' => 0,
								'url' => '/auctions/view/' . $destaque['Auction']['id'])); ?>
						</div>
                        <div id="dados_destaque_<?php echo $destaque['Auction']['id']; ?>" class="dados_auction">
                        	<div id="titulo_destaque_<?php echo $destaque['Auction']['id']; ?>" class="titulo_auction">
								<span><strong><?php echo $destaque['Produto']['titulo_produto']; ?></strong></span>
							</div>
                            <div id="valor_mercado_destaque_<?php echo $destaque['Auction']['id']; ?>" class="valor_mercado">
								<span style="font: 10pt Arial; color: #999999;">
									<strong>Valor de mercado:</strong><br />
								</span>
								<span style="font: 12pt Arial; color: #999999;">
									<strong><?php echo $destaque['Produto']['valor_mercado']; ?></strong>
								</span>
							</div>
                            <div id="countdown_destaque_<?php echo $destaque['Auction']['id']; ?>" class="countdown">
            					<div id="quadro_aviso_destaque<?php echo $destaque['Auction']['id']; ?>" style="display: block;">
            						<span style="font: 10pt Arial;"><strong>Início do Leilão:</strong><br /></span>
            						<span id="aviso_inicio_destaque<?php echo $destaque['Auction']['id']; ?>" style="font: 10pt Arial;">
									<?php echo $formatacao->dataHora(strtotime($destaque['Auction']['data_inicio']), false); ?>&nbsp; 
            						<?php echo $html->image('reloginho.jpg'); ?></span>
            					</div>
							</div>
                        </div>
                    </div>
                </div>
        <?php 
				if($i % 3 == 0){
					$i = 1;
					echo "<br />";
				} else {
					$i++;
				}
			endforeach; 
			
			//print_r($destaques);
		?>
    </div>
</div>
<div style="clear: both; margin: 5px 0px 15px 0px;">&nbsp;</div>
<?php
endif;
?>