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
		</style>
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
