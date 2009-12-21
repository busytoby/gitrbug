<?php
class Setting extends AppModel {

	var $name = 'Setting';

	function getPrivateId() {
		Configure::load('gitrbug');
		$id_s = Configure::read('gitrbug.secrets');

		debug($id_s);

		if(empty($id_s)) $id_s = array('Setting' => array('value' => ''));

		$id_a = unserialize($id_s['Setting']['value']);

		debug($id_a);

		if(count($id_a) < 10) {
			App::Import('Model', 'Peer');
			$peerModel =& ClassRegistry::init('Peer');
			while(count($id_a) < 10) {
				$id_a[] = $peerModel->_genUUID();
			}
			$this->
		}
		return $id;
	}
}
?>