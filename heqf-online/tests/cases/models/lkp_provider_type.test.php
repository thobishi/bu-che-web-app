<?php
/* LkpProviderType Test cases generated on: 2011-02-16 11:10:09 : 1297847409*/
App::import('Model', 'LkpProviderType');

class LkpProviderTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_provider_type');

	function startTest() {
		$this->LkpProviderType =& ClassRegistry::init('LkpProviderType');
	}

	function endTest() {
		unset($this->LkpProviderType);
		ClassRegistry::flush();
	}

}
?>