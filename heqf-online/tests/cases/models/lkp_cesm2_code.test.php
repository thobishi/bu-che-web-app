<?php
/* LkpCesm2Code Test cases generated on: 2011-02-16 17:39:34 : 1297870774*/
App::import('Model', 'LkpCesm2Code');

class LkpCesm2CodeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_cesm2_code');

	function startTest() {
		$this->LkpCesm2Code =& ClassRegistry::init('LkpCesm2Code');
	}

	function endTest() {
		unset($this->LkpCesm2Code);
		ClassRegistry::flush();
	}

}
?>