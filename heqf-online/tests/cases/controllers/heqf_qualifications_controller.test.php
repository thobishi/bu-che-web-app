<?php
/* HeqfQualifications Test cases generated on: 2011-02-14 14:33:31 : 1297686811*/
App::import('Controller', 'HeqfQualifications');

class TestHeqfQualificationsController extends HeqfQualificationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HeqfQualificationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.heqf_qualification');

	function startTest() {
		$this->HeqfQualifications =& new TestHeqfQualificationsController();
		$this->HeqfQualifications->constructClasses();
	}

	function endTest() {
		unset($this->HeqfQualifications);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>