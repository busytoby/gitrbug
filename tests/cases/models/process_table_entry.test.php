<?php 
/* SVN FILE: $Id$ */
/* ProcessTableEntry Test cases generated on: 2009-11-29 01:01:04 : 1259474464*/
App::import('Model', 'ProcessTableEntry');

class ProcessTableEntryTestCase extends CakeTestCase {
	var $ProcessTableEntry = null;
	var $fixtures = array('app.process_table_entry');

	function startTest() {
		$this->ProcessTableEntry =& ClassRegistry::init('ProcessTableEntry');
	}

	function testProcessTableEntryInstance() {
		$this->assertTrue(is_a($this->ProcessTableEntry, 'ProcessTableEntry'));
	}

	function testProcessTableEntryFind() {
		$this->ProcessTableEntry->recursive = -1;
		$results = $this->ProcessTableEntry->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ProcessTableEntry' => array(
			'id'  => 1,
			'action'  => 'Lorem ipsum dolor sit amet',
			'argv'  => 'Lorem ipsum dolor sit amet',
			'priority'  => 1,
			'created'  => '2009-11-29 01:01:04',
			'modified'  => '2009-11-29 01:01:04',
			'status'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>