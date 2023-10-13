<?php
/* S1QualificationSite Test cases generated on: 2011-02-28 12:58:15 : 1298890695*/
App::import('Model', 'S1QualificationSite');

class S1QualificationSiteTestCase extends CakeTestCase {
	var $fixtures = array('app.s1_qualification_site');

	function startTest() {
		$this->S1QualificationSite =& ClassRegistry::init('S1QualificationSite');
	}

	function endTest() {
		unset($this->S1QualificationSite);
		ClassRegistry::flush();
	}

}
?>