<?php 
	require_once('../../config.php');

	if (isset($_GET['username']) && isset($_GET['password'])){
		$username = $_GET['username'];
		$password = $_GET['password'];
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
			$statistics = $db->getStatisticsPastMonth();
			echo count($statistics);
		}
	} else {
		echo "wrong login";
	}
