<?php 
	require_once('../../config.php');

	if (isset($_GET['user']) && isset($_GET['pass'])){
		$username = $_GET['user'];
		$password = $_GET['pass'];
		$true = "false";
		
		$db = new Db();
		$db_username = $db->getUsername($username);
		$db_password = $db->getPassword($password);
		
		if (count($db_username) > 0) {
			
			if ($db_username->username == $username) {
			
				if (count($db_password) > 0) {
			
					if ($db_password->password == $password) {
						$true = "true";
	
					} else {
						echo "false";
					}
				} else {
					echo "false";
				}
			} else {
				echo "false";
			}
		} else {
			echo "false";
		} 
		if ($true == "true") {
			$statistics = $db->getStatistics();
			echo count($statistics);
		}
	} else {
		echo "wrong login";
	}
