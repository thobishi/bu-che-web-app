<?php
/* LkpNqfLevel Test cases generated on: 2011-02-16 11:33:13 : 1297848793*/
App::import('Model', 'LkpNqfLevel');

class LkpNqfLevelTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_nqf_level');

	function startTest() {
		$this->LkpNqfLevel =& ClassRegistry::init('LkpNqfLevel');
	}

	function endTest() {
		unset($this->LkpNqfLevel);
		ClassRegistry::flush();
	}

}
?>