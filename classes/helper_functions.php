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
	function saveSession($session){
	  //$session_data = $session; // Get the session data
      $filehandle = fopen (ROOT_PATH.'/tmp/php_session.txt', 'w+'); // open a file write session data
      fwrite ($filehandle, $session); // write the session data to file
      fclose ($filehandle);
	}
	function getSession(){
		 $filehandle = fopen (ROOT_PATH.'/tmp/php_session.txt', 'r'); // open file containing session data 
      $sessiondata = fread ($filehandle, 4096); // read the session data from file
      fclose ($filehandle);
      return $sessiondata;
	}
?>