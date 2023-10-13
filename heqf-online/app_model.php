<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {

	public $recursive = -1;

	public $actsAs = array('Containable');

	private $__lookupValidationCache;

	public function __construct($id = false, $model = null, $ds = null) {
		foreach (get_class_methods($this) as $method) {
			if (strpos($method, '_find') !== false) {
				$method = Inflector::variable(str_replace('_find', '', $method));

				$finders[$method] = true;
			}
		}
		$this->_findMethods = $finders + array('all' => true);

		parent::__construct($id, $model, $ds);

		$this->__setupValidation();

		if ($this->Behaviors->attached('AuditLog')) {
			try {
				$this->setUser(Auth::get('id'));
			}
			catch(Exception $e) {
				//Calling Auth::get() too early could cause issues
			}
		}
	}

	private function __setupValidation() {
		$cacheName = $this->name;

		if (!($validation = Cache::read($cacheName, 'validation'))) {
			$validation = $this->validate;

			$validationFields = ClassRegistry::init('Rule')->find('all', array(
				'conditions' => array(
					'Rule.model_name' => $this->name,
					'Rule.active' => true
				)
			));

			if (!empty($validationFields)) {
				foreach ($validationFields as $key => $rule) {
					$ruleKey = $rule['Rule']['type'] == 'required' ? 'required' : 'notrequired';
					$ruleName = (isset($validation[$rule['Rule']['column_name']][$ruleKey])) ? $ruleKey . '_' . $key : $ruleKey;

					$currentRule = array();

					$currentRule['rule'] = $rule['Rule']['rule'];

					if (!$rule['Rule']['custom_function']) {
						$currentRule['allowEmpty'] = ($rule['Rule']['type'] == 'required') ? false : true;
					}

					if (!empty($rule['Rule']['values'])) {
						$values = explode(',', $rule['Rule']['values']);
						$validationRule = array($rule['Rule']['rule']);

						foreach ($values as $value) {
							$validationRule[] = $value;
						}
					} else {
						$validationRule = $rule['Rule']['rule'];
					}

					$currentRule['rule'] = $validationRule;

					$currentRule['message'] = $rule['Rule']['message'];
					$currentRule['private'] = $rule['Rule']['private'];
					$currentRule['public'] = $rule['Rule']['public'];

					if ($rule['Rule']['last']) {
						$currentRule['last'] = true;
					}

					$validation[$rule['Rule']['column_name']][$ruleName] = $currentRule;
				}
			}
			Cache::write($cacheName, $validation, 'validation');
		}
		$this->validate = $validation;

	}

	public function isValidFile($fileDetails) {
		$types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/octet-stream');
		if (
			isset($fileDetails['tmp_name']) &&
			is_uploaded_file($fileDetails['tmp_name']) &&
			$fileDetails['error'] == 0 &&
			in_array($fileDetails['type'], $types )
		) {
			return true;
		}
		return false;
	}

	protected function _getLookupValue($value, $model) {
		if (isset($this->{$model})) {
			if (!isset($this->__lookupValidationCache[$model][$value])) {
				$primaryKey = $model . '.' . $this->{$model}->primaryKey;
				$displayField = $model . '.' . $this->{$model}->displayField;
				$codeField = isset($this->{$model}->codeField) ? ($model . '.' . $this->{$model}->codeField) : '';
				$this->{$model}->virtualFields = array(
					'name' => 'concat(' . $primaryKey . ', " ", ' . $displayField . ')'
				);

				$conditions = array(
					'or' => array(
						'name' => $value,
						$displayField => $value,
						$primaryKey => $value
					)
				);

				if (isset($this->{$model}->codeField)) {
					$conditions['or'][$model . '.' . $this->{$model}->codeField] = $value;
				}

				$match = $this->{$model}->find('first', array(
					'fields' => $primaryKey,
					'conditions' => $conditions
				));
				$this->__lookupValidationCache[$model][$value] = $match;
			} else {
				$match = $this->__lookupValidationCache[$model][$value];
			}

			return $match;
		}
		return null;
	}

	public function lookUpValidation($value, $model) {
		if (isset($this->{$model})) {
			$displayField = $model . '.' . $this->{$model}->displayField;
			$primaryKey = $model . '.' . $this->{$model}->primaryKey;

			$this->{$model}->virtualFields = array(
				'name' => 'concat(' . $primaryKey . ', " ", ' . $displayField . ')'
			);

			$field = end(array_keys($value));
			$value = end($value);
			$match = $this->_getLookupValue($value, $model);

			if (!empty($match)) {
				$this->data[$this->alias][$field] = $match[$model][$this->{$model}->primaryKey];
				return true;
			}

			return false;
		}
	}
	
	public function sendEmail($data) {
		$controller = new Controller();
		$email = new EmailComponent(null);
		$email->initialize($controller);

		$attachments = (isset($data['attachments'])) ? $data['attachments'] : array();		
		if(!empty($attachments)){
			$files = array();
			foreach($attachments as $filename => $filedata){
				$tmpName = '/tmp/' . time() . '-' . rand(0, time());
				file_put_contents($tmpName, $filedata);
				$files[$filename] = $tmpName;
			}
		}		

		$sent = false;
		if (!empty($data)) {
			if (!empty($data['variables'])) {
				$controller->set('variables', $data['variables']);
			}
			$email->smtpOptions = array(
				'port' => '25',
				'timeout' => '30',
				'host' => '127.0.0.1'
			);
			$email->delivery = 'smtp';
			$email->from = $data['from'];
			$email->to = $data['to'];
			//$email->bcc = $data['bcc'];
			$email->subject = $data['subject'];
			$email->template = $data['template'];
			$email->sendAs = $data['sendAs'];
			if(!empty($files)){
				$email->attachments = $files;
			}
			

			$sent = $email->send();
		}
		return $sent;
	}

	public function generateOutcomeNotifyPdf($data){
		// send email
		$return = false;
			
		if(!empty($data)){
			$controller = new Controller();
			App::import('View', 'WkHtmlToPdf.WkHtmlToPdf');
			$PdfView = new WkHtmlToPdfView($controller, false);
			$PdfView->set('variables', $data['variables']);
			$PdfView->setOption(
				'mode', 'string'
			);
			$template = $data['template'];
			$output = $PdfView->render('pdf/' . $template, 'pdf/default');			
			if(!empty($output)) {
				$data['attachments'] = array(
					$template . '.pdf' => $output
				);
			}	
			$return = $this->sendEmail($data);
		}
		
		return $return;
	}
}
