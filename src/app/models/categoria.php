<?php
class Categoria extends AppModel {

	var $name = 'Categoria';
	var $validate = array(
		'titulo_categoria' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite a categoria!'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Produto' => array(
			'className' => 'Produto',
			'foreignKey' => 'categoria_id',
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