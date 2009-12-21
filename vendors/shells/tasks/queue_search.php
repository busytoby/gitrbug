<?php

class queueSearchTask extends Shell {
	public $uses = array('Queue.QueuedTask', 'CollectionFile', 'Peer', 'Setting');

	public function run($data) {
		if(!$data['hash']) {
			$this->err("Tried to run search without a hash!?");
			debug($data);
			return true;
		}
		debug($data);
		$my_id = $this->Setting->getPrivateId();
		debug($my_id);

		if($peer = $this->Peer->choosePeer($data)) {
			$this->out(print_r($peer, true));

			if(!array_key_exists('PeerTable', $data)) {
				$data['PeerTable'] = array();

				for($i=0; $i<40; $i++) {
					if(rand(0,3) == 0) {
						$data['PeerTable'][String::UUID()] = String::UUID();
					}
				}
			} elseif(count($data['PeerTable']) > 64) {
				return true; // end of teh road
			}
			$my_id = $this->Setting->getPrivateId();
			$data['PeerTable'][$my_id] = $peer['Peer']['id'];

			App::import('Core', 'HttpSocket');
			$HttpSocket = new HttpSocket();
			$req = array(
				'method' => 'POST',
				'uri' => array(
					'scheme' => 'http',
					'host' => $peer['Peer']['ip'],
					'port' => $peer['Peer']['port'],
					'path' => '/peers/search'
				),
				'header' => array(
					'User-Agent' => 'Gitrbug/0.2'
				),
				'body' => array(
					'data' => json_encode($data)
				)
			);

			$res = $HttpSocket->request($req);
			$r = json_decode($res, true);
			if($r = "success") {
				$this->Peer->read(null, $peer['Peer']['id']);
				$this->Peer->data['Peer']['score'] = $this->Peer->data['Peer']['score'] - 10;
				$this->Peer->save();
				$this->Peer->Tag->updateAll(
					array('Tag.score' => 'Tag.score - 10'),
					array(
						'Tag.name' => am($data['hash'],$data['tags']),
						'Tag.entity_id' => $peer['Peer']['id']
					)
				);
			} elseif($r = "have_file") {
					// start rewinding packet
			}
			$this->out(print_r($res, true));
			return true;
		} else {
			// discard silently
			return true;
		}
	}
}

?>