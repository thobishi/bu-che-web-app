<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::import('Core', 'Sanitize');
class AppController extends Controller {

	public $components = array(
		'DebugKit.Toolbar',
		'Session',
		'RequestHandler',
		'Webservice.Webservice',
		'OctoUsers.Auth',
		'Email'
		//'Security'
	);

	public $helpers = array(
		'Html',
		'Form',
		'Heqf',
		'Session',
		'Status',
		'Report'
	);

	protected $_mimeTypes = array(
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_setupAuth();

		if ($this->RequestHandler->ext == 'pdf') {
			$this->RequestHandler->renderAs($this, 'pdf');
			$this->view = 'WkHtmlToPdf.WkHtmlToPdf';
		} elseif ($this->RequestHandler->ext == 'xlsx') {
			$this->RequestHandler->renderAs($this, 'xls');
			$this->view = 'CustomViews.Excel';
		} elseif ($this->RequestHandler->ext == 'docx') {
			$this->RequestHandler->renderAs($this, 'docx');
			$this->view = 'DocumentGenerator.Docx';
		}

		$this->params['referer'] = $this->referer();
	}

	protected function _setupAuth() {
		$this->Auth->allow('sql_explain');
	}

	protected function _triggerError($e) {
		if ($this->RequestHandler->isAjax()) {
			$this->set('error', true);
			$this->set('message', $e->getMessage());
			$this->params['url']['ext'] = 'json';
			$this->view = 'Webservice.Webservice';
		} else {
			$this->Session->setFlash($e->getMessage(), 'default', array(), 'error');
			$this->redirect('/');
		}
	}
}
