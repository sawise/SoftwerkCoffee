<?php

          	 require_once('../../config.php');
			//if (isset($_GET['user']) && isset($_GET['pass']) && $_GET['user'] == USER && $_GET['pass'] == PASS){
          	$db = new Db();
          	$histories = $db->getHistory();

          	 if(isset($_GET['command']) && $_GET['command'] == "getHistory"){
          	 		 foreach($histories as $history) {
				    		echo $history->date_time.';;'.$history->username.';;'.$history->actionname.'::';
    					}
          	 }
          //}

 ?>