<?php
	function set_feedback($status, $text) {
    	$_SESSION['feedback'] = array('status' => $status, 'text' => $text);
	}

	function get_feedback() {
		$html = "";
		if (isset($_SESSION['feedback'])) {
			$html .= '<div class="alert alert-'.$_SESSION['feedback']['status'].'">';
			$html .= '<button type="button" class="close" data-dismiss="alert">×</button>';
			$html .= $_SESSION['feedback']['text'];
			$html .= '</div>';
			$_SESSION['feedback'] = null;
		}
		return $html;
	}
	
	function form_input($type, $class, $name, $placeholder_text = null, $valuetext = null) {
		if ($placeholder_text != null) {
			$placeholder_text = ' placeholder="'.$placeholder_text.'"';
		} if ($valuetext != null) {
			$valuetext = ' value="'.$valuetext.'"';
		}

		$html = '<input type="'.$type.'" class="'.$class.'" id="'.$name.'" name="'.$name.'"  '.$placeholder_text.''.$valuetext.'>';

		return $html;
	}
	function saveSession($session, $filename){
	  //$session_data = $session; // Get the session data
      $filehandle = fopen (ROOT_PATH.'/tmp/'.$filename.'.txt', 'w+'); // open a file write session data
      fwrite ($filehandle, $session); // write the session data to file
      fclose ($filehandle);
	}
	function getSession($filename){
		 $filehandle = fopen (ROOT_PATH.'/tmp/'.$filename.'.txt', 'r'); // open file containing session data 
      $sessiondata = fread ($filehandle, 4096); // read the session data from file
      fclose ($filehandle);
      return $sessiondata;
	}

	function calculateTime($progressSession){
		global $timeleft;
		global $timeelapsed;
		global $progress;
		$now = array_sum(explode(' ',Microtime()));
		$now = str_replace('-', '', $now);
		$timeleft =  sprintf("%.0f", $now - $progressSession);
		$timeleft = intval(str_replace('-', '', $timeleft));
		$timeelapsed = sprintf("%.0f",600-$timeleft);
		$progress = intval($timeelapsed/600*100);
	}

	function progressBar($session){
		$start = 0;
		$end = 0;
		$timeleft = 0;
		$timeelapsed = 0;
		$progress = 0;
		$timeon = 600;
		$date = new DateTime();
		$dateunix = $date->format("U");
		if($session <= 0){
				$start = $dateunix;
				$end = $start+$timeon;
				saveSession($end, 'php_session');
		}else if ($session > 0){
				$end = $session;
				$timeleft = $dateunix - $end;
				$timeleft = str_replace('-', '', $timeleft);
				$timeelapsed = $timeon-$timeleft;
				$progress = intval(($timeelapsed/$timeon)*$timeon);
		}
		$script = '<script language="javascript">;
										var x = '.$progress.'; 
										console.log("'.$session.'<->'.$dateunix.'")
										setInterval(function() {
										  if (x <= '.$timeon.') {
										  	var percent = x/'.$timeon.'*100;
										  	percent = percent.toFixed(2);
										  	var now = Math.round(new Date().getTime()/1000.0);
										  	var timeend = '.$end.';
										  	var timeleft =  timeend-now;
										  	var timeelapsed = '.$timeon.'-timeleft;
										  	//console.log(x+"----"+percent);
										   document.getElementById("progressbar").style.height="+"+percent+"%";
											document.getElementById("progress").innerHTML="<br>"+percent+"% Timeleft:"+timeleft+"  Time elapsed: "+timeelapsed;
										  } if (x == 600){
										  		document.getElementById("progressbar").style.width="+"+percent+"%";
										  		document.getElementById("progress").innerHTML="DONE!";
										  } else if (x == 601) {
										  		document.getElementById("error").style.display = "block";
										  }	
										  x++;
										}, 1000);
								</script>';
		return $script;
	}

	
?>