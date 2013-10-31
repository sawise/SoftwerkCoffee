<?php
	session_start();
	  
	define('ROOT_PATH', dirname(__FILE__));
	
	$file2 = ROOT_PATH.'/credentials';
	$fh2 = fopen($file2, 'r');
	$values = fgets($fh2);
	$value = explode(':', $values);
	
	$file = ROOT_PATH.'/dbcredentials';
	$fh = fopen($file, 'r');
	$dbvalues = fgets($fh);
	$dbvalue = explode(':', $dbvalues);
	
  	define('DB_USER', $dbvalue[0]);
  	define('DB_PASS', $dbvalue[1]);
  	define('DB_NAME', $dbvalue[2]);
  	define('DB_HOST', $dbvalue[3]);
		
	define('USER', $value[0]);
	define('PASS', $value[1]);
	define('SALT', '34A75DD4C4DF5E4DDFC68CA975B35');
	//define('PASSCRYPT', crypt(PASS, '$5$rounds=5000$notevenclose$'));
	
	fclose($fh);
	fclose($fh2);
	
	date_default_timezone_set('Europe/Stockholm');
	  
	require_once(ROOT_PATH.'/includes.php');