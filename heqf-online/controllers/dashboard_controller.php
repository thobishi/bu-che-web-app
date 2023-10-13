<?php

class DashboardController extends AppController {
	public $uses = array();
	
	protected function _setupAuth() {
		parent::_setupAuth();
		
		$this->Auth->allow('index');
	}
	
	public function index() {
	}
}