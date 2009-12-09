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

    function getSample($file, $seq_begin = 0) {
        $block_size = 65536;
        $fp = fopen($file['CollectionFile']['path'], 'rb');

        $offsets = $this->_mp3_data_offset($file['CollectionFile']['path']);

        $seq_begin = $offsets[0] + $seq_begin;
        $seq_end = $seq_begin + $block_size;
        if($seq_end >= $offsets[1]) $block_size = $offsets[1] - $seq_begin;
        fseek($fp, $offsets[0] + $seg_begin);

        $data = fread($fp, $block_size);
        fclose($fp);

        return base64_encode($data);
    }

    function md5($file, $offset = 0) {
        return md5($this->getSample($file, $offset));
    }

    function countFileSegments($file) {
        $offsets = $this->_mp3_data_offset($file['CollectionFile']['path']);

        return ceil(($offsets[1] - $offsets[0]) / 65536);
    }

    function scan_collection() {
        $this->cacheQueries = false;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->_scan_dir($this->dir, $finfo);
    }

    function generate_dmp($data = array()) {
        $dmp = array();

        if(empty($data)) return $dmp;
        if(!is_array($data)) $data = array(array('path' => $data));

        foreach($data as $dmp_item) {
            if(!is_array($dmp_item))
                $dmp_item = array('path' => $dmp_item);
            if(!array_key_exists('hash', $dmp_item)) {
                if(is_dir($dmp_item['path'])) {
                    foreach(glob($dmp_item['path'].DIRECTORY_SEPARATOR.'*') as $file) {
                        if( $fileData = $this->find('first', array(
                                            'conditions' => array('path' => $file), // plugin_id too later
                                            'fields' => array('hash')
                                        ))) {
                            $dmp[] = array(
                                'hash' => $fileData['CollectionFile']['hash'],
                                'tags' => $this->get_tags($file)
                            );
                        }
                    }
                } else {
                    if( $fileData = $this->find('first', array(
                                        'conditions' => array('path' => $dmp_item['path']), // plugin_id too later
                                        'fields' => array('hash')
                                    ))) {
                        $dmp[] = array(
                            'hash' => $fileData['CollectionFile']['hash'],
                            'tags' => $this->get_tags($dmp_item['path'])
                        );
                    }
                }
            }
        }

        return(serialize($dmp));
    }

    function get_tags($path) {
        App::import('Vendor', 'getid3/getid3/getid3');

        $g3 = new getID3;
        $tags = $g3->analyze($path);
        getid3_lib::CopyTagsToComments($tags);

        $tags = am(
            array(
                'bitrate' => $tags['audio']['bitrate'],
                'length' => $tags['playtime_seconds']
            ),
            $tags['comments']
        );

        return $tags;
    }

    function write_tags($file, $data = array()) {
        App::import('Vendor', 'getid3/getid3/getid3'); //getid3/getid3/getid3/getid3/getid3 ;)
        $g3 = new getID3;
        $g3->setOption(array('encoding'=>'UTF-8'));
        App::import('Vendor', 'getid3/getid3/write');

        $id3 = new getid3_writetags;
        $id3->filename = $file;
        $id3->tagformats = array('id3v1', 'id3v2.3');
        $id3->overwrite_tags = true;
        $id3->tag_encoding = 'UTF-8';
        $id3->remove_other_tags = false;

        $tags = array();
        foreach($data as $key => $val) {
            if(is_array($val)) {
                foreach($val as $v) {
                    $tags[$key][] = $v;
                }
            } else {
                $tags[$key][] = $val;
            }
        }

        $old_tags = $g3->analyze($file);
        getid3_lib::CopyTagsToComments($old_tags);

        $id3->tag_data = am($old_tags['comments'], $tags);

        if($id3->WriteTags()) {
            if(!empty($id3->warnings))
                debug($id3->warnings);
            return true;
        } else {
            debug($id3->errors);
        }
    }

    function _scan_dir($path = null, $finfo = null) {
        if(is_dir($path)) {
            foreach(glob($path.DIRECTORY_SEPARATOR.'*') as $file) {
                if(filetype($file) == 'dir') $this->_scan_dir($file, $finfo);
                elseif( $this->find('count', array(
                            'conditions' => array('path' => $file), // plugin_id too later
                        )) == 0) {
                    $mime = finfo_file($finfo, $file);
                    if($mime == 'audio/mpeg' || (strripos($file, ".mp3") == (strlen($file) - 4))) {
                        $hash = $this->_scan_mp3_file($file);
                        $cData = array('CollectionFile' => array('path' => $file, 'hash' => $hash));
                        $this->create($cData);
                        $this->save();
                        echo "{$file} => {$hash}\n";
                    }
                } else {
                    usleep(50000); // sleep 1/20 of a second to keep cpu usage low for re-scans
                }
            }
        }
    }

    function _mp3_data_offset($file = null) {
        $fp = fopen($file, 'rb');

        $stat = fstat($fp);
        $eof = $stat['size'];
        fseek($fp, $eof - 128);
        if(fread($fp, 3) == "ID3") $eof -= 128;

        fseek($fp, 0);
        $sof = ftell($fp);

        if(fread($fp, 3) == "ID3") {
            $flags = unpack("C3", fread($fp, 3)); // [1:2] is version but we don't care
            $footer = $flags[3] & (1<<4);
            $bs = unpack("C4", fread($fp, 4));
            $bsize = ($bs[1]<<21) + ($bs[2]<<14) + ($bs[3]<<7) + $bs[4];
            fseek($fp, $bsize);
            if($footer) fseek($fp, 10);

            $sof = ftell($fp);
        }

        fclose($fp);
        return array($sof, $eof);
    }

    function _scan_mp3_file($file = null) {
        $fp = fopen($file, 'rb');
        $ctx = hash_init('tiger128,3');

        $offsets = $this->_mp3_data_offset($file);

        $sof = $pos = $offsets[0];
        $eof = $offsets[1];

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

        fclose($fp);
        $hash = hash_final($ctx);
        return $hash;
    }
}
?>
