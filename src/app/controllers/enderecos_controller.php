<?php
class EnderecosController extends AppController {

	var $name = 'Enderecos';
	var $helpers = array('Html', 'Form', 'Javascript', 'Ajax');
	var $uses = array('Estado', 'Cidade', 'Endereco');
	var $components =  array('RequestHandler');
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('add', 'edit');
	}

	function index() {
		$this->Endereco->recursive = 0;
		$this->set('enderecos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Endereco.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('endereco', $this->Endereco->read(null, $id));
	}

	function add() {
		if ($this->Session->check('Auth.User.id')){
			// VERIFICA SE O USUÁRIO JÁ NÃO TEM UM ENDEREÇO CADASTRADO. SE TIVER, REDIRECIONA ELE PARA A FUNÇÃO EDIT.
			if ($this->Endereco->find('count', array('conditions' => array('Endereco.user_id' => $this->Session->read('Auth.User.id')))) > 0){
				$this->redirect('/enderecos/edit');
			}			
			
			$this->layout = 'home';
			if (!empty($this->data)) {
				$this->data['Endereco']['user_id'] = $this->Session->read('Auth.User.id');
				$this->data['Endereco']['cidade_id'] = $this->data['Endereco']['cidades'];
				$this->Endereco->create();
				if ($this->Endereco->save($this->data)) {
					$this->Session->setFlash(__('Seus dados foram salvos com sucesso', true));
					$this->redirect(array('controller' => 'enderecos', 'action' => 'edit'));
				} else {
					$this->Session->setFlash(__('Seus dados não foram salvos. Por favor, tente novamente.', true));
					//debug($this->Endereco->validationErrors);
					
					//CASO NÃO TENHA SALVO, MAS O USUÁRIO SELECIONOU ALGUM ESTADO E UMA CIDADE
					if (!empty($this->data['Endereco']['estados'])){
						// lista as cidades de acordo com o estado
						$cidades = $this->Cidade->find('list', array('conditions' => array('estado_id' => $this->data['Endereco']['estados']), 'fields' => array('Cidade.id', 'Cidade.cidade')));
						$this->set('cidades', $cidades);
					}
				}
			} 
			// LISTA OS ESTADOS
			$estados = $this->Estado->find('list', array('fields' => array('Estado.id', 'Estado.nome')));
				
			if (empty($this->data['Endereco']['estados'])){
				// LISTA AS CIDADES DO PRIMEIRO ESTADO (Acre)
				$cidades = $this->Cidade->find('list', array('conditions' => array('estado_id' => 1), 'fields' => array('Cidade.id', 'Cidade.cidade')));
				$this->set('cidades', $cidades);
			}
				
			// ATRIBUI A ESTADOS, O NOME DOS ESTADOS COM AS ACENTUAÇÕES CORRETAS.
			// UMA SOLUÇÃO TEMPORÁRIA.
			for($i = 1; $i <= count($estados); $i++){
				$estados[$i] = utf8_encode($estados[$i]);
			}
			
			$this->set('estados', $estados);						
		
		} else {
			$this->redirect(array('controller' => 'user', 'action' => 'login'));
		}
	}

	function edit($id = null) {
		$this->layout = 'home';
		if ($this->Session->check('Auth.User.id')){		
			$myAddress = $this->Endereco->find('first', array(
				'conditions' => array('Endereco.user_id' => $this->Session->read('Auth.User.id')),
				'limit' => 1,
				'order' => array('Endereco.id DESC')
			));
			if (!empty($this->data)) {
				$this->data['Endereco']['id'] = $myAddress['Endereco']['id'];
				if ($this->Endereco->save($this->data)) {
					$this->Session->setFlash(__('Seus dados foram salvos com sucesso!', true));
					$this->redirect(array('controller' => 'enderecos', 'action' => 'edit'));
				} else {
					$this->Session->setFlash(__('Seus dados não foram salvos. Por favor, tente novamente', true));
				}
			}
		
			if (empty($this->data)) {
				$this->data = $this->Endereco->read(null, $this->Session->read('Auth.User.id'));
			}
		
			$cidades = $this->Cidade->find('list', array('conditions' => array('Cidade.estado_id' => $myAddress['Cidade']['estado_id']) , 'fields' => array('Cidade.id', 'Cidade.cidade')));
			$estados = $this->Estado->find('list', array('fields' => array('Estado.id', 'Estado.nome')));
			
			// ATRIBUI A ESTADOS, O NOME DOS ESTADOS COM AS ACENTUAÇÕES CORRETAS.
			// UMA SOLUÇÃO TEMPORÁRIA.
			for($i = 1; $i <= count($estados); $i++){
				$estados[$i] = utf8_encode($estados[$i]);
			}
		
			$this->set(compact('cidades', 'estados', 'myAddress'));
			//debug($myAddress);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Endereco', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Endereco->del($id)) {
			$this->Session->setFlash(__('Endereco deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Endereco->recursive = 0;
		$this->set('enderecos', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Endereco.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('endereco', $this->Endereco->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Endereco->create();
			if ($this->Endereco->save($this->data)) {
				$this->Session->setFlash(__('The Endereco has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Endereco could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Endereco->User->find('list');
		$cidades = $this->Endereco->Cidade->find('list');
		$this->set(compact('users', 'cidades'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Endereco', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Endereco->save($this->data)) {
				$this->Session->setFlash(__('The Endereco has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Endereco could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Endereco->read(null, $id);
		}
		$users = $this->Endereco->User->find('list');
		$cidades = $this->Endereco->Cidade->find('list');
		$this->set(compact('users','cidades'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Endereco', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Endereco->del($id)) {
			$this->Session->setFlash(__('Endereco deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>