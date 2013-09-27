<?php
  session_start();
  
  define('ROOT_PATH', dirname(__FILE__));
  
  define('USER', 'user');
  define('PASS', 'pass');
  define('PASSCRYPT', crypt($crypto, '$5$rounds=5000$notevenclose$'));


  date_default_timezone_set('Europe/Stockholm');
  
  require_once(ROOT_PATH.'/includes.php');