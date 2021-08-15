<?php
if (!empty($auctions)){
	for($i = 0; $i < 1; $i++):
		if (empty($auction[$i]['LatestBid']['image_user'])){
			$auction[$i]['LatestBid']['image_user'] = "no_avatar.gif";
		}
?>
		<div id="quadro_arrematado">
        	<div id="img_arrematado">
            	<? echo $html->image('imagens_produtos/thumbs/' . $auctions[$i]['ProdutoImage']['image'], array(
						'alt' => $auctions[$i]['Produto']['titulo_produto'], 
						'title' => $auctions[$i]['Produto']['titulo_produto'],
						'border' => 0,
						'url' => array('controller' => 'arrematados', 'action' => 'view', $auctions[$i]['Auction']['id'])
				   )); 
				?>
            </div>
            
            <div style="margin-left: 160px;">
				<div>
                	<span id="titulo_arrematado"><strong><?php echo $auctions[$i]['Produto']['titulo_produto']; ?></strong></span>
                </div>
                <div id="arrematado">
            		<span id="txt_arrematado"><strong>Valor final do leilão:</strong></span>
                	<span id="valor_arrematado" class="valor_arrematado">R$ <?php echo $formatacao->formataMoeda($auctions[$i]['LatestBid']['valor']); ?></span>
            	</div>
                <div id="ganhador">
                	<div id="image_ganhador">
                    	<?php 
							echo $html->image('imagens_users/thumbs/' . $auctions[$i]['LatestBid']['image_user'], array(
								'width' => 24, 
								'height' => 24, 
								'alt' => $auctions[$i]['LatestBid']['username'],
								'title' => $auctions[$i]['LatestBid']['username']
							));
						?>
                    </div>
                    <div id="username_ganhador">
                    	<?php echo $auctions[$i]['LatestBid']['username']; ?>
                    </div>
                </div>
			</div>
        </div>
<?php
	endfor;
?>

<?php
} else {
?>
	<div id="nenhum_arremate" style="text-align: center; font: 10pt Arial; font-weight: bold; margin-top: 15px;">
    	Nenhum leilão foi arrematado ainda
    </div>
<?php
}
?>