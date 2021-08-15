<?php
ini_set('display_errors', 0);

// Inclui o arquivo de configuração
require_once '../config/config.php';

$aids = explode(',', $_POST['auctions']);

$results = array();

$obj = new Funcoes;

$result = array();
$result['Hora']['server'] = date('H:i');

//caso seja apenas um leilão, o for tem que rodar uma única vez
if (count($aids) == 1){
	$cont = 1;
} else {
	$cont = count($aids) -1;
}

for($i = 0; $i < $cont; $i++){
	$auction = mysql_fetch_array(mysql_query("SELECT * FROM auctions WHERE id = " . $aids[$i]));
	$result['Auction']['id'] = $auction['id'];
	$result['Auction']['arrematado'] = $auction['arrematado'];
	
	if (empty($_GET['histories'])){
		//Verifica se o leilão tem algum lance
		//Se tiver, pega o ultimo lance com o username e o valor
		$history_bids = $obj->ultimoLance($auction['id']);
		if($history_bids == 0){
			$result['LastBid']['username']  = 'sem lances';
			$result['LastBid']['foto_user'] = 0;
			$result['LastBid']['valor']     = $obj->moeda($auction['valor_inicial']);
			$result['LastBid']['data']      = 0;
		} else {
			$result['LastBid']['username']  = $history_bids['username'];
			$result['LastBid']['foto_user'] = $history_bids['foto_user'];
			$result['LastBid']['valor']     = $obj->moeda($history_bids['valor']);
			$result['LastBid']['data']      = $history_bids['created'];
		}
	} else 
	if (!empty($_GET['histories'])){
		$result['LatestBids'] = $obj->latestBids($auction['id']);
		
		if (!empty($result['LatestBids']) && count($result['LatestBids'] >= 1)){
			for($i = 0; $i < count($result['LatestBids']); $i++){
				$result['LatestBids'][$i]['valor'] = $obj->moeda($result['LatestBids'][$i]['valor']);
			}
		}
		
		$result['LastBid']['valor'] = $obj->moeda($auction['valor_inicial']);
		$result['LastBid']['data'] = $result['LatestBids'][0]['created'];
	}
	
	//se a data atual for maior do que a data de início do leilão
	//inicia o cronometro
	if(strtotime($auction['data_inicio']) < time()){
		$result['Auction']['iniciar'] = 1;
		
		//se o status do cronometro for 0 (não iniciado), altera pra 1 (iniciado)
		if($auction['status_cronometro'] == 0){
			$obj->alterarStatusCronometro($auction['id']);	
		}
		
		//se o leilão já tiver algum lance e a data deste lance for maior do que a data de iníco do
		//leilão, a base da contagem regressiva passa a ser a data do ultimo lance
		if($result['LastBid']['data'] != 0){
			if(strtotime($result['LastBid']['data']) > strtotime($auction['data_inicio'])){
				$result['Auction']['end_time'] = strtotime($result['LastBid']['data']) + $auction['tempo_cronometro'];	
			} else {
				$result['Auction']['end_time'] = strtotime($auction['data_inicio']) + $auction['tempo_cronometro'];		
			}
		} else {
			$result['Auction']['end_time'] = strtotime($auction['data_inicio']) + $auction['tempo_cronometro'];
		}
		
		//define a cada segundo em quanto está o cronometro
		$result['Auction']['cronometro'] = $result['Auction']['end_time'] - time();
		
		//se o tempo do cronometro for menor que zero, significa que ninguém deu um lance dentro
		//do tempo determinado, então arremata o leilão
		if($result['Auction']['cronometro'] < 0){
			if ($result['Auction']['arrematado'] == 0){
				$result['Auction']['arrematado'] = $obj->arrematarLeilao($auction['id']);
			}	
		}
		
	} else {
		$result['Auction']['iniciar'] = 0;
		$result['Auction']['cronometro'] = $auction['tempo_cronometro'];
	}
	
	

	$results[] = $result;
}

// Set the header
header('Content-type: text/json');

// Encode the array to json string
echo json_encode($results);


class Funcoes {

	//função para pegar o ultimo lance de um leilão
	function ultimoLance($id){
		$sql = "SELECT * FROM history_bids WHERE auction_id = " .$id. " ORDER BY id DESC LIMIT 1";
		$rs = mysql_query($sql);
	
		//se o leilão tiver algum lance
		if(mysql_num_rows($rs) > 0){
			$dados = mysql_fetch_array($rs);
			$sql_user = "SELECT username, image FROM users u, user_fotos uf WHERE u.id = " .$dados['user_id']. " AND uf.user_id = " .$dados['user_id'];
			$rs_user = mysql_query($sql_user);
			$dados_user = mysql_fetch_array($rs_user);
			$ultimo_lance = array(
				'username' => $dados_user['username'],
				'foto_user' => $dados_user['image'],
				'valor' => $dados['valor'],
				'created' => $dados['created']
			);		
			return $ultimo_lance;
		} else {
			return 0;	
		}
	}
	
