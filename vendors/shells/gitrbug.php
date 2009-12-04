<?php
class GitrBugShell extends Shell {
    var $uses = array('Peer', 'CollectionFile');

    function main() {
//        debug($this->Peer->greet());
//        debug($this->CollectionFile->scan_collection());
        $files = array(
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/1. amanda conoce a amancio.mp3",
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/10. el ultimo hombre enamorado.mp3",
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/11. b612.mp3",
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/12. el plagio de un plagio.mp3",
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/3. nuevo futuro.mp3",
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/5. vestir santos.mp3",
            "/home/jas/mp3/new/corazon 2000 - nuevo futuro/6. sombrero de copa.mp3"
        );
        $this->CollectionFile->generate_dmp($files);
    }
}
?>
