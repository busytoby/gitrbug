<?php 
/* SVN FILE: $Id$ */
/* Tag Test cases generated on: 2009-11-29 01:06:07 : 1259474767*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $Tag = null;
	var $fixtures = array('app.tag', 'app.peer');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function testTagInstance() {
		$this->assertTrue(is_a($this->Tag, 'Tag'));
	}

	function testTagFind() {
		$this->Tag->recursive = -1;
		$results = $this->Tag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Tag' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'entity_id'  => 1,
			'score'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>