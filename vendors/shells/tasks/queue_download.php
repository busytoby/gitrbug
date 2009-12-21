<?php

class queueDownloadTask extends Shell {
	public $uses = array('Queue.QueuedTask', 'CollectionFile', 'Peer');

	public function run($data) {
		debug($data);
		if(!$data['hash']) {
			$this->err("Nothing to download!?");
			return true;
		}
		debug($data);
		// check data['peers'] to see if we have any slots available
		if(!empty($data['peers'])) {
			if($this->__getDownloadSlot()) {
//				$this->spawnDownloader($data);
			}
		}

		if(!empty($data['finished'])) return true;

		$this->QueuedTask->createJob('search', $data);
//		return 1337; // requeue
		return true;
	}

	function __getDownloadSlot() { // stub
		return true;
	}

	function spawnDownloader($data) {
		function thread_shutdown() { posix_kill(posix_getpid(), SIGHUP); }

		if($pid = pcntl_fork()) return; // spawn to child process
		fclose(STDIN); // close descriptors
		fclose(STDOUT);
		fclose(STDERR);

		register_shutdown_function('thread_shutdown'); // zombie-proof

		if(posix_setsid() < 0) return; // re-parent child to kernel
		if($pid = pcntl_fork()) return; // now in daemonized downloader

		// download stuff

		return;
	}

/*
		if($peer = $this->Peer->choosePeer($data)) {
			$this->out(print_r($peer, true));

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
			}
			$this->out(print_r($res, true));
			return true;
		} else {
			// discard silently
			return true;
		}
*/
}
?>
