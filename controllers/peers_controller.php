<?php
class PeersController extends AppController {

	var $name = 'Peers';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $uses = array('Peer', 'Tag', 'CollectionFile' , 'Queue.QueuedTask');

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

	function request_file() {
		$this->layout = false;
		Configure::write('debug', '0');
		$reqData = json_decode($this->data, true);

		if(empty($reqData) || empty($reqData['hash'])) {
			$this->set('result', "error: What do you want!?");
			$this->render();
			return;
		}

		$file = $this->CollectionFile->find('first', array(
					'conditions' => array('hash' => $reqData['hash']),
					'fields' => array('path', 'hash'),
					'recursive' => -1
				)
		);

		$flen = $this->CollectionFile->countFileSegments($file);

		if($file) {
			$segments = $reqData['segments'];

			$seq = rand(0, count($segments)) - 1;

			$dir = 1;

			if(count($segments) > 1) {
				if($segments[$seq][0] > 0) {
					$dir = rand(0,1);
				}
				if($segments[$seq][1] >= $flen) {
					$dir = 0;
				}

				switch($dir) {
					case 0:
						$min = $segments[$seq - 1][1] + 1;
						$max = $segments[$seq][0] - 1;
						break;
					case 1:
						$min = $segments[$seq][1] + 1;
						$max = $segments[$seq + 1][0] - 1;
						break;
				}
			} elseif(count($segments) == 1) {
				$dir = 1;
				if($segments[0][0] > 0) $dir = rand(0,1);
				if($segments[0][1] >= $flen - 1) $dir = 0;

				switch($dir) {
					case 0:
						$min = 0;
						$max = $segments[0][0] - 1;
						break;
					case 1:
						$min = $segments[0][1] + 1;
						$max = $flen - 1;
						break;
				}
			} else {
				$min = 0;
				$max = $flen - 1;
			}

			if($max < 0) {
				$file['Error'] = array('code' => -1, 'text' => 'Nothing to send');
			} else {
				$chunk = rand($min, $max);
				$chunk_start = $chunk * 65536;
				if(array_key_exists('send', $reqData) && $reqData['send'] == true) {
					$file['CollectionFile']['Sample']['offset'] = $chunk_start;
//					$job = $this->QueuedTask->createJob('upload', array($file), '+5 Minutes');

//					while($this->QueuedTask->getLength('upload') > 6) {
//						sleep(1); // get a better number later
//					}

					$file['CollectionFile']['Sample']['data'] = $this->CollectionFile->getSample($file, $chunk_start);
				} else {
					$file['CollectionFile']['Sample']['md5'] = $this->CollectionFile->md5($file, $chunk);
				}
			}
		}

//		$this->QueuedTask->markJobDone($job['QueuedTask']['id']);
		unset($file['CollectionFile']['path']);
		$this->set('result', $file);
		$this->render();
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
				$file = $this->CollectionFile->find('first', array(
							'conditions' => array('hash' => $searchData['hash']),
							'fields' => array('path', 'hash'),
							'recursive' => -1
						)
				);

				if($file) {
					$this->set('result', 'have_file');
				} else {
					$this->QueuedTask->createJob('search', $searchData);
					$this->set('result', 'success');
				}
				$this->render();
			} else {
				$this->set('result', "error: Where's teh hash!?");
				$this->render();
			}
		}
	}

	function cmd() {
		$this->layout = null;
		Configure::write('debug', 0);
		$argv = explode(' ', $this->data);
		$cmd = array_shift($argv);
		if(method_exists($this, "__cmd_{$cmd}")) {
			$function = '__cmd_' . $cmd;
			echo json_encode($this->$function($argv));
		} else {
			echo json_encode(array('text' => "Sorry, I don't know how to {$cmd} " . implode(' ', $argv)));
		}
		exit;
	}

    function __cmd_pony($argv = array()) {
        $ponyText = "<pre>














                                        o
                               o       /
                                \     /
                                 \   /
                                  \ /
                    +--------------v-------------+
                    |  __________________      @ |
                    | /                  \       |  GET ME THE FUCK
                    | |             ,--, |  (\)  |  OUT OF HERE
                    | |       _ ___/ /\| |       |
                    | |   ,;`( )__, )  ~ |  (-)  |
                    | |  //  //   '--;   |       |
                    | \  '  -\     |    /  :|||: |
                    |  -oo---------------  :|||: |
                    +----------------------------+
                       []                    []



</pre>";

        return array('text' => $ponyText, 'clear' => true, 'flash' => 'ponies are awesome!');
    }

	function __cmd_help($argv = array()) {
		$helpText = "<pre>


                    help                    - show this very informative message
                    settings                - show settings menu
                    set (var) (value)       - apply a new setting


</pre>";

		return array('text' => $helpText, 'clear' => true);
	}

	function __cmd_set($argv = array()) {
		if(count($argv) != 2) {
			$str = "Set takes exactly two args";
		} else {
			$str = "What exactly do you know about gitrbug?";
		}
		return array('text' => $str);
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
