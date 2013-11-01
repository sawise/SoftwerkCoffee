<?php

          require_once('../../config.php');

			 if (isset($_GET['user']) && isset($_GET['pass'])){
				            $db = new Db();
					$username = $_GET['user'];
					$password = $_GET['pass'];
					$true = "false";
					$db_username = $db->getUsername($username);
					$db_password = $db->getPassword($password);
					
					if (count($db_username) > 0) {
						
						if ($db_username->username == $username) {
						
							if (count($db_password) > 0) {
						
								if ($db_password->password == $password) {
									$true = "true";
									
								} else {
									$true = "false";
								}
							} else {
								$true = "false";
							}
						} else {
							$true = "false";
						}
					} else {
						$true = "false";
					}

				if($true == "true"){
	          
	          	$histories = $db->getHistory();
	          	//$history = $db->getlastHistory();

	          	if(isset($_GET['command']) && $_GET['command'] == "getlatestHistory"){
	          			foreach($histories as $history) {
	          				if($history->a_action_id == 1){
					    			echo $history->date_time.';;'.$history->username.';;'.$history->actionname.'::';
					    		}
	    					}
	          	}

	          	 if(isset($_GET['command']) && $_GET['command'] == "getHistory"){
	          	 		 foreach($histories as $history) {
					    		echo $history->date_time.';;'.$history->username.';;'.$history->actionname.'::';
	    					}
	          	 }
	         	}
          }

 ?>