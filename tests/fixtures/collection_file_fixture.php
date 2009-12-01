<?php 
/* SVN FILE: $Id$ */
/* CollectionFile Fixture generated on: 2009-11-29 14:36:27 : 1259523387*/

class CollectionFileFixture extends CakeTestFixture {
	var $name = 'CollectionFile';
	var $table = 'collection_files';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'length' => 11),
		'path' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 2048),
		'hash' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'plugin_id' => array('type'=>'integer', 'null' => true, 'default' => 'NULL'),
		'indexes' => array('0' => array())
	);
	var $records = array(array(
		'id'  => 1,
		'path'  => 'Lorem ipsum dolor sit amet',
		'hash'  => 'Lorem ipsum dolor sit amet',
		'plugin_id'  => 1
	));
}
?>