
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
				
		//$crontab = new Ssh2_crontab_manager('dev.softwerk.se', '2222', 'pi', 'raspberry');
		if($true == "true") {
			if(!isset($_GET['command'])){
				echo "This is the webservice-page";
			}

			if(isset($_GET['command']) && $_GET['command'] == "getAutoswitchtime"){
				$autoswitchTime = getSession('autoswitchtime'); 
				 echo $autoswitchTime.'<br>';
				$autoswitchTime = preg_replace('/\s+/', ' ', $autoswitchTime);
				echo $autoswitchTime;
			   }

				 if(isset($_GET['command']) && isset($_GET['time']) && $_GET['command'] == "saveAutoswitchtime"){
					$time = $_GET['time'];
					saveSession($time, 'autoswitchtime');  
					echo $time;
			}

			if(isset($_GET['command']) && $_GET['command'] == "toggleautoswitch"){
				$autoswitchTime = getSession('autoswitchtime'); 

				$croncommand =  $autoswitchTime.' curl "http://localhost/api/?user='.$username.'&pass='.$password.'&command=turnOff"';
				$croncommand = preg_replace('/\s+/', ' ', $croncommand);
				$crontab->append_cronjob($croncommand);
			}

			if(isset($_GET['command']) && $_GET['command'] == "untoggleautoswitch"){
				$crontab->remove_crontab();
				echo "Untoggle autoswitch";
			}

			if(isset($_GET['command']) && $_GET['command'] == "autoswitchStatus"){
				$autoswitch = getSession('crontab'); 
				if(strlen($autoswitch) <= 0){
					echo "Autoswitch is on";
				} else {
					echo "Autoswitch is off";
				}
			}

			if(isset($_GET['command']) && $_GET['command'] == "turnOff"  && isset($_GET['u_id'])){
				saveSession(0, 'php_session');  
				$db->createHistory($_GET['u_id'], "3");
				//$crontab->exec("sudo python /home/pi/coffee-off.py");
				echo "Turn off the Coffee machine";
			}

			if(isset($_GET['command']) && isset($_GET['percent']) && $_GET['command'] == "saveSession"){
				$percent = $_GET['percent'];
				saveSession($percent, 'php_session');  
				echo $percent;
			}

			if(isset($_GET['command']) && $_GET['command'] == "turnOn" && isset($_GET['u_id'])){
				$db->createHistory($_GET['u_id'], "1");
				echo "Turn on the Coffee machine";
				$crontab->exec("sudo python /home/pi/coffee-on.py");
			}

			if(isset($_GET['command']) && $_GET['command'] == "getSession"){
				$progressSession = 0; 
				$progressSession = getSession('php_session'); 
				echo $progressSession;
			}

			if(isset($_GET['command']) && $_GET['command'] == "getTime"){
				$date = new DateTime();
				$dateunix = $date->format("U");
				echo $dateunix;
			}

			if(isset($_GET['command']) && $_GET['command'] == "toggleCoffeepowder"  && isset($_GET['u_id'])){
				$db->createHistory($_GET['u_id'], "2");
				$coffeepowderStatus = saveSession( "1", 'coffeepowderstatus'); 
				echo "Coffee loaded";                    
			}
			
			if(isset($_GET['command']) && $_GET['command'] == "untoggleCoffeepowder"){
				saveSession('', 'coffeepowderstatus'); 
				echo "Coffee unloaded";
			}
			
			if(isset($_GET['command']) && $_GET['command'] == "getCoffeepowderstatus"){
				$coffeepowderStatus = getSession('coffeepowderstatus'); 
				if($coffeepowderStatus > 0){
					echo "Coffee is loaded";
				} else {
					echo "Coffee is not loaded";
				}
			}
		}
	} else {
		echo 'wrong login...';
	} 

?>
