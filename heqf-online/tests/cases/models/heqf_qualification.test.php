<?php
/* HeqfQualification Test cases generated on: 2011-02-11 08:56:49 : 1297407409*/
App::import('Model', 'HeqfQualification');

class HeqfQualificationTestCase extends CakeTestCase {
	var $fixtures = array('app.heqf_qualification');

	function startTest() {
		$this->HeqfQualification =& ClassRegistry::init('HeqfQualification');
	}

	function endTest() {
		unset($this->HeqfQualification);
		ClassRegistry::flush();
	}

}
?>