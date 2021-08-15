<?php
class ArrematadosController extends AppController {

	var $name = 'Arrematados';
	var $helpers = array('Html', 'Form');
	var $uses = array('Arrematado', 'Auction', 'User', 'HistoryBid', 'ProdutoImage', 'Produto', 'UserFoto');

	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('view');
	}
	
	function view($id = null){
		$this->layout = 'home';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Auction->contain('Produto');
		$rs_auction = $this->Auction->findByid($id);
		
		$this->ProdutoImage->contain();
		$rs_auction['ImagesAuction'] = $this->ProdutoImage->find('all', array('conditions' => array('ProdutoImage.produto_id' => $rs_auction['Produto']['id'])));
		
		$this->HistoryBid->contain(array(
			'User' => array(
				'fields' => array('id', 'username')
			),
			'Arrematado' => array(
				'fields' => array('depoimento')
			)
		));
		
		$historyBids = $this->HistoryBid->find('all', array('conditions' => array('HistoryBid.auction_id' => $id), 'limit' => 8, 'order' => array('HistoryBid.id DESC')));
		
		for($i = 0; $i < count($historyBids); $i++){
			$this->UserFoto->contain();
			$foto_user = $this->UserFoto->find('first', array('conditions' => array('UserFoto.user_id' => $historyBids[$i]['User']['id'])));
			$historyBids[$i]['User']['image'] = $foto_user['UserFoto']['image'];
		}
		
		
		$this->set('auction', $rs_auction);
		$this->set('historyBids', $historyBids);
		
		//debug($historyBids);
	}
	
	function admin_index() {
		$this->layout = 'admin';
		
		$this->Arrematado->recursive = 0;
		$this->paginate['Arrematado'] = array('order' => 'Arrematado.id DESC');
		$this->set('arrematados', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		
		if (!$id) {
			$this->flash(__('Código Inválido', true), array('action'=>'index'));
		}
		
		$arrematado = $this->Arrematado->read(null, $id);
		
		$this->HistoryBid->contain(array('User' => array('fields' => array('username'))));
		$arrematado['HistoryBid'] = $this->HistoryBid->find('all', array(
			'conditions' => array(
				'HistoryBid.auction_id' => $arrematado['Arrematado']['auction_id']
			),
			'order' => array('HistoryBid.id DESC')
		));
		
		$this->set('arrematado', $arrematado);		
		//debug($arrematado);
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Arrematado->create();
			if ($this->Arrematado->save($this->data)) {
				$this->flash(__('Arrematado saved.', true), array('action'=>'index'));
			} else {
			}
		}
		$historyBids = $this->Arrematado->HistoryBid->find('list');
		$this->set(compact('historyBids'));
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		
		if (!$id && empty($this->data)) {
			$this->flash(__('Cídigo inválido', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Arrematado->save($this->data)) {
				$this->flash(__('Depoimento adicionado com sucesso!', true), array('action'=>'index'));
				$this->redirect(array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Arrematado->read(null, $id);
		}
		//$historyBids = $this->Arrematado->HistoryBid->find('list');
		//$this->set(compact('historyBids'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Arrematado', true), array('action'=>'index'));
		}
		if ($this->Arrematado->del($id)) {
			$this->flash(__('Arrematado deleted', true), array('action'=>'index'));
		}
	}

}
?>