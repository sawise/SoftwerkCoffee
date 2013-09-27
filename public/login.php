<?php
	require_once('../config.php');
	
	if (!(isset($_COOKIE['remember_me']))) {	//if username cookie isn't set
		$_COOKIE['remember_me'] = "";			//changes value of username-input to null
	}

  	if (isset($_POST) && isset($_POST['username'])) {
  		$username = $_POST['username'];
    	      $password = crypt($_POST['password'], '$5$rounds=5000$notevenclose$'); 

    if ($username == USER && $password == crypt(PASS, '$5$rounds=5000$notevenclose$')) {
    	$_SESSION['is_logged_in'] = true;

      	if (isset($_SESSION['return_to'])) {
        	$return_to = $_SESSION['return_to'];
        	$_SESSION['return_to'] = null;
        	header('location: '.$return_to);
      	} else {
			/*
			$hour = time() + 3600;
			setcookie('ID_my_site', $_POST['username'], $hour);		//sets one-hour temporary cookie for username
			setcookie('Key_my_site', $_POST['password'], $hour);	//sets one-hour temporary cookie for password
			*/
			$year = time() + 31536000;
			if($_POST['remember']) {										//if "Remember me"-checkbox is checked
				setcookie('remember_me', $_POST['username'], $year);	//sets one-year cookie for username
			} elseif(!$_POST['remember']) {									//if "Remember me"-checkbox isn't checked
				if(isset($_COOKIE['remember_me'])) {
					$past = time() - 100;
					setcookie(remember_me, gone, $past);	//removes username-cookie
				} 	
			}
			header('location: index.php');
      	} 
    	} else {
			set_feedback("error", "Wrong username or password.");
		}
  	}

  	$page_title = "Log in";

?>
<?php require_once(ROOT_PATH.'/header.php'); ?>

	<section>
    	<div class="login-form divbg">
        	<form role="form" method="post" action="login.php">
            	<div class="form-group">
                <label class="sr-only" for="username"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php
echo $_COOKIE['remember_me']; ?>" />
                </div>
                <div class="form-group">
               		<label class="sr-only" for="password"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
              	</div>
                <div class="form-group" id="login-button-group">
      				<button class="btn btn-primary" type="submit" id="login-button">Log in</button>
                   	<div class="checkbox">
                    	<label>
                            <input type="checkbox" class="form-control" id="remember" name="remember" value="1" 
                            
								<?php if ($_COOKIE['remember_me'] != "") {	//checks if a cookie is stored
										echo 'checked="checked"';
									} else {
										echo '';
									} ?> 
                                    
                          	 /> Remember me 
                    	</label>
                    </div>
                </div>
    		</form>
        </div>
   	<section>

<?php require_once(ROOT_PATH.'/footer.php'); ?>