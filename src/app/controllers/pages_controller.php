<?php
class PagesController extends AppController {

	var $name = 'Pages';
	var $helpers = array('Html', 'Form');

	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('view', 'contato', 'getpages');
	}	
	
	function view($link = null) {
		$this->layout = 'home';
		if (!$link) {
			$this->Session->setFlash(__('Página inválida.', true));
			$this->redirect('/');
		}
		$page = $this->Page->findBylink($link);
		if(!empty($page)){
			$this->set('page', $page);
		}else{
			$this->Session->setFlash(__('Página inválida.', true));
			//$this->redirect('/');
		}
	}
	
	/**
	 * Função responsável por enviar o contato.
	 * E também pela página de contato.
	 * 
	 * @return void
	 */
	function contato(){
		$this->layout = 'home';
		if(!empty($this->data)){
			$this->Page->set($this->data);
			if($this->Page->validates()){
				$this->data['to'] = 'dieglopviana@hotmail.com';
				$this->data['subject'] = 'Contato - ' . $this->data['Page']['assunto'];
				$this->data['template'] = 'pages/contato';
				if($this->_sendEmail($this->data)){
					$this->Session->setFlash(__('Mensagem enviada! Assim que possível entraremos em contato', true));
					$this->redirect(array('action' => 'contato'));
				} else {
					$this->Session->setFlash(__('Não foi possível enviar sua mensagem, por favor, tente novamente!', true));
					$this->redirect(array('action' => 'contato'));
				}
			} else {
				$this->Session->setFlash(__('Não foi possível enviar sua mensagem, por favor, verifique seus dados!', true));
			}
		}
	}
	
	/**
	 * Função responsável por montar os itens do menu
	 * 
	 * @return O array com o resultado da consulta 
	 */
	function getpages($position = 'top') {
		return $this->Page->find('all', array('conditions' => 'Page.'.$position.'_show > 0', 'order' => 'Page.id ASC'));
	}
	
	function admin_index() {
		$this->layout = 'admin';
		$this->Page->recursive = 0;
		$this->set('pages', $this->paginate());
	}

	function admin_add() {
		$this->layout = 'admin';
		if (!empty($this->data)) {
			$this->Page->create();
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('Página adicionada com sucesso', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Não foi possível adicionar a página. Por favor, tente novamente.', true));
			}
		}
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Página inválida', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$name = strtolower($this->data['Page']['name']);
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('Página alterada com sucesso', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Não foi possível alterar a página. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Page->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('código da página inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Page->del($id)) {
			$this->Session->setFlash(__('Página apagada com sucesso', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>