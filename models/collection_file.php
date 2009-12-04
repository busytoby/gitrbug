<?php
class CollectionFile extends AppModel {

    var $name = 'CollectionFile';
    var $dir = '/home/jas/mp3';
    var $record_size = 0;

    //The Associations below have been created with all possible keys, those that are not needed can be removed
/*
    var $belongsTo = array(
        'Plugin' => array(
            'className' => 'Plugin',
            'foreignKey' => 'plugin_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
*/

    function scan_collection() {
        $this->cacheQueries = false;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->_scan_dir($this->dir, $finfo);
    }

    function _scan_dir($path = null, $finfo = null) {
        if(is_dir($path)) {
            foreach(glob($path.DIRECTORY_SEPARATOR.'*') as $file) {
                if(filetype($file) == 'dir') $this->_scan_dir($file, $finfo);
                else {
                    $mime = finfo_file($finfo, $file);
                    if($mime == 'audio/mpeg') {
                        $hash = $this->_scan_mp3_file($file);
                        $cData = array('CollectionFile' => array('path' => $file, 'hash' => $hash));
                        $this->create($cData);
                        $this->save();
//                        echo "{$file} => {$hash}\n";
                    }
                }
            }
        }
    }

    function _scan_mp3_file($file = null) {
        $fp = fopen($file, 'rb');
        $ctx = hash_init('tiger128,3');

        $stat = fstat($fp);
        $eof = $stat['size'];
        fseek($fp, $eof - 128);
        if(fread($fp, 3) == "ID3") $eof -= 128;

        fseek($fp, 0);
        $pos = $sof = ftell($fp);

        if(fread($fp, 3) == "ID3") {
            $flags = unpack("C3", fread($fp, 3)); // [1:2] is version but we don't care
            $footer = $flags[3] & (1<<4);
            $bs = unpack("C4", fread($fp, 4));
            $bsize = ($bs[1]<<21) + ($bs[2]<<14) + ($bs[3]<<7) + $bs[4];
            fseek($fp, $bsize);
            if($footer) fseek($fp, 10);

            $pos = $sof = ftell($fp);
        }

        fseek($fp, $pos);
        $hashed_data = 0;
        while(($pos = ftell($fp)) < $eof) {
            $remain = $eof - $pos;
            $block = "";
            $block_size = ($remain > 8192)?8192:$remain;
            hash_update($ctx, ($block = fread($fp, $block_size)));
            $hashed_data += $block_size;

            if($block_size == 8192) {
                $last_24 = unpack("C3", substr($block, intval($block[$block_size/2]), 3));

                $skip = 1;
                foreach($last_24 as $o) {
                    $o_char = unpack("C", $block[$o]);
                    $skip ^= ($o_char[1]+($o_char[1]<<7));
                    if($hashed_data > 1<<16) $skip = $skip<<1;
                }
                $skip = $skip<<2;

                while($skip > $remain) $skip = $skip>>3;
                if($skip && ($pos = ftell($fp)) + $skip < $eof) {
                    $pos += $skip;
                    fseek($fp, $pos);
                }
            }
        }
        $hash = hash_final($ctx);
        return $hash;
    }
}
?>