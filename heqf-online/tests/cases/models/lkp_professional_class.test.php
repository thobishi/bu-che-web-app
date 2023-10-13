<?php
/* LkpProfessionalClass Test cases generated on: 2011-02-16 17:21:00 : 1297869660*/
App::import('Model', 'LkpProfessionalClass');

class LkpProfessionalClassTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_professional_class');

	function startTest() {
		$this->LkpProfessionalClass =& ClassRegistry::init('LkpProfessionalClass');
	}

	function endTest() {
		unset($this->LkpProfessionalClass);
		ClassRegistry::flush();
	}

}
?>