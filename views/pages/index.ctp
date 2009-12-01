<?php
echo '<h2>';
echo __('Welcome to Gitrbug!');
echo '</h2>';

if (Configure::read() > 0):
	Debugger::checkSessionKey();
endif;

echo __("Listening on {$_SERVER["SERVER_NAME"]}:{$_SERVER["SERVER_PORT"]}");

/** test mp3 read/hash/write
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/home/jas/src/gitrbug/vendors/php-reader/src');
require_once("MPEG/ABS.php");

$abs = new MPEG_ABS("/home/jas/mp3/new/02 - Melody Function - Roucoulement.mp3");
$frames = $abs->getFrames();

$ctx = hash_init('tiger128,3');

//$out = fopen("/tmp/foo.mp3", "wb");
foreach($frames as $frame) {
    $fD = $frame->getData();
    $fH = $frame->getHeader();
    hash_update($ctx, $fH);
    hash_update($ctx, $fD);
//    fwrite($out, $fH, strlen($fH));
//    fwrite($out, $fD, strlen($fD));
}
//fclose($out);
$hash = hash_final($ctx);
echo "<p></p>";
debug($hash);
*/
?>
