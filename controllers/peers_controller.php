<?php
class PeersController extends AppController {

	var $name = 'Peers';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $uses = array('Peer', 'Tag', 'CollectionFile' , 'Queue.QueuedTask', 'Setting');

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
\n\n
\t\t\t\t\t\t\to
\t\t\t\t\to\t       /
\t\t\t\t\t \\\t      /
\t\t\t\t\t  \\\t     /
\t\t\t\t\t   \\\t    /
\t\t\t\t+--------------v-------------+
\t\t\t\t|  __________________	   @ |
\t\t\t\t| /\t\t     \\\t     |\tGET ME THE FUCK
\t\t\t\t| |\t\t,--, |\t(\)  |\tOUT OF HERE
\t\t\t\t| |\t  _ ___/ /\| |       |
\t\t\t\t| |  ,;`( )__, )   ~ |	(-)  |
\t\t\t\t| | //	 //  '--;    |       |
\t\t\t\t| \ '	-\    |      / :|||: |
\t\t\t\t|  -oo---------------  :|||: |
\t\t\t\t+----------------------------+
\t\t\t\t      []\t\t[]
</pre>";

		return array('text' => $ponyText, 'clear' => true, 'flash' => 'ponies are awesome!');
	}

	function __cmd_clear() {
		return array('clear' => true);
	}

	function __cmd_help($argv = array()) {
		$helpText = "<pre>
  \t\t () = required, [] = optional

  \t\t help\t\t\t\t - show this very informative message
  \t\t clear\t\t\t\t - clear the screen

  \t\t set [var [value]]\t\t - apply a new setting

//\t\t greet (ip) [port]\t\t - add a peer by address

//\t\t scan\t\t\t\t - scan or update the local collection
//\t\t stats\t\t\t\t - show collection and transfer statistics
//\t\t transfers\t\t\t - show ongoing transfers

//\t\t download [url]\t\t\t - queue DMP by location or open file browser

</pre>";

		return array('text' => $helpText, 'clear' => true);
	}

	function __cmd_set($argv = array()) {
		if(count($argv) > 2) {
			$str = "Too many arguments";
		} else {
			if(empty($argv)) {
				$settings = $this->Setting->find('list', array('fields' => array('name', 'value')));

				$str = "<pre>
		node_name\t - <span id='_s_node_name' class='_s_editable'>{$settings['node_name']}</span>
		ip_addr\t\t - <span id='_s_ip_addr' class='_s_noneditable'>{$settings['ip_addr']}</span>
		port\t\t - <span id='_s_port' class='_s_noneditable'>{$settings['node_port']}</span>
		max_uls\t\t - <span id='_s_max_uls' class='_s_editable'>{$settings['max_uls']}</span>
		max_dls\t\t - <span id='_s_max_dls' class='_s_editable'>{$settings['max_dls']}</span>
		collection_dir\t - <span id='_s_collection_dir' class='_s_editable'>{$settings['collection_dir']}</span>
				</pre>";
//				$str = print_r($settings, true);
			} else {
				if($setting = $this->Setting->find('first', array('conditions' => array('name' => $argv[0])))) {
					if(count($argv) == 1) {
						$str = "<pre>\n" . sprintf("%20s%-24s - %s", null, $setting['Setting']['name'], $setting['Setting']['value']) . "\n\n</pre>";
					} else {
						if(!in_array($argv[0], array('node_port', 'ip_addr'))) {
							$this->Setting->id = $setting['Setting']['id'];
							if($this->Setting->saveField('value', $argv[1])) {
								$str = "Set {$argv[0]}";
							} else {
								$str = "Failed to set {$argv[0]}";
								$str = print_r($setting, true);
								$str = print_r($this->Setting, true);
							}
						} else {
							$str = "Unable to set {$argv[0]}";
						}
					}
				} else {
					$str = "No such setting {$argv[0]}";
				}
			}
		}
		return array('text' => $str, 'bind' => true);
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