	function latestBids($id, $limite = 8){
		$sql = "SELECT * FROM history_bids WHERE auction_id = " .$id. " ORDER BY id DESC LIMIT " . $limite;
		$rs = mysql_query($sql);
		
		if (mysql_num_rows($rs) > 0){
			$latestBids = array();
			while($dados = mysql_fetch_array($rs)){
				$sql_user = "SELECT username, image FROM users u, user_fotos uf WHERE u.id = " .$dados['user_id']. " AND uf.user_id = " .$dados['user_id'];
				$rs_user = mysql_query($sql_user);
				$dados_user = mysql_fetch_array($rs_user);
				$ultimo_lance = array(
					'username' => $dados_user['username'],
					'foto_user' => $dados_user['image'],
					'valor' => $dados['valor'],
					'created' => $dados['created']
				);
				$latestBids[] = $ultimo_lance;
			}
			return $latestBids;
		} else {
			return 0;
		}
	}
	
	function alterarStatusCronometro($id){
		$sql = "UPDATE auctions SET status_cronometro = 1 WHERE id = " .$id;
		$rs = mysql_query($sql);
		if($rs){
			return true;
		} else {
			return false;
		}
	}
	
	function arrematarLeilao($auction_id){
		if (!empty($auction_id)){
			//altera o status do leilão para arrematado
			$sql = "UPDATE auctions SET arrematado = 1 WHERE id = " .$auction_id;
			$rs_auction = mysql_query($sql);
		
			//verifico se o leilão em questão já está inserido na tabela arrematados
			$sql_arrematado = mysql_query('SELECT * FROM arrematados WHERE auction_id = ' . $auction_id);
		
			//se não estiver deve inserí-lo
			if (mysql_num_rows($sql_arrematado) == 0){
				$sql_bids = mysql_query('SELECT * FROM history_bids WHERE auction_id = ' . $auction_id . ' ORDER BY id DESC LIMIT 1');
			
				//se o leilão tiver algum lance, deve inserir na tabela arrematados, o id do ultimo
				//lance, o id do usuário que deu o ultimo lance e o id do leilão
				if (mysql_num_rows($sql_bids) > 0){
					$historyBids = mysql_fetch_array($sql_bids);
					$arrematado_auctionID = $auction_id;               //id do leilão arrematado
					$arrematado_userID    = $historyBids['user_id'];   //id do usuário que deu o ultimo lance
					$arrematado_latestBid = $historyBids['id'];        //id do ultimo lance
				} else {
					//caso o leilão não tenha tido nenhum lance, insere como arrematador 0, indicando que
					//ninguém ganhou e o ultimo bid também como 0, indicando que não há nenhum lance 
					$arrematado_auctionID = $auction_id;  //id do leilão arrematado
					$arrematado_userID    = 0;            //indica que não houve ganhador
					$arrematado_latestBid = 0;            //iindica que não há lance
				}
						
				$sql_arrematados = "INSERT INTO arrematados (`id`, `auction_id`, `user_id`, `history_bid_id`, `created`, `modified`)
									VALUE (NULL,'" . $arrematado_auctionID . "', 
												'" . $arrematado_userID ."', 
												'" . $arrematado_latestBid . "', 
												CURDATE(), 
												CURDATE() )";
		
				//insere na tabela arrematados os dados do leilão arrematado, ou seja, o id do leilão,
				//o id de quem arrematou e o id do ultimo lance
				$rs_arrematados = mysql_query($sql_arrematados);
		
			} else {
				$rs_arrematados = true;
			}
		
			if($rs_auction && $rs_arrematados){
				$this->avisarGanhador($auction_id);
				return 1;
			} else {
				return 0;
			}
		}
	}
	
