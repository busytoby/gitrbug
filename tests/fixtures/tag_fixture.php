<?php 
/* SVN FILE: $Id$ */
/* Tag Fixture generated on: 2009-11-29 01:06:06 : 1259474766*/

class TagFixture extends CakeTestFixture {
	var $name = 'Tag';
	var $table = 'tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'length' => 11),
		'name' => array('type'=>'string', 'null' => true, 'default' => 'NULL'),
		'entity_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'score' => array('type'=>'integer', 'null' => false, 'default' => '\'0\'', 'length' => 6),
		'indexes' => array('0' => array())
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'entity_id'  => 1,
		'score'  => 1
	));
}
?>