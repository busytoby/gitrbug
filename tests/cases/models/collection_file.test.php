<?php
/* SVN FILE: $Id$ */
/* CollectionFile Test cases generated on: 2009-11-29 14:36:30 : 1259523390*/
App::import('Model', 'CollectionFile');

class CollectionFileTestCase extends CakeTestCase {
	var $CollectionFile = null;
	var $fixtures = array('app.collection_file', 'app.plugin');

	function startTest() {
		$this->CollectionFile =& ClassRegistry::init('CollectionFile');
	}

	function testCollectionFileInstance() {
		$this->assertTrue(is_a($this->CollectionFile, 'CollectionFile'));
	}

	function testCollectionFileFind() {
		$this->CollectionFile->recursive = -1;
		$results = $this->CollectionFile->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CollectionFile' => array(
			'id'  => 1,
			'path'	=> 'Lorem ipsum dolor sit amet',
			'hash'	=> 'Lorem ipsum dolor sit amet',
			'plugin_id'	 => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>