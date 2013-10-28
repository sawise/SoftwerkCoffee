<?php
	session_start();
	  
	define('ROOT_PATH', dirname(__FILE__));
	
	$file = ROOT_PATH.'/public/credentials';
	$fh = fopen($file, 'r');
	$values = fgets($fh);
	$value = explode(':', $values);
	
	
  	define('DB_USER', 'root');
  	define('DB_PASS', '');
  	define('DB_NAME', 'softwerkcoffee');
  	define('DB_HOST', 'localhost');
		
	define('USER', $value[0]);
	define('PASS', $value[1]);
	define('SALT', '34A75DD4C4DF5E4DDFC68CA975B35');
	//define('PASSCRYPT', crypt(PASS, '$5$rounds=5000$notevenclose$'));
	
	fclose($fh);
	
	date_default_timezone_set('Europe/Stockholm');
	  
	require_once(ROOT_PATH.'/includes.php');