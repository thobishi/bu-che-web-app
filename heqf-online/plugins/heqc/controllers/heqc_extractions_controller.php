<?php
class HeqcExtractionsController extends HeqcAppController {
	public $uses = array();
	
	protected function _setupAuth() {
		parent::_setupAuth();
		
		$this->Auth->mapAction('extract_data', 'read');
	}
	
	public function index(){
		
	}

	public function extract_data(){
		$this->loadModel('Heqc.HeqcInstitutionApplication');
		try {
			$institution_id = Auth::get('User.heqc_institution_id');
			$this->set('heqcData', $this->HeqcInstitutionApplication->getData($institution_id));
			if($this->RequestHandler->ext == 'xlsx') {
				$this->set('filename', 'HEQC extraction for - ' . Inflector::slug(Auth::get('Institution.hei_name')) . '. Extracted on ' . date('d F Y'));
			}
		}
		catch(Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
	}
}