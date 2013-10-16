<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');

   $browser = $_SERVER['HTTP_USER_AGENT'];

	$progressSession = 0; 
	$coffeestatus = 0;
	if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
		$progressSession = getSession('php_session'); 
		echo $progressSession;
		echo '<script language="javascript">
										console.log("currentsession: '.$progressSession.'");
								</script>';
	}
	if(file_exists(ROOT_PATH.'/tmp/coffeestatus.txt')){
		$coffeestatus = getSession('coffeestatus'); 
		echo $coffeestatus;
		echo '<script language="javascript">
										console.log("currentsession: '.$progressSession.'");
								</script>';
	}
	$crontab = new Ssh2_crontab_manager('dev.softwerk.se', '2222', 'pi', 'raspberry');
	$page_title = "Coffee";
	$error = false;
	$timestart = 0;
	$timeend = 0;
	$timeleft = 0;
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	
	<section class="index divbg">
		<!--<div class="inDiv"><a href="#" onClick="run()">Softwerk Coffee</a></div>-->
		<div class="progress-div inDiv">
			<div class="progressbg">
				<img src="img/coffeepot.png" class="imgA1"/>
				<div class="meter">
					<span id="progressbar" style="height: 0%;"></span>
				</div>
			</div>
		</div>
		<div class="inDiv">
        	<div id="info-div">
				<span id="error" class="error" style="display:none;">ERROR!</span>
				<span id="progress"></span>
            </div>
			<div class="switch-div">
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
          	<div class="switch-div">
				<label class="checkbox toggle ios" style="width:100px"  onclick="">
						<input id="switch" type="checkbox" onClick="location.href='index.php?status=on'">
					
					<span>
						Loaded
						<span>No</span>
						<span>Yes</span>
					</span>
					<a class="slide-button"></a>
				</label>
          	</div>
          	
		</div>
		
		<?php 		
			  if((isset($_GET['status']) && $_GET['status'] == "on") || ($progressSession > 0 && !isset($_GET['status']))){
               echo  progressBar($progressSession);
              $crontab->exec("sudo python /home/pi/coffee-on.py");
                
                } if(isset($_GET['status']) && $_GET['status'] == "off") {
                 	$crontab->exec("sudo python /home/pi/coffee-off.py");
                    saveSession(0, 'php_session');  
	                 saveSession('', 'coffeestatus');
                 }
		?>
	</section> 

<?php 


 ?>
    

<?php require_once(ROOT_PATH.'/footer.php'); ?>
