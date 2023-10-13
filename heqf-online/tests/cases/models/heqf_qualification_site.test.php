<?php
/* HeqfQualificationSite Test cases generated on: 2011-02-28 12:58:04 : 1298890684*/
App::import('Model', 'HeqfQualificationSite');

class HeqfQualificationSiteTestCase extends CakeTestCase {
	var $fixtures = array('app.heqf_qualification_site');

	function startTest() {
		$this->HeqfQualificationSite =& ClassRegistry::init('HeqfQualificationSite');
	}

	function endTest() {
		unset($this->HeqfQualificationSite);
		ClassRegistry::flush();
	}

}
?>