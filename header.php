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
				width:13em;
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
          			<p>Logged in as <a href="settings.php" ><?php echo USER; ?></a> | <a class="logout_link" href="logout.php">Log out</a></p>
      			</div>
      		<?php endif ?>
