<?php
class MailsController extends AppController {

	var $name = 'Mails';

	public $components = array(
		'Email'
	);
	
	public function sendEmail($data){
	
		$controller = & new Controller();
		$email = & new EmailComponent(null);
		$email->initialize($controller);
		
		$sent = false;
		if(!empty($data)){
			$email->smtpOptions = array(
				'port' => '25',
				'timeout' => '30',
				'host' => '127.0.0.1'
			);
			$email->delivery = 'smtp';
			$email->from = $data['from'];
			$email->to = $data['to'];
			$email->subject = $data['subject'];
			$email->template = $data['template'];
			$email->sendAs = $data['sendAs'];
			if(!empty($data['variables'])){
				foreach($data['variables'] as $key => $value){
					$this->set("{$key}", $value);
				}
				$this->set('hello', 'This is hello');
			}
			$sent = $email->send();
		}
		return $sent;
	}
}