<?php
class PeersController extends AppController {

	var $name = 'Peers';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $uses = array('Peer', 'Tag', 'Queue.QueuedTask');

	function index() {
		$this->Peer->recursive = 0;
		$this->set('peers', $this->paginate());
	}

	function hello() {
		$this->layout = false;
		Configure::write('debug', '0');
		$this->set('result', array('data' => $this->data, 'recieved-from' => $this->Session->host));
		$this->render();
	}

	function ts() {
		debug(json_decode('{"data":{"hash":"41ea9fab8a","tags":["test1","test4"]}}', true));
		$this->QueuedTask->createJob('search', array('hash' => '41ea9fab8a', 'tags' => array('test1', 'test4')));
		exit();
	}

	function search() {
		$this->layout = false;
		Configure::write('debug', '0');

		if(empty($this->data)) {
			$this->set('result', "error: Got no data!?");
			$this->render();
		} else {
			$searchData = json_decode($this->data, true);
			if(array_key_exists('hash', $searchData)) {
				// check for hash
				$this->QueuedTask->createJob('search', $searchData);
				$this->set('result', 'success');
				$this->render();
			} else {
				$this->set('result', "error: Where's teh hash!?");
				$this->render();
			}
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Peer.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('peer', $this->Peer->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Peer->create();
			if ($this->Peer->save($this->data)) {
				$this->Session->setFlash(__('The Peer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Peer could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Peer', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Peer->save($this->data)) {
				$this->Session->setFlash(__('The Peer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Peer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Peer->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Peer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Peer->del($id)) {
			$this->Session->setFlash(__('Peer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
