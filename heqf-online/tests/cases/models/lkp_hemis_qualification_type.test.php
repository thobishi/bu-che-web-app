<?php
/* LkpHemisQualificationType Test cases generated on: 2011-02-16 13:01:37 : 1297854097*/
App::import('Model', 'LkpHemisQualificationType');

class LkpHemisQualificationTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_hemis_qualification_type');

	function startTest() {
		$this->LkpHemisQualificationType =& ClassRegistry::init('LkpHemisQualificationType');
	}

	function endTest() {
		unset($this->LkpHemisQualificationType);
		ClassRegistry::flush();
	}

}
?>