<?php
class Estado extends AppModel {

	var $name = 'Estado';
	var $validate = array(
		'uf' => array('notempty'),
		'nome' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'estado_id',
			'dependent' => true,
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