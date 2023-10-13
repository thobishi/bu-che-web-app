<?php
class DATABASE_CONFIG {

	var $default = array(
		'driver' => 'mysqli',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'CHE_heqfonline',
		'password' => 'align4me',
		'database' => 'CHE_heqfonline',
	);
	var $heqc = array(
		'driver' => 'mysqli',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'heqc',
		'password' => 'workflow',
		'database' => 'CHE_heqconline',
	);
}
?>