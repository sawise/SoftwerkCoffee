<?php

          	 require_once('../../config.php');
			//if (isset($_GET['user']) && isset($_GET['pass']) && $_GET['user'] == USER && $_GET['pass'] == PASS){
          	$db = new Db();
          	$histories = $db->getHistory();
          	$history = $db->getlastHistory();

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
          //}

 ?>