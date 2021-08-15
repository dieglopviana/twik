<?php
class Arrematado extends AppModel {

	var $name = 'Arrematado';
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'HistoryBid' => array(
			'className' => 'HistoryBid',
			'foreignKey' => 'history_bid_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>