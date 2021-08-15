<?php
class Endereco extends AppModel {

	var $name = 'Endereco';
	var $actsAs = array('Validacao');
	
	var $validate = array(
		'cidades' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Por favor, selecione sua cidade!'
			)
		),
		'cpf' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Por favor, digite apenas números!'
			),
			'cpf' => array(
				'rule' => array('cpf', true),
				'message' => 'Digite um CPF válido!'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este CPF já está cadastrado!'
			)
		),
		'endereco' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite seu endereço!'
			)
		),
		'numero' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite o número!'
			)
		),
		'bairro' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite seu bairro!'
			)
		),
		'cep' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Digite apenas números para o CEP!'		
			),
			'cep' => array(
				'rule' => array('cep'),
				'message' => 'Digite um CEP válido!'
			),
			
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Digite seu CEP corretamente'
			)
		)	
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'cidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>