<?php
App::import('Core', 'Controller');
App::import('Component', 'Email');
/**
 * Task permitting to use the Email component from a shell
 * @see http://bakery.cakephp.org/articles/view/emailcomponent-in-a-cake-shell
 */
class EmailTask extends Shell {
/**
 * Controller class
 * @var Controller
 */
	public $Controller;
 
/**
 * EmailComponent
 * @var EmailComponent
 */
	public $Email;
 
/**
 * List of default variables for EmailComponent
 * @var array
 */
	public $defaults = array(
		'to' => null,
		'subject' => null,
		'charset' => 'UTF-8',
		'from' => null,
		'sendAs' => 'html',
		'template' => null,
		'debug' => false,
		'additionalParams' => '',
		'layout' => 'default');
 
/**
 * Startup for the EmailTask
 * 	- Initializes the component
 *
 * @return void
 */
	public function initialize() {
		$this->Controller = new Controller();
		$this->Email = new EmailComponent(null);
		$this->Email->initialize($this->Controller);
	}
 
/**
 * Sends an email using the EmailComponent
 *
 * @param array $settings
 * @return boolean
 */
	public function send($settings = array()) {
		$this->settings($settings);
		return $this->Email->send();
	}
 
/**
 * Used to set view vars to the Controller so
 * that they will be available when the view render
 * the template
 *
 * @param string $name
 * @param mixed $data
 */
	public function set($name, $data) {
		$this->Controller->set($name, $data);
	}
 
/**
 * Change default variables
 * Fancy if you want to send many emails and only want
 * to change 'from' or few keys
 *
 * @param array $settings
 * @return void
 */
	function settings($settings = array()) {
		$this->Email->_set($this->defaults = array_filter(am($this->defaults, $settings)));
	}
}
?>