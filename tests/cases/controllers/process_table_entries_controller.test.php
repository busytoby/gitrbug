<?php 
/* SVN FILE: $Id$ */
/* ProcessTableEntriesController Test cases generated on: 2009-09-29 16:56:16 : 1254257776*/
App::import('Controller', 'ProcessTableEntries');

class TestProcessTableEntries extends ProcessTableEntriesController {
	var $autoRender = false;
}

class ProcessTableEntriesControllerTest extends CakeTestCase {
	var $ProcessTableEntries = null;

	function startTest() {
		$this->ProcessTableEntries = new TestProcessTableEntries();
		$this->ProcessTableEntries->constructClasses();
	}

	function testProcessTableEntriesControllerInstance() {
		$this->assertTrue(is_a($this->ProcessTableEntries, 'ProcessTableEntriesController'));
	}

	function endTest() {
		unset($this->ProcessTableEntries);
	}
}
?>