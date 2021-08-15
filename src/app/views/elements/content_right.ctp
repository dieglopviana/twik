<?php $auctions = $this->requestAction('auctions/ultimos_arrematado/5'); ?>

<div id="arrematados" style="width: 280px; float: left">
	<h1 style="color:#666"><strong>arrematados</strong></h1>
	veja como é fácil!
    <?php echo $this->element('arrematados', array('auctions' => $auctions)); ?>
</div><!--arrematados -->

<div id="vencedores"  style="width: 280px; float: left">
	<h1 style="color:#666"><strong>útimos vencedores</strong></h1>
	eles deram mais lances e ganharam
	<?php 
		if (!empty($auctions)):
			foreach($auctions as $auction):
				if (empty($auction['LatestBid']['image_user'])){
					$auction['LatestBid']['image_user'] = "no_avatar.gif";
				}
	?>
				<div id="users_<?php echo $auction['LatestBid']['user_id']; ?>" class="users">
					<?php echo $html->image('imagens_users/max/' . $auction['LatestBid']['image_user'], array(
						'width' => 50, 
						'height' => '50', 
						'alt' => $auction['LatestBid']['username'],
						'title' => $auction['LatestBid']['username'],
						'border' => 0,
						'url' => array('controller' => 'arrematados', 'action' => 'view', $auction['Auction']['id'])
					)); ?>
                </div><!--users -->
    <?php
			endforeach;
		else:
	?>
    		<div id="nenhum_vencedor">
            	Nenhum vencedor ainda
            </div>
    <?php
		endif;
	?>	
</div><!--div vencedores -->

<div id="compre_lances"  style="width: 280px; float: left">
   	<h1 style="color:#666"><strong>compre mais lances</strong></h1>
	e garanta suas chances de ganhar
	<p class="tamanho11">Leilão é um mecanismo econômico de negociação definido por uma série de regras para especificar a forma de determinação.</p>
	<h2><img src="/img/lances.jpg" alt="lances" width="54" height="54" style="vertical-align:middle;" /><strong>R$ 50,00 = 100 lances</strong> </h2>
	<h2><img src="/img/lances.jpg" alt="lances" width="54" height="54" style="vertical-align:middle;" /><strong>R$ 25,00 = 40 lances </strong></h2>
	<h2><img src="/img/lances.jpg" alt="lances" width="54" height="54" style="vertical-align:middle;" /><strong>R$ 10,00 = 15 lances </strong></h2>
	<h2><img src="/img/lances.jpg" alt="lances" width="54" height="54" style="vertical-align:middle;" /><strong>R$ 5,00 = 7 lances </strong></h2>      
	<p align="center" class="detalhes"> <strong>compre agora seus lances</strong></p>    
</div><!--div compre lances -->
