<?php
/* LkpCesm3Code Test cases generated on: 2011-02-16 17:53:41 : 1297871621*/
App::import('Model', 'LkpCesm3Code');

class LkpCesm3CodeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_cesm3_code');

	function startTest() {
		$this->LkpCesm3Code =& ClassRegistry::init('LkpCesm3Code');
	}

	function endTest() {
		unset($this->LkpCesm3Code);
		ClassRegistry::flush();
	}

}
?>