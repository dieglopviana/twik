<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Javascript', 'CakePtbr.Formatacao');
	var $uses = array('User', 'UserBid', 'UserFoto', 'Indicado', 'HistoryBid', 'Auction', 'Arrematado');	
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('add', 'activate', 'login', 'reset');
	}

	/**
	 * Página inicial do link minha conta
	 * 
	 * @return void
	 */
	function index(){
		if($this->Session->check('Auth.User.id')){
			$this->layout = 'home';
			$this->set('users', $this->User->findByid($this->Session->read('Auth.User.id')));
		} else {
			$this->redirect(array('action' => 'login'));
		}
	}
	
	function view($id = null) {
		$this->layout = 'home';
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	/**
	 * Cadastro de usuários no site. Manda um
	 * email para o email cadastrado com uma chave
	 * de ativação gerada pelo sistema.
	 * 
	 * @return void
	 */
	function add() {
		$this->layout = 'home';
		if (!empty($this->data)) {
			if(!empty($this->data['User']['senha'])) {
				$this->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['senha']);
			}
			
			$this->data['User']['key'] = Security::hash(uniqid(rand(), true));
			
			$this->User->create();
			if ($this->User->save($this->data)) {
				$user = $this->User->read(null, $this->User->getLastInsertID());
				$userBidData['UserBid']['user_id'] = $user['User']['id'];
				$userBidData['UserBid']['quantidade'] = 5;
				$this->UserBid->create();
				$activate = $this->UserBid->save($userBidData);
				
				if(!empty($this->data['User']['indicado'])){
					$indicacao = $this->addIndicacao($this->data['User']['indicado'], $user['User']['id']);
				}
				
				if($activate){
					$user['to'] = $user['User']['email_user'];
					$user['subject'] = 'Twik - Ative seu cadastro!';
					$user['template'] = 'users/activate';
					$user['User']['senha'] = $this->data['User']['senha'];
					if($this->_sendEmail($user)){
						$this->Session->setFlash(__('Parabéns! Você agora só precisa confirmar seu cadastro através do seu email', true));
						$this->redirect(array('action' => 'login'));
					}
				}
				
				$this->Session->setFlash(__('Cadastro feito com sucesso!', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('O usuário não foi cadastrado. Por favor, tente novamente.', true));
				if(!$this->User->validates()){
					$this->set('erros', $this->User->invalidFields());
				}
				//debug($this->User->validationErrors); 
			}
		}
	}
	
	/**
	 * Caso na hora do cadastro, o usuário informou ter sido
	 * indicado por alguém, será adicionado a indicação, ou seja,
	 * o ID de quem indicou e o ID do indicado
	 * 
	 * @return true se cadastrar e false caso contrário	
	 */
	function addIndicacao($quemIndicou, $indicado){
		if(!empty($quemIndicou) && !empty($indicado)){
			$user = $this->User->find('first', array('conditions' => array('or' => array('User.username' => $quemIndicou, 'User.email_user' => $quemIndicou))));
			if($user){
				$indicadoData['Indicado']['user_id'] = $user['User']['id'];
				$indicadoData['Indicado']['indicado_id'] = $indicado;
				$this->Indicado->create();
				if($this->Indicado->save($indicadoData)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Função responsável por ativar a conta do usuário.
	 * No email do usuário, vai um link com a chave de ativação,
	 * esta função recebe a chave, verifica se existe e caso exista,
	 * altera o campo status do usuário para 1 (um), ou seja, ativado.
	 * E caso o usuário tenha insirido alguma indicação, quem o indicou
	 * ganha 10 lances. (Isso pode ser alterado). Caso tenha tido essa
	 * indicação, esta função envia um email para quem indicou informando que
	 * ele ganhou 10 lances por ter indicado alguém.
	 * 
	 * @param String $key - Chave de ativação encriptografada
	 * @return void
	 */
	function activate($key){
		$user = $this->User->find('first', array('conditions' => array('User.key' => $key, 'User.status' => 0)));
		if(!empty($user)){
			$user['User']['status'] = 1;
			if($this->User->save($user)){
				$indicacao = $this->Indicado->find('first', array(
					'conditions' => array(
						'Indicado.indicado_id' => $user['User']['id'], 'Indicado.confirmado' => 0)
					)
				);
				
				if($indicacao){
					$quemIndicou = $this->User->findByid($indicacao['Indicado']['user_id']);
					$quemIndicouBids = $this->UserBid->findByuser_id($quemIndicou['User']['id']);
					
					$quemIndicouBidsData['UserBid']['id'] = $quemIndicouBids['UserBid']['id'];
					$quemIndicouBidsData['UserBid']['quantidade'] = $quemIndicouBids['UserBid']['quantidade'] + 10;
					
					if($this->UserBid->save($quemIndicouBidsData)){
						$indicacaoData['Indicado']['id'] = $indicacao['Indicado']['id'];
						$indicacaoData['Indicado']['confirmado'] = 1;
						if($this->Indicado->save($indicacaoData)){
							$quemIndicou['to'] = $quemIndicou['User']['email_user'];
							$quemIndicou['subject'] = 'Twik - Aqui, quem indica alguém, ganha lances!';
							$quemIndicou['template'] = 'users/indicacao';
							$quemIndicou['Indicado']['nome'] = $user['User']['nome_user'];
							$quemIndicou['Indicado']['email'] = $user['User']['email_user'];
							$quemIndicou['Lances'] = 10;
							
							if($this->_sendEmail($quemIndicou)){
								$this->Session->setFlash(__('Seu cadastro foi ativado com sucesso!', true));
								$this->redirect(array('action' => 'login'));								
							}
						}
					}
				}
				
				$this->Session->setFlash(__('Seu cadastro foi ativado com sucesso!', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('Não foi possível ativar seu cadastro!', true));
				$this->redirect(array('action' => 'login'));
			}
		} else {
			$this->redirect('/');
		}
	}
	
	/**
	 * Função responsável por editar os dados do usuário
	 * 
	 * @param $id - Código do usuário
	 * @return void
	 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}
	
	function login() {
		$this->layout = 'home';
		if(!empty($this->data)) {
			if($this->Auth->login()) {
				if($this->Auth->user('status') == 1) {					
					$bidsUser = $this->UserBid->find('first', array('conditions' => array('UserBid.user_id' => $this->Auth->user('id'))));
					$this->Session->write('Auth.UserBid.quantidade', $bidsUser['UserBid']['quantidade']);
					
					$foto_user = $this->UserFoto->find('first', array(
						'conditions' => array('UserFoto.user_id' => $this->Session->read('Auth.User.id')),
						'fields'     => array('id', 'image'),
						'order'      => array('UserFoto.id DESC'),
						'limit'      => 1));
					if($foto_user != 0){
						$this->Session->write('Auth.UserFoto.id', $foto_user['UserFoto']['id']);
						$this->Session->write('Auth.UserFoto.image', $foto_user['UserFoto']['image']);
					}
					
					$this->redirect('/');
				} else {
					$this->Auth->logout();
					$this->Session->setFlash(__('Sua conta ainda não foi ativada ou está suspensa.', true));					
					$this->redirect(array('action' => 'login'));					
				}
			} 
		}
	}
	
	function logout(){
		if($this->Auth->logout()){
			$this->Session->destroy();
			$this->redirect('/');
		}
	}
	
	/**
	 * Função responsável por gerar uma nova senha para o usuário
	 * e a enviar para o email cadastrado
	 * 
	 * @return void
	 */
	function reset(){
		$this->layout = 'home';
		if (!empty($this->data)){
			//consulta o usuário pelo email
			$user = $this->User->find('first', array('conditions' => array('User.email_user' => $this->data['User']['email'])));
			
			if (!empty($user)){
				//cria uma nova senha sem criptografar ainda
				$user['User']['senha'] = substr(sha1(uniqid(rand(), true)), 0, 8);
				
				//Seta os dados para enviar no email do usuário
				$user['to'] = $user['User']['email_user'];
				$user['subject'] = 'twik - Sua nova senha';
				$user['template'] = 'users/reset';
				
				//seta a nova senha criptografada
				$user['User']['password'] = Security::hash(Configure::read('Security.salt').$user['User']['senha']);
				
				//Salva no banco a nova senha do usuário
				if ($this->User->save($user)){
					//se salvar corretamente, envia para o usuário a nova senha
					if ($this->_sendEmail($user)){
						$this->Session->setFlash(__('Sua nova senha foi enviada para o seu email', true));
						$this->redirect(array('action' => 'login'));
					}
				} else {
					$this->Session->setFlash(__('Não foi possível criar uma nova senha. Por favor, tente novamente!', true));
					$this->redirect(array('action' => 'reset'));
				}
			} else {
				$this->Session->setFlash(__('O email digitado não existe. Por favor, tente novamente!', true));
				$this->redirect(array('action' => 'reset'));
			}
		}
	}

	/**
	 * Função responsável por trocar a senha do usuário e informá-lo pelo
	 * email, seus novos dados de acesso.
	 * 
	 * @return void
	 */
	function changepassword(){
		$this->layout = 'home';
		if (!empty($this->data)){
			
			$this->data['User']['id'] = $this->Auth->user('id');
			
			if (!empty($this->data['User']['senha'])){
				$this->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['senha']);
			}
			
			if ($this->User->validates()){
				if ($this->User->save($this->data)){
					$user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
					$user['User']['senha'] = $this->data['User']['senha'];
					$user['to'] = $user['User']['email_user'];
					$user['subject'] = 'twik - Alteração da sua senha';
					$user['template'] = 'users/changepassword';
				
					if ($this->_sendEmail($user)){
						$this->Session->setFlash(__('Senha alterada com sucesso!', true));
						$this->redirect(array('action' => 'index'));
					}
				} else {
					$this->Session->setFlash(__('Não foi possível alterar sua senha. Por favor, tente novamente!', true));
				}
			}
		}
	}
	
	function arrematados(){
		$this->layout = 'home';		
		$user_id = $this->Session->read('Auth.User.id');
		
		$arrematados = $this->Arrematado->find('all', array('conditions' => array('Arrematado.user_id' => $user_id), 'limit' => 10,	'order' => array('Arrematado.id DESC')));		
	
		$i = 0;
		foreach($arrematados as $arrematado){
			$this->Auction->contain('Produto');
			$auctions = $this->Auction->find('first', array('conditions' => array('Auction.id' => $arrematado['Arrematado']['auction_id'])));
			$arrematados[$i]['Auction'] = $auctions['Auction'];
			$arrematados[$i]['Produto'] = $auctions['Produto'];
			
			/*$this->User->contain();
			$users = $this->User->find('first', array('conditions' => array('User.id' => $arrematado['Arrematado']['user_id'])));
			$arrematados[$i]['User'] = $users['User'];*/
			
			$i++;
		}
		
		$this->set('arrematados', $arrematados);
		//debug($arrematados);
	}

	function admin_index() {
		$this->layout = 'admin';
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		//debug($this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin';
		if (!empty($this->data)) {
			if(!empty($this->data['User']['senha'])) {
				$this->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['senha']);
			}
			
			$this->data['User']['key'] = Security::hash(uniqid(rand(), true));
			
			$this->User->create();
			if ($this->User->save($this->data)) {
				$user = $this->User->read(null, $this->User->getLastInsertID());
				$userBidData['UserBid']['user_id'] = $user['User']['id'];
				$userBidData['UserBid']['quantidade'] = 5;
				$this->UserBid->create();
				$activate = $this->UserBid->save($userBidData);
				
				if(!empty($this->data['User']['indicado'])){
					$indicacao = $this->addIndicacao($this->data['User']['indicado'], $user['User']['id']);
				}
				
				if($activate){
					$user['to'] = $user['User']['email_user'];
					$user['subject'] = 'Twik - Ative seu cadastro!';
					$user['template'] = 'users/activate';
					$user['User']['senha'] = $this->data['User']['senha'];
					if($this->_sendEmail($user)){
						$this->Session->setFlash(__('Parabéns! Você agora só precisa confirmar seu cadastro através do seu email', true));
						$this->redirect(array('action' => 'login'));
					}
				}
				
				$this->Session->setFlash(__('Cadastro feito com sucesso!', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('O usuário não foi cadastrado. Por favor, tente novamente.', true));
				if(!$this->User->validates()){
					$this->set('erros', $this->User->invalidFields());
				}
				//debug($this->User->validationErrors); 
			}
		}		
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Código de usuário inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data) && $this->User->UserBid->save($this->data)) {
				$this->Session->setFlash(__('Alteração realizada com sucesso', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Não foi possível realizar a alteração. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		//debug($this->data);
	}

	function admin_delete($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Còdigo de usuário inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('Usuário excluído com sucesso', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function admin_login(){
		if ($this->Session->check('Auth')){
			$this->Auth->logout();	
		} else {
			$this->redirect('/');
		}
	}
	
	/**
	 * Função para verificar se o usuário logado
	 * é um administrador
	 * 
	 * @return true se for admin e false caso contrário
	 */
	function verifica_admin(){
		if ($this->Session->check('Auth.User.admin')){
			if ($this->Session->read('Auth.User.admin') == 1){
				return true;
			} else {
				return false;
			}
		}
	}

}
?>