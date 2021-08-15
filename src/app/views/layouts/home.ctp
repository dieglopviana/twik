<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php echo $html->charset('UTF-8'); ?>
<title>twik - compre ja seus lances e participe</title>
<?php
if($session->check('keyWords') ){
	echo $html->meta('keywords', $session->read('keyWords'));	
}
?>
<?php echo $html->css('page_home'); ?>
<?php echo $html->css('auctions_home'); ?>
<?php echo $javascript->link('jquery/jquery'); ?>
<?php //echo $javascript->codeBlock('jQuery.noConflict();'); ?>
</head>

<body>
<?php 
if(!strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
	$busca = "style='margin-top:5px;'";
}

if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
	$navegacao = "style='margin:60px 0 0 0;'";

}
?>
<div id="site">
	<div id="topo" <?php if(isset($topo)){ echo $topo; } ?>>
    	<div id="coluna_um">
      		<div id="logo">
	  	  		<a href="/" title="twik">
		      		<?php echo $html->image('/img/logo.gif', array('width' => 213, 'height' => 131, 'alt' => 'twik', 'border' => 0) ); ?>
          		</a>
      		</div><!--div logo -->
      		<div id="anuncio"><strong>Compre já seus<br />lances e participe!</strong></div> 
      		<!--div anuncio -->
    		<div id="sessao"><a href="/twik">Próximos leilões</a></div>
    	</div><!--div coluna_um -->
    	<div id="coluna_dois">
      		<div id="busca">
      			<form action="/auctions/busca" method="post" name="busca">
        			<input name="data[Auction][palavra]" type="text" class="busca" value="encontre um produto" <?php if(isset($busca)){ echo $busca; } ?> onfocus="this.value = ''" />
        			<input name="button" type="image" id="button" src="/img/bt_busca.gif" />
        		</form>
      		</div><!--div busca -->
      		
			<?php echo $this->element('menu_top'); ?>
			
            <div  id="sobre_site">
        		<p class="laranja">Você adquire produtos por <br />
  				preços absurdamente baixos!</p>
  				<p class="branco"><strong>Quanto mais lances, mais chances! </strong></p>
    		</div><!--sobre o site -->    		
    		<div id="navegacao" <?php if(isset($navegacao)){ echo $navegacao; } ?>>
    			<!--<a href="/twik">leilões mais próximos</a> |-->
            	<strong><a href="/auctions/index/valor-de-mercado-mais-alto"> valor de mercado mais alto</a> |   
            	<a href="/auctions/index/menor-lance">menor lance </a></strong>
        	</div>
    	</div><!--div coluna_dois -->
    
    
    	<div id="coluna_tres">
      		<div id="canto_login_topo">
            	<?php 
					if($session->check('Auth.User')){
						echo $this->element('topo_logado');
					} else {
						echo $this->element('topo_login');	
					}
				?>
            </div><!-- canto_login_topo -->
      		<div id="data">
            	<strong>
					<?php 
					$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho',
								   'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'); 
					?>
					<?php echo date('d') . " de " .$meses[date('m') - 1]. " de " .date('Y'); ?>
					<?php echo $html->image('relogio.jpg', array('width' => 19, 'height' => 16, 'alt' => 'Horas') ); ?> 
                	<span id="data_hora"><?php echo date('H:i'); ?></span>
                </strong>
            </div>
    	</div><!--div colunha_tres -->
  	</div><!--div topo -->
    
	
    
    <!-- div conteudo principal -->
	<div class="auctions index" style="width:636px;	float:left;	position:relative; margin: 10px 20px 0 0;">
		<?php echo $content_for_layout; ?>
	</div>
	<!-- div conteudo principal -->

	<!-- conteúdo direita -->
	<div id="esquerda2">
		<? echo $this->element('content_right'); ?>
	</div>
	<!-- conteúdo direita -->

</div><!--div site -->

<?php 
		if (isset($estou_na_home)){
			if ($estou_na_home['url'] == '/' || strstr($estou_na_home['url'], 'auctions/index')){
				echo $this->element('destaques', array('limite' => 12));	
			}
		} else {
			echo $this->element('destaques', array('limite' => 3));
		}
?>

<div id="rodape">  
	<div id="direita">
  		<h1>sobre o twik</h1>
		<p class="rodape">Leilão é um mecanismo econômico de negociação definido por uma série de regras para especificar a forma de determinação do vencedor e quanto este deve pagar. Uma característica marcante para os leilões é a presença de assimetria de informações, que faz com que a caracterização deste mecanismo se torne necessária, uma vez que diferentes tipos de leilões podem levar a resultados divergentes.</p>
		
        <?php echo $this->element('menu_bottom'); ?>
        
	</div><!--div direita -->
	<div id="esqueda" style="margin:20px 0;">
    	<?php echo $html->image('patrocinadores.gif', array('width' => 303, 'height' => 114, 'alt' => 'Patrocinadores') ); ?>
    </div><!--div esquerda -->  
</div><!--div rodape -->
<div id="creditos">
	©2009 TWIK. Todos os direitos reservados.
</div><!--div creditos -->

</body>
</html>