	/**
	 * Função responsável por enviar um email ao ganhador do leilão avisando como deve proceder
	 * após ter arrematado um produto.
	 * 
	 * @param $auction_id, o id do leilão
	 * @return void
	 */
	function avisarGanhador($auction_id = null){
		if (!empty($auction_id)){
			$sql = mysql_query("SELECT arr.*, au.id, au.produto_id,prod.id, prod.titulo_produto, prod.valor_mercado, 
					hb.id, hb.valor, us.id, us.nome_user, us.email_user 
					FROM arrematados arr, auctions au, produtos prod, history_bids hb, users us
					WHERE arr.auction_id = " . $auction_id . "
					AND au.id = arr.auction_id
					AND prod.id = au.produto_id
					AND hb.id = arr.history_bid_id
					AND hb.auction_id = au.id
					AND us.id = hb.user_id LIMIT 1") or die (mysql_error());
		
			$dados_ganhador = mysql_fetch_array($sql);
		
			$produto          = $dados_ganhador['titulo_produto'];
			$valor_mercado    = $dados_ganhador['valor_mercado'];
			$valor_arrematado = $dados_ganhador['valor'];
			$nome_user        = $dados_ganhador['nome_user'];
			$email_user       = $dados_ganhador['email_user'];
		
			$msg = "<p>Parabéns " . $nome_user . ",</p>
			<p>Você acaba de arrematar um(a) " . $produto . " no valor de R$ " . $this->moeda($valor_mercado) . " 
			pelo valor de R$ " . $this->moeda($valor_arrematado) . "</p>		
			<p><a href='http://www.twik.com.br/pages/view/como-funciona'>Clique aqui</a> e saiba como
			proceder para receber em sua casa o produto arrematado!</p>		
			<p>Parabéns!</p>
			<p>Se você não se cadastrou em nosso site e muito menos participou de algum dos nossos leilões, 
			por favor contate o administrador através do formulário de contato, confirmando esse fato.</p>";
		
			//configurações do cabeçalho para envio de email com HTML
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\n";
			$headers .= "From: twik <contato@twik.com.br>";

			//aqui envia o e-mail para o email de destino
			mail($email_user, "twik - Parabéns", $msg, $headers);
		}
	}
	

// Recebe o parametro $numero
// Existe outra maneira muito mais fácil
// Mas o objetivo e trabalhar seus conhecimentos
function moeda($numero)
{
	if(strpos($numero,'.')!='')
	{
		   $var=explode('.',$numero);
		   if(strlen($var[0])==4)
		   {
		     $parte1=substr($var[0],0,1);
		     $parte2=substr($var[0],1,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1].'0';
		     }else
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==5)
		   {
		     $parte1=substr($var[0],0,2);
		     $parte2=substr($var[0],2,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==6)
		   {
		     $parte1=substr($var[0],0,3);
		     $parte2=substr($var[0],3,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==7)
		   {
		     $parte1=substr($var[0],0,1);
		     $parte2=substr($var[0],1,3);
		     $parte3=substr($var[0],4,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
		     }
		     else
		     {
		     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==8)
		   {
		     $parte1=substr($var[0],0,2);
		     $parte2=substr($var[0],2,3);
		     $parte3=substr($var[0],5,3);
		     if(strlen($var[1])<2){
		     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
		     }else{
		     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==9)
		   {
		     $parte1=substr($var[0],0,3);
		     $parte2=substr($var[0],3,3);
		     $parte3=substr($var[0],6,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.','.$var[1];
		     }
		   }
		   elseif(strlen($var[0])==10)
		   {
		     $parte1=substr($var[0],0,1);
		     $parte2=substr($var[0],1,3);
		     $parte3=substr($var[0],4,3);
		     $parte4=substr($var[0],7,3);
		     if(strlen($var[1])<2)
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.$var[1].'0';
		     }
		     else
		     {
		     	$formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.$var[1];
		     }
		   }
		   else
		   {
		     if(strlen($var[1])<2)
		     {
		    	 $formatado=$var[0].','.$var[1].'0';
		     }
		     else
		     {
		    	 $formatado=$var[0].','.$var[1];
		     }
		   }
	  }
	  else
	  {
	     $var=$numero;
	   if(strlen($var)==4)
	   {
	     $parte1=substr($var,0,1);
	     $parte2=substr($var,1,3);
	     $formatado=$parte1.'.'.$parte2.','.'00';
	   }
	   elseif(strlen($var)==5)
	   {
	     $parte1=substr($var,0,2);
	     $parte2=substr($var,2,3);
	     $formatado=$parte1.'.'.$parte2.','.'00';
	   }
	   elseif(strlen($var)==6)
	   {
	     $parte1=substr($var,0,3);
	     $parte2=substr($var,3,3);
	     $formatado=$parte1.'.'.$parte2.','.'00';
	   }
	   elseif(strlen($var)==7)
	   {
	     $parte1=substr($var,0,1);
	     $parte2=substr($var,1,3);
	     $parte3=substr($var,4,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
	   }
	   elseif(strlen($var)==8)
	   {
	     $parte1=substr($var,0,2);
	     $parte2=substr($var,2,3);
	     $parte3=substr($var,5,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
	   }
	   elseif(strlen($var)==9)
	   {
	     $parte1=substr($var,0,3);
	     $parte2=substr($var,3,3);
	     $parte3=substr($var,6,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.','.'00';
	   }
	   elseif(strlen($var)==10)
	   {
	     $parte1=substr($var,0,1);
	     $parte2=substr($var,1,3);
	     $parte3=substr($var,4,3);
	     $parte4=substr($var,7,3);
	     $formatado=$parte1.'.'.$parte2.'.'.$parte3.'.'.$parte4.','.'00';
	   }
	   else
	   {
	     $formatado=$var.','.'00';
	   }
	}
	  return $formatado;
}	
}
?>