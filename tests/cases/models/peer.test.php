<?php
/* SVN FILE: $Id$ */
/* Peer Test cases generated on: 2009-11-29 01:04:56 : 1259474696*/
App::import('Model', 'Peer');

class PeerTestCase extends CakeTestCase {
	var $Peer = null;
	var $fixtures = array('app.peer', 'app.tag');

	function startTest() {
		$this->Peer =& ClassRegistry::init('Peer');
	}

	function testPeerInstance() {
		$this->assertTrue(is_a($this->Peer, 'Peer'));
	}

	function testPeerFind() {
		$this->Peer->recursive = -1;
		$results = $this->Peer->find('first');
		$this->assertTrue(!empty($results));

		$expected = array(
			'Peer' => array(
				'id'  => 1,
				'name'	=> 'Peer1',
				'ip'  => '127.0.0.1',
				'port'	=> 1337,
				'score'	 => 1
			)
		);
		$this->assertEqual($results, $expected);
	}

	function testPeerGreet() {
		$peerMesh = array();
		$genericPeer = array(
			'Peer' => array(
				'id' => 1,
				'name' => '',
				'ip' => '127.0.0.1',
				'port' => 1337,
				'score' => 1
			)
		);
		debug(count($this->Peer->find('all')));

		$gData = $this->Peer->greet('127.0.0.1', '1337', array('to' => 'Peer12'));
		$this->assertEqual($gData, array('data' => array('to' => 'Peer12'), 'recieved-from' => '127.0.0.1'));
	}
}
?>