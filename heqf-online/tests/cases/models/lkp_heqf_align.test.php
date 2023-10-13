<?php
/* LkpHeqfAlign Test cases generated on: 2011-02-16 12:22:08 : 1297851728*/
App::import('Model', 'LkpHeqfAlign');

class LkpHeqfAlignTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_heqf_align');

	function startTest() {
		$this->LkpHeqfAlign =& ClassRegistry::init('LkpHeqfAlign');
	}

	function endTest() {
		unset($this->LkpHeqfAlign);
		ClassRegistry::flush();
	}

}
?>