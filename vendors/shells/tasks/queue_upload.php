<?php

class queueUploadTask extends Shell {
	public $uses = array('Queue.QueuedTask');

	public function run($data) {
        return true; // discard
	}
}

?>
