<?php
class ProdutoImagesController extends AppController {

	var $name = 'ProdutoImages';
	var $helpers = array('Html', 'Form');
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow();		
	}

	function admin_index($produto_id = null) {
		$this->layout = 'admin';
		if(empty($produto_id)) {
			$this->Session->setFlash(__('O Código do produto é inválido!.', true));
			$this->redirect(array('controller' => 'produtos', 'action'=>'index'));
		}
		$produto = $this->ProdutoImage->Produto->read(null, $produto_id);
		/*if(empty($produto)) {
			$this->Session->setFlash(__('O Código do produto é inválido!.', true));
			$this->redirect(array('controller' => 'produtos', 'action'=>'index'));
		}*/
		$this->set('produto', $produto);
		
		$this->ProdutoImage->recursive = 0;
		$this->paginate = array('conditions' => array('produto_id' => $produto_id) );
		$this->set('produtoImages', $this->paginate());
	}

	function admin_add($produto_id) {
		$this->layout = 'admin';
		if(empty($produto_id)){
			$this->Session->setFlash(__('O Código do produto não pode estar vazio!'));
			$this->redirect(array('controller' => 'produtos', 'action' => 'index'));
		}
		
		$this->set('produto_id', $produto_id);
		
		if (!empty($this->data)) {
			$this->data['ProdutoImage']['produto_id'] = $produto_id;
			$this->ProdutoImage->create();
			if ($this->ProdutoImage->save($this->data)) {
				$this->Session->setFlash(__('Imagem carregada com sucesso!', true));
				$this->redirect(array('action'=>'index/' . $produto_id));
			} else {
				$this->Session->setFlash(__('A imagem não pode ser carregada. Por favor, tente novamente.', true));
			}
		}
		$produtos = $this->ProdutoImage->Produto->find('list');
		$this->set(compact('produtos'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Código Inválido', true));
			$this->redirect(array('action'=>'index/' . $id));
		}
		$image = $this->ProdutoImage->read(null, $id);
		if(empty($image)) {
			$this->Session->setFlash(__('Código inválido.', true));
			$this->redirect(array('action'=>'index/' . $id));
		}
		if ($this->ProdutoImage->del($id)) {
			$this->Session->setFlash(__('imagem excluída com sucesso!', true));
			$this->redirect(array('action'=>'index/' . $image['Produto']['id']));
		}
	}

}
?>