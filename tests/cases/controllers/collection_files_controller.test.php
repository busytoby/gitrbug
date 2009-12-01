<?php 
/* SVN FILE: $Id$ */
/* CollectionFilesController Test cases generated on: 2009-11-29 14:48:35 : 1259524115*/
App::import('Controller', 'CollectionFiles');

class TestCollectionFiles extends CollectionFilesController {
	var $autoRender = false;
}

class CollectionFilesControllerTest extends CakeTestCase {
	var $CollectionFiles = null;

	function startTest() {
		$this->CollectionFiles = new TestCollectionFiles();
		$this->CollectionFiles->constructClasses();
	}

	function testCollectionFilesControllerInstance() {
		$this->assertTrue(is_a($this->CollectionFiles, 'CollectionFilesController'));
	}

	function endTest() {
		unset($this->CollectionFiles);
	}
}
?>