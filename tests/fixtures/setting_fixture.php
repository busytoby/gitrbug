<?php 
/* SVN FILE: $Id$ */
/* Setting Fixture generated on: 2009-11-29 01:03:00 : 1259474580*/

class SettingFixture extends CakeTestFixture {
	var $name = 'Setting';
	var $table = 'settings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'length' => 11),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 32),
		'value' => array('type'=>'string', 'null' => true, 'default' => 'NULL', 'length' => 2048),
		'indexes' => array('0' => array())
	);
    var $import = 'Setting';
}
?>
