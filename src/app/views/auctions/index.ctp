<?php echo $javascript->link('default'); ?>
<?php
$i = 1;

foreach ($auctions as $auction):
	if($i % 2 == 0){
		$frame_geral = 'frame_geral2';
	} else {
		$frame_geral = 'frame_geral';
	}
	   
?>

<div id="auction_<?php echo $auction['Auction']['id']; ?>" class="<?php echo $frame_geral; ?>">
<div id="quadro_auction_<?php echo $auction['Auction']['id']; ?>" class="quadro_auction" title="Código do leilão: <?php echo $auction['Auction']['id']; ?>">
	<div id="image_auction_<?php echo $auction['Auction']['id']; ?>" class="image_auction">
		<? echo $html->image('imagens_produtos/thumbs/' . $auction['ProdutoImage']['image'], array(
			'alt' => $auction['Produto']['titulo_produto'], 
			'title' => $auction['Produto']['titulo_produto'],
			'border' => 0,
			'url' => '/auctions/view/' . $auction['Auction']['id'])); ?>
	</div>
	<div id="dados_auction_<?php echo $auction['Auction']['id']; ?>" class="dados_auction">
		<div id="titulo_auction_<?php echo $auction['Auction']['id']; ?>" class="titulo_auction">
			<span><strong><?php echo $auction['Produto']['titulo_produto']; ?></strong></span>
		</div>
		<div id="valor_mercado_<?php echo $auction['Auction']['id']; ?>" class="valor_mercado">
			<span style="font: 10pt Arial; color: #999999;">
				<strong>Valor de mercado:</strong><br />
			</span>
			<span style="font: 12pt Arial; color: #999999;">
				<strong><?php echo $auction['Produto']['valor_mercado']; ?></strong>
			</span>
		</div>
		<div id="countdown_<?php echo $auction['Auction']['id']; ?>" class="countdown">
			<div id="quadro_time_<?php echo $auction['Auction']['id']; ?>" style="display: none;">
            	<span id="time_<?php echo $auction['Auction']['id']; ?>" class="time">00</span>
                <span id="txt_segundos_<?php echo $auction['Auction']['id']; ?>" class="txt_restantes">
                segundos restantes</span>
            </div>
            <div id="arrematado_<?php echo $auction['Auction']['id']; ?>" style="display: none;">
            	<span id="txt_arrematado_<?php echo $auction['Auction']['id']; ?>" class="txt_arrematado">Valor final do leilão:</span>
                <span id="valor_arrematado_<?php echo $auction['Auction']['id']; ?>" class="valor_arrematado"></span>
            </div>
            <div id="quadro_aviso_<?php echo $auction['Auction']['id']; ?>" style="display: block;">
            	<span style="font: 10pt Arial;"><strong>Início do Leilão:</strong><br /></span>
            	<span id="aviso_inicio_<?php echo $auction['Auction']['id']; ?>" style="font: 10pt Arial;">
				<?php echo $formatacao->dataHora(strtotime($auction['Auction']['data_inicio']), false); ?>&nbsp; 
            	<?php echo $html->image('reloginho.jpg'); ?></span>
            </div>
		</div>
	</div>
</div>
<div id="lances_<?php echo $auction['Auction']['id']; ?>" class="lances">
	<div id="img_user_<?php echo $auction['Auction']['id']; ?>" class="img_user_bid">
   		<!--<img src="/img/user_exemplo.png" alt="user_exemplo" class="img_bid_user" />-->
    </div>
    <div id="animate_<?php echo $auction['Auction']['id']; ?>" class="animate" style="display: none;"></div>
    <div id="last_bid_<?php echo $auction['Auction']['id']; ?>" class="last_bid">
    	<div id="valor_last_bid_<?php echo $auction['Auction']['id']; ?>" class="valor_last_bid"></div>
    </div>
    <div id="bt_lance_<?php echo $auction['Auction']['id']; ?>" class="bt_lance">
		<?php 
			if($session->check('Auth.User')){
				$link = array('controller' => 'auctions', 'action' => 'bid', $auction['Auction']['id']);
				$title = 'dê seu lance';
			} else {
				$link = array('controller' => 'users', 'action' => 'login');
				$title = 'login';
			}
			
			if($auction['Auction']['status_cronometro'] == 0){			
				echo $html->link($html->image('bt_lance_la.png', array('border' => 0)), $link, array('class' => 'btn_lance', 'id' => 'btn_lance_' . $auction['Auction']['id'], 'title' => $title), null, false); 
			} else 
			if($auction['Auction']['status_cronometro'] == 1){
				echo $html->link($html->image('bt_lance_vd.png', array('border' => 0)), $link, array('class' => 'btn_lance', 'id' => 'btn_lance_' . $auction['Auction']['id'], 'title' => $title), null, false); 
			}
		?>
    </div>
</div>
</div>

<?php 
	if($i % 2 == 0){
		$i = 1;
		echo "<br />";
	} else {
		$i++;
	}
endforeach; 
?>