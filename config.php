<?php
	session_start();
	  
	define('ROOT_PATH', dirname(__FILE__));
	
	$file = ROOT_PATH.'/dbcredentials';
	$fh = fopen($file, 'r');
	$dbvalues = fgets($fh);
	$dbvalue = explode(':', $dbvalues);
	
  	define('DB_USER', $dbvalue[0]);
  	define('DB_PASS', $dbvalue[1]);
  	define('DB_NAME', $dbvalue[2]);
  	define('DB_HOST', $dbvalue[3]);
	
	define('SALT', '34A75DD4C4DF5E4DDFC68CA975B35');
	
	fclose($fh);
	
	date_default_timezone_set('Europe/Stockholm');
	  
	require_once(ROOT_PATH.'/includes.php');