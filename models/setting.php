<?php
class Setting extends AppModel {

	var $name = 'Setting';

	function getPrivateId() {
		Configure::load('gitrbug');
		$id_n = Configure::read('gitrbug.num_secrets');
		Configure::load('gitrbug_secrets');
		$id_s = Configure::read('gitrbug_s.secrets');

		$id_a = unserialize(stripslashes($id_s));

		if(count($id_a) < $id_n) {
			App::Import('Model', 'Peer');
			$peerModel =& ClassRegistry::init('Peer');
			while(count($id_a) < $id_n) {
				$id_a[] = $peerModel->_genUUID();
			}
			Configure::write('gitrbug_s.secrets', serialize($id_a));
			Configure::store('gitrbug', 'gitrbug_secrets', Configure::read('gitrbug_s'));
		}

		$id_x = rand(0,$id_n - 1);

		return $id_a[$id_x];
	}

	function readIP() {
		$addr = $this->findByName('ip_addr', array('fields' => 'value'));
		if(!empty($addr)) {
			return $addr['Setting']['value'];
		} else {
			return $this->updateMyIP();
		}
	}

	function updateMyIP() {
		$addr = $this->findByName('ip_addr', array('fields' => 'value'));

		App::import('Core', 'HttpSocket');
		$HttpSocket = new HttpSocket();
		$res = $HttpSocket->request(
			array(
				'method' => 'GET',
				'uri' => array(
					'scheme' => 'http',
					'host' => 'ipinfodb.com',
					'path' => '/ip_query.php',
					'query' => 'output=json'
				),
				'header' => array(
					'User-Agent' => 'Gitrbug/0.2'
				),
			)
		);

		$r = json_decode($res, true);

		if(empty($addr)) {
			$this->create();
			$this->save(array('name' => 'ip_addr', 'value' => $r['Ip']));
		} else {
			$this->updateAll(array('value' => $r['Ip']), array('name' => 'ip_addr'));
		}

		return($r['Ip']);
	}
}
?>