<?php
class UserFotosController extends AppController {

	var $name = 'UserFotos';
	var $helpers = array('Html', 'Form', 'Javascript');
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow();		
	}	

	/*function index() {
		$this->UserFoto->recursive = 0;
		$this->set('userFotos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UserFoto.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('userFoto', $this->UserFoto->read(null, $id));
	}*/

	function add() {
		$this->layout = 'home';
		if($this->Session->check('Auth')){			
			if (!empty($this->data)) {				
				$this->data['UserFoto']['user_id'] = $this->Session->read('Auth.User.id');
				$this->UserFoto->create();
				if ($this->UserFoto->save($this->data)) {
					$foto_user = $this->UserFoto->find('first', array(
						'conditions' => array('UserFoto.user_id' => $this->Session->read('Auth.User.id')),
						'fields' 	 => array('id', 'image'),
						'order'      => array('UserFoto.id DESC'),
						'limit'      => 1
					));
					$this->Session->write('Auth.UserFoto.id', $foto_user['UserFoto']['id']);
					$this->Session->write('Auth.UserFoto.image', $foto_user['UserFoto']['image']);
					$this->redirect(array('action'=>'edit'));
				} else {
					$this->Session->setFlash(__('The UserFoto could not be saved. Please, try again.', true));
				}
			}
			$users = $this->UserFoto->User->find('list');
			$this->set(compact('users'));
		} else {
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}

	function edit($id = null) {
		$this->layout = 'home';
		if (!$this->Session->check('Auth.UserFoto.id')) {			
			$this->redirect(array('controller' => 'auctions', 'action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['UserFoto']['id'] = $this->Session->read('Auth.UserFoto.id');
			if ($this->UserFoto->save($this->data)) {
				$foto_user = $this->UserFoto->find('first', array(
					'conditions' => array('UserFoto.user_id' => $this->Session->read('Auth.User.id')),
					'fields' 	 => array('id', 'image'),
					'order'      => array('UserFoto.id DESC'),
					'limit'      => 1
				));
				$this->Session->write('Auth.UserFoto.id', $foto_user['UserFoto']['id']);
				$this->Session->write('Auth.UserFoto.image', $foto_user['UserFoto']['image']);
				
				$this->redirect(array('action'=>'edit'));
			} else {
				$this->Session->setFlash(__('The UserFoto could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserFoto->read(null, $id);
		}
		$users = $this->UserFoto->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UserFoto', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$image = $this->UserFoto->read(null, $id);
		if(empty($image)) {
			return false;
		}
		
		if($this->UserFoto->del($id)) {
			return true;
		}
	}


	function admin_index() {
		$this->UserFoto->recursive = 0;
		$this->set('userFotos', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UserFoto.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('userFoto', $this->UserFoto->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->UserFoto->create();
			if ($this->UserFoto->save($this->data)) {
				$this->Session->setFlash(__('The UserFoto has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserFoto could not be saved. Please, try again.', true));
			}
		}
		$users = $this->UserFoto->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid UserFoto', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserFoto->save($this->data)) {
				$this->Session->setFlash(__('The UserFoto has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The UserFoto could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserFoto->read(null, $id);
		}
		$users = $this->UserFoto->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UserFoto', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserFoto->del($id)) {
			$this->Session->setFlash(__('UserFoto deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>