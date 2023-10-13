<?php
/* LkpCesm1Code Test cases generated on: 2011-02-16 17:16:30 : 1297869390*/
App::import('Model', 'LkpCesm1Code');

class LkpCesm1CodeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_cesm1_code');

	function startTest() {
		$this->LkpCesm1Code =& ClassRegistry::init('LkpCesm1Code');
	}

	function endTest() {
		unset($this->LkpCesm1Code);
		ClassRegistry::flush();
	}

}
?>