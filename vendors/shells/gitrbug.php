<?php
class GitrBugShell extends Shell {
    var $uses = array('Peer', 'CollectionFile');

    function main() {
//        debug($this->Peer->greet());
        debug($this->CollectionFile->scan_collection());
    }
}
?>
