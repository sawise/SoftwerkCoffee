<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');

   $browser = $_SERVER['HTTP_USER_AGENT'];
   print_r($browser);
	$progressSession = 0; 
	if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
		$progressSession = getSession('php_session'); 
		echo $progressSession;
	}
	
	$page_title = "Coffee";
	$error = false;
	$timestart = 0;
	$timeend = 0;
	$timeleft = 0;
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	
<div class="row divbg">
			<div class="inDiv"><a href="#" onClick="run()">Softwerk Coffee</a></div>
			<div class="inDiv">
				<div class="progressbg">
	
					<img src="img/coffeepot.png" class="imgA1"/>
						<div class="meter">
								<span id="progressbar" style="width: 100%;"></span>
						</div>
				</div>
						
			</div>
			<div class="inDiv">
				<span id="error" class="error" style="display:none;">ERROR!</span>
				<span id="progress"></span>

					<label class="checkbox toggle ios" style="width:100px"  onclick="">
					<?php if(!isset($_GET['status']) && $progressSession == 0 || (isset($_GET['status']) && $_GET['status'] == "off")) : ?>
						<input id="switch" type="checkbox" onClick="location.href='index.php?status=on'">

					<?php endif ?>
					<?php if(isset($_GET['status']) && $_GET['status'] == "on" || $progressSession > 0 && !isset($_GET['status'])) : ?>
						<input id="switch" type="checkbox" onClick="location.href='index.php?status=off'" checked>
					<?php endif ?>
					<span>
						Coffeestatus
						<span>Off</span>
						<span>On</span>
					</span>
					<a class="slide-button"></a>
				</label>
			</div>
		

			<?php 		
				if((isset($_GET['status']) && $_GET['status'] == "on") || ($progressSession > 0 && !isset($_GET['status']))){
					echo  progressBar($progressSession, date("U"));
				} if(isset($_GET['status']) && $_GET['status'] == "off") {
					saveSession(0, 'php_session');	
					saveSession(0, 'php_session1');	
				}
			?>
</div> 

<?php 

//GPIO draft 
//use PhpGpio\Gpio;
	/*$gpio = new GPIO(); 
	$gpio->setup(17, "out"); // Enable control for pin 17
	$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
	$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
	*/
 ?>
    

<?php require_once(ROOT_PATH.'/footer.php'); ?>
