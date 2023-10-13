<?php
/*
* Pagination Recall CakePHP Component
* Copyright (c) 2008 Matt Curry
* www.PseudoCoder.com
*
* @author mattc <matt@pseudocoder.com>
* @version 1.0
* @license MIT
*
*/

class PaginationRecallComponent extends Object {

	public $components = array('Session');

	private $__Controller = null;

	private $__options = array(
		'vars' => array('page', 'sort', 'direction', 'limit')
	);

	public function initialize(&$controller, $settings = array()) {
		$this->__Controller = & $controller;

		$this->__options = Set::merge($this->__options, $settings);
	}

	public function recallParams($redirect = false) {
		//recall previous options
		if ($this->Session->check("Pagination.{$this->__Controller->modelClass}.options")) {
			$options = $this->Session->read("Pagination.{$this->__Controller->modelClass}.options");

			$this->__Controller->passedArgs = array_merge($this->__Controller->passedArgs, $options);

			if ($redirect == true) {
				$this->Session->delete("Pagination.{$this->__Controller->modelClass}.options");
				$this->__Controller->redirect($url, $this->__Controller->passedArgs);
			}
		}
	}

	public function saveParams() {
		extract($this->__options);

		$options = array_merge($this->__Controller->params,
			$this->__Controller->params['url'],
			$this->__Controller->passedArgs
		);

		$keys = array_keys($options);
		$count = count($keys);

		for ($i = 0; $i < $count; $i++) {
			if (!in_array($keys[$i], $vars) || is_numeric($keys[$i])) {
				unset($options[$keys[$i]]);
			}
		}

		//save the options into the session
		$this->Session->write("Pagination.{$this->__Controller->modelClass}.options", $options);
	}

	public function save() {
		$refererSession = "Pagination.{$this->__Controller->modelClass}.referer";
		if ($this->Session->check($refererSession)) {
			return;
		}

		$referer = $this->__Controller->referer();
		if ($referer == Router::url(array('base' => false))) {
			return;
		}
		$this->Session->write($refererSession, $referer);
	}

	public function recall() {
		$refererSession = "Pagination.{$this->__Controller->modelClass}.referer";
		if (!$this->Session->check($refererSession)) {
			return null;
		}

		$redirect = $this->Session->read($refererSession);
		$this->Session->delete("Pagination.{$this->__Controller->modelClass}.referer");
		return $redirect;
	}

	public function redirect($default = '/') {
		$redirect = $this->recall();
		if ($redirect == null) {
			$redirect = $default;
		}

		if ($redirect !== Router::url(array('base' => false))) {
			$this->__Controller->redirect($redirect);
		}
	}

}