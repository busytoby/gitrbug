<?php 
/* SVN FILE: $Id$ */
/* PeersController Test cases generated on: 2009-09-29 16:56:06 : 1254257766*/
App::import('Controller', 'Peers');

class TestPeers extends PeersController {
	var $autoRender = false;
}

class PeersControllerTest extends CakeTestCase {
	var $Peers = null;

	function startTest() {
		$this->Peers = new TestPeers();
		$this->Peers->constructClasses();
	}

	function testPeersControllerInstance() {
		$this->assertTrue(is_a($this->Peers, 'PeersController'));
	}

	function endTest() {
		unset($this->Peers);
	}
}
?>