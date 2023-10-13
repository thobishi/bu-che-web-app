<?php
/* LkpHemisQualifier Test cases generated on: 2011-02-16 12:57:09 : 1297853829*/
App::import('Model', 'LkpHemisQualifier');

class LkpHemisQualifierTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_hemis_qualifier');

	function startTest() {
		$this->LkpHemisQualifier =& ClassRegistry::init('LkpHemisQualifier');
	}

	function endTest() {
		unset($this->LkpHemisQualifier);
		ClassRegistry::flush();
	}

}
?>