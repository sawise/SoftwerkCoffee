<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title; ?></title>
		<!--<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js'></script>-->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js?ver=1.7.0'></script>
<script>


	   		
 //jQuery('body').hide();
		jQuery(window).ready(function() {
	   		//jQuery('body').fadeIn(3000);
			$('body').hide();
			//$('#container').fadeOut('slow', function(){
        		$('body').fadeIn(2000);
				jQuery('#loaderImagee').fadeOut(1000);
    		//});
	   		//jQuery('#container').fadeIn(3000);	   		
	    console.log("body fading in...");
	});
		
</script>

	<img id="loaderImagee" class="loaderImagee" src="img/ajax-loading.gif">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/toggle-switch.css" rel="stylesheet">
        <style>
			body {
				text-align:center;
				background: url('img/bg.jpg') fixed;
				background-repeat:repeat;
			}
			
			footer {
				margin:2em;
			}

			.progressbg{
				height: 25em;
				width: 25em;
				padding-bottom: 1.5em;
				text-align: left;
			}

			.imgA1 {
				padding: 5em;
				padding: 4em 0 0 1em;
			   position:absolute;
			   z-index:2;
			  }

			  .loaderImagee {
			  	position: fixed;
				left: 50%;
				top: 50%;
		
			   display: none;
			   z-index: 3;
			  }


			.meter { 
				height: 27.3em;  
				width: 23.2em;
				padding:8em 0em 0em 1em;
				display: table-cell;
   vertical-align: bottom;
				-webkit-box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
				-moz-box-shadow   : inset 0 -1px 1px rgba(255,255,255,0.3);
				box-shadow        : inset 0 -1px 1px rgba(255,255,255,0.3);
			}

			
			.meter > span {
				opacity:0.95;
				vertical-align: bottom;
				filter:alpha(opacity=95);
				display: block;
				z-index: 1;
				margin: 10em 0 0em 0em;
				width: 100%;
	
				background-color: rgb(43,194,83);
				background-image: -webkit-gradient(
				  linear,
				  left bottom,
				  left top,
				  color-stop(0, rgb(128,42,42)),
				  color-stop(1, rgb(128,42,42))
				 );
				background-image: -webkit-linear-gradient(
				  center bottom,
				  rgb(128,42,42) 37%,
				  rgb(128,42,42) 69%
				 );
				background-image: -moz-linear-gradient(
				  center bottom,
				  rgb(128,42,42) 37%,
				  rgb(128,42,42) 69%
				 );
				background-image: -ms-linear-gradient(
				  center bottom,
				  rgb(128,42,42) 37%,
				  rgb(128,42,42) 69%
				 );
				background-image: -o-linear-gradient(
				  center bottom,
				  rgb(128,42,42) 37%,
				  rgb(128,42,42) 69%
				 );
				-webkit-box-shadow: 
				  inset 0 2px 9px  rgba(255,255,255,0.3),
				  inset 0 -2px 6px rgba(0,0,0,0.4);
				-moz-box-shadow: 
				  inset 0 2px 9px  rgba(255,255,255,0.3),
				  inset 0 -2px 6px rgba(0,0,0,0.4);
				position: relative;
				overflow: hidden;
			}


			.error{
				background-color: #FF0000;
				margin-left:auto;
				margin-right:auto;
				text-align: center;
				z-index: 1;
				padding-top: 0.5em;
				width:8em;
				height:2em;
				font:bold 2em;
				color:#FFFFFF;
			}

			pre{
				background: #FFFFFF;
				border: 0;
			}

			.divbg{
				background: #FFFFFF;
				border: 2px, #00FF00;
				opacity:0.9;
				filter:alpha(opacity=90);
				border-radius:5px;
			}
			.index {
				display:inline-block;
				width:80%;
				margin-top:-8em;
				padding:2em 4em 4em 4em;
			}
			.inDiv{
				opacity:1;
				text-align:center;
				filter:alpha(opacity=1);
				/*padding-left: 10em;*/
			}
			.progress-div {
				display:inline-block;
				clear:both;		
			}
			.switch-div {
				display:inline-block;
				clear:both;
			}
			#info-div {
				display:block;
				clear:both;
				height:5em;
				padding-top:2em;
			}
			.container {
				margin-top:1em;
			}
			.login-form {
				display:inline-block;
				background: rgb(255, 255, 255); /* Fall-back for browsers that don't
                                    support rgba */
				background-color:rgba(255, 255 ,255 ,0.4);
				padding:8px;
				border-radius:5px;
			}
			#user_info {
				float:left;
				position:fixed;
				top:0px;
				left:0px;
				z-index:1;
				width:10em;
				height:3em;
	  		}
			.alert {
				display:inline-block;
			  	width:16em;
				text-align:center;
			}
			.alert-div {
				height:10em;
			}
			#login-button {
				float:left;
			}
			.checkbox {
				margin-right:20px;
				margin-top:5px;
				float:right;
			}
			#settings-div {
				float:right;
				display:block;
				margin-top:-4em;
				margin-right:1em;
			}
			#txt {
				margin:0 10px 0 10px;
				width:10%;
				text-align:center;
			}
			.settings {
				display:inline-block;
				padding:5em 0 5em 0;
				width:80%;
				height:10em;
			}
			#time-block {
				margin-top:3em;
			}
			#time {
				margin-top:1em;
			}
			#remember {
				color:#000;
			}
			#progress {
				font-size:15px;
			}
			#username-span {
				font-style:italic;
			}
			.stats-bold {
				font-weight:bold;
			}
			.stats-p {
				font-size:16px;
			}
			#stats-div {
				display:block;
				float:left;
				padding-top:1em;
				text-align:left;
			}
		</style>
        <script type="text/javascript">
			var a = 0;
			var b = 0;
			var c = 0;
			var d = 0;
			var e = 0;
			var f = 0;
			var t;
			var timer_is_on = 0;
			
			function timedCount() {
				document.getElementById('txt').value = "" + f + e + ":" + d + c + ":" + b + a;
				a = a + 1;
				if (a == 10) {
					b = b + 1;
					a = 0;
				}
				if (b == 6) {
					c = c + 1;
					b = 0;
				}
				if (c == 10) {
					d = d + 1;
					c = 0;
				}
				if (d == 6) {
					e = e + 1;
					d = 0;
				}
				if (e == 10) {
					f = f + 1;
					e = 0;
				}
				t = setTimeout("timedCount()", 1000);
			}
			
			function doTimer() {
				if (!timer_is_on) {
					timer_is_on = 1;
					timedCount();
				}
			}
			
			function stopCount() {
				clearTimeout(t);
				timer_is_on = 0;
			}
			
			function timeFunction() {
				var d = new Date();
			  	document.getElementById('time').innerHTML = d.getHours() + ":" + d.getMinutes();
			}
					
		</script>
	</head>
    <header>
    </header>
	<body id="body">
    	<div class="alert-div"><?php echo get_feedback(); ?></div>
    	<div id="container" class="container">
        	 <?php if (isset($_SESSION['is_logged_in']) && isset($_SESSION['user_username'])) : ?>
             	<?php $username = $_SESSION['user_username']; ?>
			 	<div class="well well-small" id="user_info">
          			<?php if ($page_title != "Settings") : ?>
                    	<p>Logged in as <span id="username-span"><?php echo $username; ?></span> <br /> <a href="settings.php">Settings</a> | <a class="logout_link" href="logout.php">Log out</a></p>
					<?php else : ?>
                        <p>Logged in as <span id="username-span"><?php echo $username; ?></span> <br /> Settings | <a class="logout_link" href="logout.php">Log out</a></p>
					<?php endif ?>
      			</div>
      		<?php endif ?>
