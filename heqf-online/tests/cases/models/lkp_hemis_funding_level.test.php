<?php
/* LkpHemisFundingLevel Test cases generated on: 2011-02-16 13:25:10 : 1297855510*/
App::import('Model', 'LkpHemisFundingLevel');

class LkpHemisFundingLevelTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_hemis_funding_level');

	function startTest() {
		$this->LkpHemisFundingLevel =& ClassRegistry::init('LkpHemisFundingLevel');
	}

	function endTest() {
		unset($this->LkpHemisFundingLevel);
		ClassRegistry::flush();
	}

}
?>