<?php
class User extends AppModel {

	var $name = 'User';
	var $actsAs = array('Containable');
	
	var $validate = array(
		'nome_user' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Por favor, Digite seu nome.'
			),
			'minLength' => array(
				'rule' => array('minLength', 4),
				'message' => 'Digite seu nome completo.'
			)
		),
		'email_user' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Digite um email válido.'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este email já está cadastrado.'
			),
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite seu email.'
			)
		),
		'username' => array(			
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este username já está sendo usado. Por favor escolha outro'
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'O login deve conter apenas letras e números.'
			),
			'between' => array(
		    	'rule' => array('between', 3, 15),
		    	'message' => 'O login deve conter no mínimo 3 e no máximo 15 caracteres.'
		    ),
			'minlength' => array(
				'rule' => array('minLength', '1'),
				'message' => 'Digite seu login.'
			)
		),
		'senha' => array(
			'between' => array(
				'rule' => array('between', 6, 20),
				'message' => 'A senha deve conter no mínimo 6 e no máximo 20 caracteres.'
			),
			'minLength' => array(
				'rule' => array('minLength', 1),
				'message' => 'Digite sua senha.'
			)
		),
		'conf_senha' => array(
			'matchFields' => array(
				'rule' => array('matchFields', 'conf_senha', 'senha'),
				'message' => 'As senhas estão diferentes.'
			),
			'minLength' => array(
				'rule' => array('minLength', 1),
				'message' => 'Confirme sua senha.'
			)
		),
		'ddd' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Digite o DDD corretamente.'
			),
			'minLength' => array(
				'rule' => array('minLength', 2),
				'message' => 'Digite o DDD corretamete.'
			)
		),
		'telefone' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Digite o telefone corretamente.'
			),
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Digite o telefone corretamete.'
			)
		),
		'indicado' => array(
			'validaIndicacao' => array(
				'rule' => array('validaIndicacao', 'indicado'),
				'message' => 'O username ou email de quem te indicou não existe.'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'Endereco' => array(
			'className' => 'Endereco',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserBid' => array(
			'className' => 'UserBid',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserFoto' => array(
			'className' => 'UserFoto',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'HistoryBid' => array(
			'className' => 'HistoryBid',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserAuction' => array(
			'className' => 'UserAuction',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Indicado' => array(
			'className' => 'Indicado',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	/**
	* Esta função compara a igualdade de dois campos
	*
	* @param $data
	* @param $fieldName1
	* @param $fieldName2
	* @retorna true se forem iguais, false caso contrário
	*/
	function matchFields($data, $fieldName1, $fieldName2) {
        $valid = true;
        if((!empty($this->data[$this->name][$fieldName1])) && (!empty($this->data[$this->name][$fieldName2]))) {
			if($this->data[$this->name][$fieldName1] !== $this->data[$this->name][$fieldName2]) {
           		$valid = false;
			}
		}
        return $valid;
	}
	
	/**
	 * Função para checar se quem indicou existe
	 *
	 * @param array $data The users data
	 * @return false se não existir e true caso contrário
	*/
	function validaIndicacao($data){
		if(!empty($data['indicado'])) {
			$user = $this->find('count', array('conditions' => array('or' => array('User.username' => $data['indicado'], 'User.email_user' => $data['indicado']))));
			if($user > 0) {
				return 1 ;
			} else {
				return 0;
			}
		} else {
			return 1;
		}
	}
	
}
?>