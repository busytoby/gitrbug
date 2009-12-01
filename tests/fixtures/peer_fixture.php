<?php
/* SVN FILE: $Id$ */
/* Peer Fixture generated on: 2009-11-29 01:04:55 : 1259474695*/

class PeerFixture extends CakeTestFixture {
    var $name = 'Peer';
    var $table = 'peers';
    var $fields = array(
        'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'length' => 11),
        'name' => array('type'=>'string', 'null' => true, 'default' => 'NULL'),
        'ip' => array('type'=>'integer', 'null' => true, 'default' => 'NULL', 'length' => 11),
        'port' => array('type'=>'integer', 'null' => true, 'default' => 'NULL', 'length' => 6),
        'score' => array('type'=>'integer', 'null' => true, 'default' => 'NULL', 'length' => 6),
        'indexes' => array('0' => array())
    );
    var $records = array(
        array(
            'id'  => 1,
            'name'  => 'Peer1',
            'ip'  => '127.0.0.1',
            'port'  => 1337,
            'score'  => 1
        )
    );
}
?>
