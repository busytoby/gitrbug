<?php 
/* SVN FILE: $Id$ */
/* SettingsController Test cases generated on: 2009-09-29 16:56:24 : 1254257784*/
App::import('Controller', 'Settings');

class TestSettings extends SettingsController {
	var $autoRender = false;
}

class SettingsControllerTest extends CakeTestCase {
	var $Settings = null;

	function startTest() {
		$this->Settings = new TestSettings();
		$this->Settings->constructClasses();
	}

	function testSettingsControllerInstance() {
		$this->assertTrue(is_a($this->Settings, 'SettingsController'));
	}

	function endTest() {
		unset($this->Settings);
	}
}
?>