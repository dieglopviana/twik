<?php
class CategoriasController extends AppController {

	var $name = 'Categorias';
	var $helpers = array('Html', 'Form');
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('');		
	}

	function admin_index() {
		$this->layout = 'admin';
		$this->Categoria->recursive = 0;
		$this->set('categorias', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Categoria Inválida.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('categoria', $this->Categoria->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin';
		if (!empty($this->data)) {
			$this->Categoria->create();
			if ($this->Categoria->save($this->data)) {
				$this->Session->setFlash(__('A categoria foi salva com sucesso!', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('A categoria não pode ser salva. Por favor, tente novamente!', true));
			}
		}
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Categoria inválida', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Categoria->save($this->data)) {
				$this->Session->setFlash(__('Categoria alterada com sucesso!', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Não foi possível alterar a categoria. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Categoria->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Código da categoria inválido!', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Categoria->del($id)) {
			$this->Session->setFlash(__('Categoria excluída com sucesso!', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>