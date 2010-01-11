<?php
class DATABASE_CONFIG {
	var $default = array(
		'driver' => 'sqlite3',
		'persistent' => false,
	);

    function __construct() {
        $this->default['database'] = ROOT . DS . APP_DIR . DS . 'db' . DS . 'gitrbug.dat';
    }
}
?>
