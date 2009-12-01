<?php 
/* SVN FILE: $Id$ */
/* ProcessTableEntry Fixture generated on: 2009-11-29 01:01:04 : 1259474464*/

class ProcessTableEntryFixture extends CakeTestFixture {
	var $name = 'ProcessTableEntry';
	var $table = 'process_table_entries';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'length' => 11),
		'action' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'argv' => array('type'=>'binary', 'null' => true, 'default' => 'NULL'),
		'priority' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'text', 'null' => false, 'default' => '\'0\'', 'length' => 32),
		'indexes' => array('0' => array())
	);
	var $records = array(array(
		'id'  => 1,
		'action'  => 'Lorem ipsum dolor sit amet',
		'argv'  => 'Lorem ipsum dolor sit amet',
		'priority'  => 1,
		'created'  => '2009-11-29 01:01:04',
		'modified'  => '2009-11-29 01:01:04',
		'status'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>