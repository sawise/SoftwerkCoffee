<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title; ?></title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/toggle-switch.css" rel="stylesheet">
        <style>
			body {
				text-align:center;
				background: url('img/bg.jpg');
				background-repeat:repeat;
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

			.meter { 
				height: 28.3em;  
				width: 23.2em;
				padding:1em 0em 0em 1em;

				-webkit-box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
				-moz-box-shadow   : inset 0 -1px 1px rgba(255,255,255,0.3);
				box-shadow        : inset 0 -1px 1px rgba(255,255,255,0.3);
			}
			
			.meter > span {
				opacity:0.95;
				filter:alpha(opacity=95);
				display: block;
				z-index: 1;
				margin: 6.5em 0 0em 0em;
				height: 71%;
				   -webkit-border-top-right-radius: 50em;
				-webkit-border-bottom-right-radius: 50em;
				       -moz-border-radius-topright: 50em;
				    -moz-border-radius-bottomright: 50em;
				           border-top-right-radius: 50em;
				        border-bottom-right-radius: 50em;
				    -webkit-border-top-left-radius: 50em;
				 -webkit-border-bottom-left-radius: 50em;
				        -moz-border-radius-topleft: 50em;
				     -moz-border-radius-bottomleft: 50em;
				            border-top-left-radius: 50em;
				         border-bottom-left-radius: 50em;
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
				padding-top: 0.5em;
				width:8em;
				height:2em;
				font:bold 2em;
				color:#FFFFFF;
			}

			.divbg{
				background: #FFFFFF;
				border: 2px, #00FF00;
				opacity:0.9;
				filter:alpha(opacity=90);
			}

			.inDiv{
				opacity:1;
				text-align:center;
				filter:alpha(opacity=1);
				padding-left: 10em;
			}
			.container {
				margin-top:2em;
			}
			.login-form {
				display:inline-block;
			}
			#user_info {
				float:left;
				position:fixed;
				top:0px;
				left:0px;
				z-index:1;
				width:10em;
				height:1em;
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
				float:left;
				position:fixed;
				top:4em;
				left:1em;
			}
			#txt {
				margin:0 10px 0 10px;
				width:10%;
				text-align:center;
			}
			#settings {
				display:inline-block;
				padding:5em 0 5em 0;
				width:80%;
				height:10em;
				background-color:white;
			}
			#time-block {
				margin-top:3em;
			}
			#time {
				margin-top:1em;
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
	<body>
    	<div class="alert-div"><?php echo get_feedback(); ?></div>
    	<div class="container">
        	 <?php if (isset($_SESSION['is_logged_in'])) : ?>
			 	<div class="well well-small" id="user_info">
          			<p><a href="settings.php" >Settings</a> | <a class="logout_link" href="logout.php">Log out</a></p>
      			</div>
      		<?php endif ?>
