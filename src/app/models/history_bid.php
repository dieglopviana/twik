<?php
class HistoryBid extends AppModel {

	var $name = 'HistoryBid';
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Arrematado' => array(
			'className' => 'Arrematado',
			'foreignKey' => 'history_bid_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Auction' => array(
			'className' => 'Auction',
			'foreignKey' => 'auction_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>