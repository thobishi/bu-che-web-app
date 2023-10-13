<?php
/* Qualification Test cases generated on: 2011-02-11 09:35:28 : 1297409728*/
App::import('Model', 'Qualification');

class QualificationTestCase extends CakeTestCase {
	var $fixtures = array('app.qualification');

	function startTest() {
		$this->Qualification =& ClassRegistry::init('Qualification');
	}

	function endTest() {
		unset($this->Qualification);
		ClassRegistry::flush();
	}

}
?>