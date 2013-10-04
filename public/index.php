<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');
	$progressSession = 0; 
	if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
		$progressSession = getSession('php_session'); 
	}
	
	$page_title = "Coffee";
	$error = false;
	$timestart = 0;
	$timeend = 0;
	$timeleft = 0;
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	

<div class="row divbg">
			<div class="inDiv">Softwerk Coffee</div>
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
					//$total = 28;
					$progress = 0;
					if($progressSession <= 0){
						$timestart = microtime(true)*1000; 
						saveSession($timestart, 'php_session');
						saveSession($timestart, 'php_session1');
					}
					if ($progressSession > 0){
						$currenttime = microtime(true)*1000;
						$timeleft = $progressSession-$currenttime;
						//$progress = $timeleft;
						echo $timeleft;
					}

					for($i=$progress; $i<=100; $i++){
						/*$percent = intval($i/$total * 100);
						$percentreverse = intval(100/$total*$i );*/
						$value = "";					
						if($i < 10){
							$value = "0".$i;
						} else {
							$value = $i;
						}

						 if($i == 101 /*$gpioTurnon == false*/){ // Returns false or true if the pin is on or off 
								//header('location: index.php?status=error');
								echo '<script language="javascript">
							document.getElementById("error").style.display = "block";
							</script>';
							$error = true;
							i == 28; // Stopping the loop
						}

						if(!$error) {
								echo '<script language="javascript">
							document.getElementById("progress").innerHTML="'.$i.'%";
							</script>';
							echo '<script language="javascript">
							document.getElementById("progressbar").style.width="'.$i.'%";
							</script>';
							//saveSession($i, 'php_session');
							//saveSession($i, 'php_session1');
							echo str_repeat(' ',1024*64);
							flush();
							sleep(1); // 21<-- 21*28 = ~600sec = 10min 
						} 

						if($i == 28 && !$error) {
							echo '<script language="javascript">
							document.getElementById("progress").innerHTML="DONE!";
							</script>';
						}
					}
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
