<?php
class CidadesController extends appController{
	
	var $name = 'Cidades';
	var $uses =  array('Estado', 'Cidade', 'User');
	
	function beforeFilter(){
		parent::beforeFilter();
		
		$this->Auth->allow('*');
	}
	
	/**
	 * Função responsável por listar as cidades de um 
	 * determinado estado.
	 * 
	 * @return void 
	 */
	function cidades(){
		Configure::write('debug', 0);
		$this->layout = 'js/ajax';
		$this->Cidade->contain();
		$cidades = $this->Cidade->find('all', array(
			'conditions' => array(
				'Cidade.estado_id' => $this->data['Endereco']['estados']
			),
			'fields' => array(
				'Cidade.id',
				'Cidade.cidade'
			)
		));	
		$this->set('cidades', $cidades);
	}
		
}
?>