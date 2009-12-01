<?php
/* SVN FILE: $Id$ */
/* Gitrbug schema generated on: 2009-11-18 14:11:05 : 1258574045 */
class GitrbugSchema extends CakeSchema {
	var $name = 'Gitrbug';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $collection_files = array(
		'id' => array(		  'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'path' => array(	  'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2048),
		'hash' => array(	  'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'plugin_id' => array( 'type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'hash' => array('column' => 'hash', 'unique' => 1)
		)
	);
	var $tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
		'entity_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'score' => array('type' => 'integer', 'null' => false, 'default' => 0, 'length' => 6),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'entity_id' => array('column' => 'entity_id', 'unique' => 0)
		)
	);
	var $peers = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'primary', 'length' => 36),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
		'ip' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 11),
		'port' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'score' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 6),
        'last_seen' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		)
	);
	var $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 2048),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		)
	);
}
?>
