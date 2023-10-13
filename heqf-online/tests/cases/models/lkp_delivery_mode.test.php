<?php
/* LkpDeliveryMode Test cases generated on: 2011-02-16 11:31:19 : 1297848679*/
App::import('Model', 'LkpDeliveryMode');

class LkpDeliveryModeTestCase extends CakeTestCase {
	var $fixtures = array('app.lkp_delivery_mode');

	function startTest() {
		$this->LkpDeliveryMode =& ClassRegistry::init('LkpDeliveryMode');
	}

	function endTest() {
		unset($this->LkpDeliveryMode);
		ClassRegistry::flush();
	}

}
?>