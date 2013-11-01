<?php 
	require_once('../../config.php');

	if (isset($_GET['user']) && isset($_GET['pass'])) {
		$username = $_GET['user'];
		$password = $_GET['pass'];
		
		$db = new Db();
		$db_username = $db->getUsername($username);
		$db_password = $db->getPassword($password);
		
		if (count($db_username) > 0) {
			
			if ($db_username->username == $username) {
			
				if (count($db_password) > 0) {
			
					if ($db_password->password == $password) {
						echo "true:".$db_username->id;
						//echo $db_username->id;
						
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
  	} else {
		echo "not set";
	}

?>