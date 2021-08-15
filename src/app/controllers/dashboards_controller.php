<?php
class DashboardsController extends AppController{
	var $name = 'Dashboards';
	var $uses =  array('Auction');
	
	function beforeFilter() {		
		parent::beforeFilter();
		
		$this->Auth->allow('');
	}
	
	function admin_index(){
		$this->layout = 'admin';
	}
}
?>