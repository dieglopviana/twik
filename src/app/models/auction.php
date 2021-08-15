<?php
class Auction extends AppModel {

	var $name = 'Auction';
	var $actsAs = array('Containable');
	
	var $validate = array(
		'produto_id' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		),
		'tempo_cronometro' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		),
		'valor_inicial' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		),
		'valor_lance' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		),
		'busca' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		),
		'status_cronometro' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		),
		'status_auction' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Este campo não pode ficar em branco!'
			)
		));

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Produto' => array(
			'className' => 'Produto',
			'foreignKey' => 'produto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'HistoryBid' => array(
			'className' => 'HistoryBid',
			'foreignKey' => 'auction_id',
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