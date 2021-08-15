<?php
class Produto extends AppModel {

	var $name = 'Produto';
	var $validate = array(
		'titulo_produto' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite o título do produto!'
			)
		),
		'valor_mercado' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'digite o valor de mercado do produto!'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Categoria' => array(
			'className' => 'Categoria',
			'foreignKey' => 'categoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Auction' => array(
			'className' => 'Auction',
			'foreignKey' => 'produto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ProdutoImage' => array(
			'className' => 'ProdutoImage',
			'foreignKey' => 'produto_id',
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

}
?>