<?php
	session_start();
	  
	define('ROOT_PATH', dirname(__FILE__));
	
	$file = ROOT_PATH.'/credentials';
	$fh = fopen($file, 'r');
	$values = fgets($fh);
	$value = explode(':', $values);
		
	define('USER', $value[0]);
	define('PASS', $value[1]);
	//define('PASSCRYPT', crypt(PASS, '$5$rounds=5000$notevenclose$'));
	
	fclose($fh);
	
	date_default_timezone_set('Europe/Stockholm');
	  
	require_once(ROOT_PATH.'/includes.php');