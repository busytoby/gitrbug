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

	function testRequestFile() {
		$data = array(
			'hash' => 'f93b1cc0dd5b5a634ace4c662190a566',
			'segments' => array(
				array(0,117)
			),
			'send_file' => true
		);

		$result = $this->testAction('/peers/request_file', array(
					  'data' => json_encode($data),
					  'method' => 'post'
				  ));

		Configure::write('debug', 1);

		debug($result);
	}

}
?>
