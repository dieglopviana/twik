<?php
class ProdutosController extends AppController {

	var $name = 'Produtos';
	var $helpers = array('Html', 'Form');
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('');		
	}

	function admin_index() {
		$this->layout = 'admin';
		$this->Produto->recursive = 0;
		$this->set('produtos', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Produto.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('produto', $this->Produto->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin';
		if (!empty($this->data)) {
			$this->Produto->create();
			if ($this->Produto->save($this->data)) {
				$this->Session->setFlash(__('Produto salvo com sucesso!', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('O produto n?o pode ser salvo. Por favor, tente novamente!', true));
			}
		}
		$categorias = $this->Produto->Categoria->find('list', array('fields' => array('id','titulo_categoria') ) );
		$this->set(compact('categorias'));
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Produto', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Produto->save($this->data)) {
				$this->Session->setFlash(__('Produto alterado com sucesso', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('N?o foi poss?vel alterar o produto. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Produto->read(null, $id);
		}
		$categorias = $this->Produto->Categoria->find('list', array('fields' => array('id','titulo_categoria') ) );
		$this->set(compact('categorias'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Produto', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Produto->del($id)) {
			$this->Session->setFlash(__('Produto deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>