<?php
class AuctionsController extends AppController {

	var $name = 'Auctions';
	var $helpers = array('Html', 'Form', 'CakePtbr.Formatacao', 'Javascript');
	var $uses = array('Auction', 'ProdutoImage', 'HistoryBid', 'UserBid', 'UserFoto');

	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('index', 'view', 'destaques', 'ultimos_arrematado', 'busca');		
	}
	
	/**
	 * Função responsável por listar os leilões na home, tanto os leilões em sí como
	 * os destaques. Pode listar os leilões de forma ordenada caso $order seja passado.
	 * 
	 * @param $order - Parâmetro usado para ordenar os leilões. Suas opções são: "menor-lance" para
	 * listar os leilões ordenando pelo menor lance e "valor-de-mercado-mais-alto" para listar os
	 * leilões ordenando pelo valor de mercado mais alto dos produtos
	 * @return void
	 */
	function index($order = null) {
		$this->layout = 'home';
		$this->Auction->recursive = 0;
		$rs_auctions = $this->Auction->find('all', array('conditions' => array('Auction.status_auction' => 1, 'Auction.arrematado' => 0 ), 'limit' => 8, 'order' => array('Auction.data_inicio ASC') ) );
		
		$this->ProdutoImage->contain();
		$this->HistoryBid->contain();
		
		for($i = 0; $i < count($rs_auctions); $i++){
			//consulta para obter a primeira imagem do produto
			//aqui $rs_imagens vai ser um array com chave sendo o id do produto
			$rs_imagens[$rs_auctions[$i]['Produto']['id']] = $this->ProdutoImage->find('all', array('conditions' => array('produto_id' => $rs_auctions[$i]['Produto']['id']), 'limit' => 1, 'order' => 'ProdutoImage.id ASC' ) );
			
			//$rs_auctios já é um array contendo todas as informações do leilão, incluse do produto,
			//só que não tem a imagem, então adicionamos mais uma chave ao $rs_auctions referente a imagem
			$rs_auctions[$i]['ProdutoImage']['image'] = $rs_imagens[$rs_auctions[$i]['Produto']['id']][0]['ProdutoImage']['image'];
						
			//Aqui ocorre o mesmo que para a imagem, só que agora queremos o ultimo lance dado
			//como queremos o ultimo, limitamos a 1 a consulta e ordenamos por DESC
			$rs_HistoryBids[$rs_auctions[$i]['Auction']['id']] = $this->HistoryBid->find('all', array('conditions' => array('auction_id' => $rs_auctions[$i]['Auction']['id']), 'limit' => 1, 'order' => 'HistoryBid.id DESC' ) );
						
			//pode ocorrer de ainda um lailão não ter lances, então temos que definir para 0
			//se o resultado for vazio
			if (empty($rs_HistoryBids[$rs_auctions[$i]['Auction']['id']][0]['HistoryBid']['valor'])){
				$rs_HistoryBids[$rs_auctions[$i]['Auction']['id']][0]['HistoryBid']['valor'] = 0;
			}		
			
			//Agora precisamos adicionar as chaves para fazer a ordernação dos leilões na home que pode ser
			//pelo valor de mercado mais alto, pelo menor lance e pela data mais próxima.
			//O valor order tem que sert multiplicado por 100 para se tornar um valor inteiro.
			$rs_auctions[$i]['OrderHome']['valor_order'] = $rs_HistoryBids[$rs_auctions[$i]['Auction']['id']][0]['HistoryBid']['valor'] * 100;
			$rs_auctions[$i]['OrderHome']['valor_mercado'] = str_replace(array('R$', '.', ' ', ','), '', $rs_auctions[$i]['Produto']['valor_mercado']);
		}
		
		$keyWords = '';
		foreach($rs_auctions as $auction){
			$keyWords .= $auction['Produto']['titulo_produto'] .', ';
		}
		$this->Session->write('keyWords', $keyWords);
		
		//Aqui fazemos a ordenação, caso $order não seja vazio
		if (!empty($order)){
			if ($order == 'menor-lance'){
				$rs_auctions = Set::sort($rs_auctions, '{n}.OrderHome.valor_order', 'ASC');
			} else 
			if ($order == 'valor-de-mercado-mais-alto'){
				$rs_auctions = Set::sort($rs_auctions, '{n}.OrderHome.valor_mercado', 'DESC');
			}			
		}
		
		$this->set('auctions', $rs_auctions);
		$this->set('estou_na_home', $this->params['url']); //para o element destaques saber que estou na home
		//debug($rs_auctions);
	}

	function view($id = null) {
		$this->layout = 'home';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Auction->contain('Produto');
		$rs_auction = $this->Auction->findByid($id);
		
		$this->ProdutoImage->contain();
		$rs_auction['ImagesAuction'] = $this->ProdutoImage->find('all', array('conditions' => array('ProdutoImage.produto_id' => $rs_auction['Produto']['id'])));
		
		$this->set('auction', $rs_auction);
	}
	
	function bid($id = null){
		if($this->Session->read('Auth.UserBid.quantidade') > 0){
			$this->layout = 'json/default';		
			$conditions = array('Auction.id' => $id);
			$fields = array('valor_inicial', 'valor_lance');
			$auction = $this->Auction->find('first', array('conditions' => $conditions, 'fields' => $fields));		
				
			$conditionsBids = array('HistoryBid.auction_id' => $id);		
			$historyBids = $this->HistoryBid->find('first', array('conditions' => array($conditionsBids), 'order' => array('HistoryBid.id DESC'), 'limit' => 1));		
		
			$historyBidsData['HistoryBid']['auction_id'] = $id;
			$historyBidsData['HistoryBid']['user_id'] = $this->Auth->user('id');
		
			if(!empty($historyBids)){
				$historyBidsData['HistoryBid']['valor'] = $historyBids['HistoryBid']['valor'] + $auction['Auction']['valor_lance'];
				$saveBid = $this->HistoryBid->save($historyBidsData);
			} else {
				$historyBidsData['HistoryBid']['valor'] = $auction['Auction']['valor_inicial'] + $auction['Auction']['valor_lance'];
				$saveBid = $this->HistoryBid->save($historyBidsData);
				$this->HistoryBid->create();
			}
		
			if($saveBid){
				$userBids = $this->UserBid->find('first', array('conditions' => array('UserBid.user_id' => $this->Auth->user('id'))));
				if(!empty($userBids)){
					$userBids['UserBid']['quantidade']--;
					if($this->UserBid->save($userBids, false)){
						$this->Session->write('Auth.UserBid.quantidade', $userBids['UserBid']['quantidade']);					
						$this->set('auction', $userBids);
					}  
				}
			} else {
				$this->Auth->logout();
				$this->Session->setFlash(__('Ocorreu um erro grave. Por favor avise o administrador do sistema.', true));					
				$this->redirect(array('action' => 'login'));
			}
		} else {
			$this->redirect(array('action' => 'Você tem que comprar mais lances!'));
		}
	}
	
	/**
	 * Função para exibir os leilões cadastrados como destaque
	 * 
	 * @param limite - Definie até quantos produtos em destaques será exibido 
	 * @return o array contendo todos os dados dos produtos em destaque
	 */
	function destaques($limite){
		$destaques = $this->Auction->find('all', array(
			'conditions' => array(
				'Auction.status_auction' => 1,
				'Auction.destaque' => 1, 
				'Auction.arrematado' => 0 
			), 
			'order' => array('Auction.data_inicio ASC'),
			'limit' => $limite
		));

		if ($destaques != 0){
			$this->ProdutoImage->contain();		
			for($i = 0; $i < count($destaques); $i++){
				$rs_imagens[$destaques[$i]['Produto']['id']] = $this->ProdutoImage->find('all', array('conditions' => array('produto_id' => $destaques[$i]['Produto']['id']), 'limit' => 1, 'order' => 'ProdutoImage.id ASC' ) );
				$destaques[$i]['ProdutoImage']['image'] = $rs_imagens[$destaques[$i]['Produto']['id']][0]['ProdutoImage']['image']; 
			}
			
			return $destaques;	
		}
	}
	
	function ultimos_arrematado($limite = 1){
		$arrematados = $this->Auction->find('all', array(
			'conditions' => array(
				'Auction.status_auction' => 1,
				'Auction.arrematado' => 1 
			), 
			'order' => array('Auction.data_inicio DESC'),
			'limit' => $limite
		));

		if ($arrematados != 0){
			$this->ProdutoImage->contain();		
			for($i = 0; $i < count($arrematados); $i++){
				$rs_imagens[$arrematados[$i]['Produto']['id']] = $this->ProdutoImage->find('all', array('conditions' => array('produto_id' => $arrematados[$i]['Produto']['id']), 'limit' => 1, 'order' => 'ProdutoImage.id ASC' ) );
				$arrematados[$i]['ProdutoImage']['image'] = $rs_imagens[$arrematados[$i]['Produto']['id']][0]['ProdutoImage']['image']; 
			
				//$this->HistoryBid->contain('User');
				$rs_historyBid = $this->HistoryBid->find('first', array('conditions' => array('HistoryBid.auction_id' => $arrematados[$i]['Auction']['id']), 'limit' => 1, 'order' => array('HistoryBid.id DESC')));
				$arrematados[$i]['LatestBid']['user_id'] = $rs_historyBid['HistoryBid']['user_id'];
				$arrematados[$i]['LatestBid']['username'] = $rs_historyBid['User']['username'];
				$arrematados[$i]['LatestBid']['valor'] = $rs_historyBid['HistoryBid']['valor'];

				$rs_foto_user = $this->UserFoto->find('first', array('conditions' => array('UserFoto.user_id' => $arrematados[$i]['LatestBid']['user_id']), 'limit' => 1));
				$arrematados[$i]['LatestBid']['image_user'] = $rs_foto_user['UserFoto']['image'];
			}
			
			return $arrematados;	
			//debug($rs_historyBid);
		}
	}
	
	function busca() {
		$this->layout = 'home';
		
		if (!empty($this->data)){
			
			$busca = $this->data['Auction']['palavra'];
					
			$rs_auctions = $this->Auction->find('all', array(
				'conditions' => array(
					'Auction.busca LIKE' => '%' . $busca . '%', 
					'Auction.status_auction' => 1, 
					'Auction.arrematado' => 0 
				), 
				'limit' => 8, 
				'order' => array('Auction.data_inicio ASC')
			));
		
			$this->ProdutoImage->contain();
			$this->HistoryBid->contain();
		
			for($i = 0; $i < count($rs_auctions); $i++){
				//consulta para obter a primeira imagem do produto
				//aqui $rs_imagens vai ser um array com chave sendo o id do produto
				$rs_imagens[$rs_auctions[$i]['Produto']['id']] = $this->ProdutoImage->find('all', array('conditions' => array('produto_id' => $rs_auctions[$i]['Produto']['id']), 'limit' => 1, 'order' => 'ProdutoImage.id ASC' ) );
			
				//$rs_auctios já é um array contendo todas as informações do leilão, incluse do produto,
				//só que não tem a imagem, então adicionamos mais uma chave ao $rs_auctions referente a imagem
				$rs_auctions[$i]['ProdutoImage']['image'] = $rs_imagens[$rs_auctions[$i]['Produto']['id']][0]['ProdutoImage']['image'];
						
				//Aqui ocorre o mesmo que para a imagem, só que agora queremos o ultimo lance dado
				//como queremos o ultimo, limitamos a 1 a consulta e ordenamos por DESC
				$rs_HistoryBids[$rs_auctions[$i]['Auction']['id']] = $this->HistoryBid->find('all', array('conditions' => array('auction_id' => $rs_auctions[$i]['Auction']['id']), 'limit' => 1, 'order' => 'HistoryBid.id DESC' ) );
						
				//pode ocorrer de ainda um lailão não ter lances, então temos que definir para 0
				//se o resultado for vazio
				if (empty($rs_HistoryBids[$rs_auctions[$i]['Auction']['id']][0]['HistoryBid']['valor'])){
					$rs_HistoryBids[$rs_auctions[$i]['Auction']['id']][0]['HistoryBid']['valor'] = 0;
				}		
			
				//Agora precisamos adicionar as chaves para fazer a ordernação dos leilões na home que pode ser
				//pelo valor de mercado mais alto, pelo menor lance e pela data mais próxima.
				//O valor order tem que sert multiplicado por 100 para se tornar um valor inteiro.
				$rs_auctions[$i]['OrderHome']['valor_order'] = $rs_HistoryBids[$rs_auctions[$i]['Auction']['id']][0]['HistoryBid']['valor'] * 100;
				$rs_auctions[$i]['OrderHome']['valor_mercado'] = str_replace(array('R$', '.', ' ', ','), '', $rs_auctions[$i]['Produto']['valor_mercado']);
			}
		
			$keyWords = '';
			foreach($rs_auctions as $auction){
				$keyWords .= $auction['Produto']['titulo_produto'] .', ';
			}
			$this->Session->write('keyWords', $keyWords);
		
			$this->set('auctions', $rs_auctions);
			//$this->set('estou_na_home', $this->params['url']); //para o element destaques saber que estou na home
			//debug($rs_auctions);
		}
	}

	function admin_index() {
		$this->layout = 'admin';
		$this->Auction->recursive = 0;
		$this->set('auctions', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('auction', $this->Auction->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin';
		if (!empty($this->data)) {
			$this->Auction->create();
			if ($this->Auction->save($this->data)) {
				$this->Session->setFlash(__('Leil?o salvo com sucesso!', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('O leil?o n?o pode ser salvo. Por favor, tente novamente.', true));
			}
		}
		$produtos = $this->Auction->Produto->find('list', array('fields' => array('id', 'titulo_produto'), 'order' => array('titulo_produto ASC') ) );
		$this->set(compact('produtos'));
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Auction->save($this->data)) {
				$this->Session->setFlash(__('Leil?o alterado com sucesso!', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('N?o foi poss?vel alterar o leil?o, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Auction->read(null, $id);
		}
		$produtos = $this->Auction->Produto->find('list', array('fields' => array('id', 'titulo_produto'), 'order' => array('titulo_produto ASC') ) );
		$this->set(compact('produtos'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Auction', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Auction->del($id)) {
			$this->Session->setFlash(__('Auction deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>