<?php

class CacheController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('clear');
	}

	public function clear() {
		$permission = array(
			'controller' => 'app.Rules',
			'crud' => 'update'
		);

		if ($this->Auth->userPermission($permission)) {
			App::import('Libs', 'ClearCache.ClearCache');
			$ClearCache = new ClearCache();
			$ClearCache->run();
			$this->Session->setFlash('System cache cleared');
		}
		$this->redirect($this->referer());
	}
}