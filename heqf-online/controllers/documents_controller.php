<?php
class DocumentsController extends AppController {
	public $components = array('Search.Prg');
	public $name = 'Documents';
	protected function _setupAuth(){
		parent::_setupAuth();
		
		$this->Auth->allow('*');
	}
	public $presetVars = array();
	
	public function generate($slug = null, $instID = null, $date = null, $procType = null){
		Configure::write('debug', 0);
		$permission = array(
			'controller' => 'process.document',
			'crud' => 'create'
		);

		if($this->Auth->userPermission($permission)){
			if($slug != null && $instID != null && $date != null){
				try{
					$templateDoc = date('d_F_Y', strtotime($date));
					$file = $templateDoc . '.docx';
					$document = $this->Document->findDocument($slug);
					extract($document, EXTR_PREFIX_ALL, 'document');
					$this->loadModel($document_model);
					
					switch ($slug) {
						case 'proceeding-outcome-notifications-letter':
							$conditions = array(
								'ProcHeqcMeeting.date' => $date,
								'Proceeding.proceeding_type_id' => $procType,
								'Proceeding.proc_status_id' => 'ReviewerComplete',
								'Proceeding.proc_date !=' => '1970-01-01',
								'Application.institution_id' => $instID,
							);
							break;
						
						default:
							$conditions = array(
								'date' => $date,
								'id' => $instID
							);
							break;
					}

					$institutionDetails = $this->{$document_model}->Institution->findById($instID);
					$institutionName = (isset($institutionDetails['Institution']['hei_name'])) ? Inflector::underscore(Inflector::camelize($institutionDetails['Institution']['hei_name'])) : '';
					$document_method = Inflector::variable($document_method);
					if(!method_exists($this->{$document_model}, $document_method)) {
						throw new Exception(__('There was a problem generating the requested document.', true));
					}
					
					$this->loadModel('User');
					$instAdm = $this->User->find('all', array(
							'conditions' => array(
								'User.institution_id' => $instID,
							),
							'contain' => array('Role')
						)
					);

					$adminID = end(Set::extract('/Role[inst_admin=1]/RolesUser/user_id', $instAdm));
					$admin = $this->User->findById($adminID);
					$adminName = $admin['User']['name'];					
					debug($file);
					if(!file_exists(WWW_ROOT . 'templates/' . $file)) {
						// throw new Exception(__('The file: ' . $file . ' does not exist.', true));
						$file = $document_element . ".docx";
						
					}

					$docData = $this->{$document_model}->{$document_method}($conditions);

					$this->set(compact('document', 'docData', 'file', 'institutionName', 'adminName'));
					$this->render('document');
				}
				catch(Exception $e) {
					$this->Session->setFlash($e->getMessage());
				}
			}
			else{
				$this->Session->setFlash('There was a problem generating the requested document.');
			}
		}
		else{
			$this->Session->setFlash('You do not have permission to access this page/document.');
		}
	}
}