<?php 
/* SVN FILE: $Id$ */
/* Setting Test cases generated on: 2009-11-29 01:03:01 : 1259474581*/
App::import('Model', 'Setting');

class SettingTestCase extends CakeTestCase {
	var $Setting = null;
	var $fixtures = array('app.setting');

	function startTest() {
		$this->Setting =& ClassRegistry::init('Setting');
	}

	function testSettingInstance() {
		$this->assertTrue(is_a($this->Setting, 'Setting'));
	}

/*
	function testSettingFind() {
		$this->Setting->recursive = -1;
		$results = $this->Setting->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Setting' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
*/

    function testSettingUpdateMyIP() {
        $this->Setting->updateMyIP();
    }
}
?>
