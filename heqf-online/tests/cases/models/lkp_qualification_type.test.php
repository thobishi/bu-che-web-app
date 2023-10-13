<?php
/* LkpQualificationType Test cases generated on: 2011-02-16 17:13:38 : 1297869218*/
App::import('Model', 'LkpQualificationType');

class LkpQualificationTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_qualification_type');

	function startTest() {
		$this->LkpQualificationType =& ClassRegistry::init('LkpQualificationType');
	}

	function endTest() {
		unset($this->LkpQualificationType);
		ClassRegistry::flush();
	}

}
?>