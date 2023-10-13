<?php
/* Institution Test cases generated on: 2011-02-25 10:54:10 : 1298624050*/
App::import('Model', 'Institution');

class InstitutionTestCase extends CakeTestCase {
	var $fixtures = array('app.institution');

	function startTest() {
		$this->Institution =& ClassRegistry::init('Institution');
	}

	function endTest() {
		unset($this->Institution);
		ClassRegistry::flush();
	}

}
?>