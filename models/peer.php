<?php
class Peer extends AppModel {

	var $name = 'Peer';

	var $hasMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'entity_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	function beforeSave(&$model, $options = array()) {
        if (empty($this->id)) { // only generate id on create
			$this->data['Peer']['id'] = $this->_genUUID();
		}
		return true;
	}

	function greet($peer_address = null, $peer_port = null, $data = array()) {
		if(!$peer_address || !$peer_port) {
			return true;
		}

		App::import('Core', 'HttpSocket');
		$HttpSocket = new HttpSocket();
		$req = array(
			'method' => 'POST',
			'uri' => array(
				'scheme' => 'http',
				'host' => $peer_address,
				'port' => $peer_port,
				'path' => '/peers/hello'
			),
			'header' => array(
				'User-Agent' => 'Gitrbug/0.2'
			),
			'body' => array(
				'data' => $data
			)
		);

		$res = $HttpSocket->request($req);
		return(json_decode($res, true));
	}

	function _genUUID() {
		mt_srand( intval( microtime( true ) * 1000 ) );
		$b = md5( uniqid( mt_rand(), true ), true );
		$b[6] = chr( ( ord( $b[6] ) & 0x0F ) | 0x40 );
		$b[8] = chr( ( ord( $b[8] ) & 0x3F ) | 0x80 );
		return implode( '-', unpack( 'H8a/H4b/H4c/H4d/H12e', $b ) );
	}

	function choosePeer($data) {
		$peerFields = array('Peer.id', 'Peer.name', 'Peer.ip', 'Peer.port');

		$peer = $this->Tag->find('first', array(
					'fields' => $peerFields,
					'conditions' => array('Tag.name' => $data['hash'], 'Tag.score >' => '0'),
					'group' => 'Peer.id',
					'order' => '(abs(RANDOM() / 36028797018963968 * SUM(Tag.score))) DESC'
				));
		if(empty($peer)) {
			$peer = $this->Tag->find('first', array(
						'fields' => $peerFields,
						'conditions' => array('Tag.name' => $data['tags'], 'Tag.score >' => '0'),
						'group' => 'Peer.id',
						'order' => '(abs(RANDOM() / 36028797018963968 * SUM(Tag.score))) DESC',
					));
		}
		if(empty($peer)) {
			$peer = $this->find('first', array(
						'fields' => $peerFields,
						'conditions' => array('score > 0'),
						'order' => '(abs(RANDOM() / 36028797018963968 * Peer.score)) DESC',
						'recursive' => 0,
					));
		}
		return $peer;
	}
}
?>