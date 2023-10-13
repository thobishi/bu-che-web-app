<?php
/* LkpDesignator Test cases generated on: 2011-02-16 17:01:47 : 1297868507*/
App::import('Model', 'LkpDesignator');

class LkpDesignatorTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_designator');

	function startTest() {
		$this->LkpDesignator =& ClassRegistry::init('LkpDesignator');
	}

	function endTest() {
		unset($this->LkpDesignator);
		ClassRegistry::flush();
	}

}
?>