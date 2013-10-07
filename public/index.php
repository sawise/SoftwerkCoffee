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
	$currentTime = array_sum(explode(' ',Microtime()));
	$currentTime = str_replace('-', '', $currentTime);
	$timeleft = '';
	$timeelapsed = '';
	$timeon = 600;
	
	$page_title = "Coffee";
	$error = false;
	$timestart = 0;
	$timeend = 0;
	$timeleft = 0;
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	<script language="javascript">

	function run(){
		
	}

	function test(){
		for (var i=0;i<600;i++){
			setInterval(function(){document.getElementById("progressbar").style.width="+"+i+"%";)}, 1000;
			document.getElementById("progress").innerHTML="<br>----------------------------------->60% Timeleft: 50s  Time elapsed: 1000s";
			
		}
}
	</script>

<div class="row divbg">
			<div class="inDiv"><a href="#" onClick="run()">Softwerk Coffee</a></div>
			<div class="inDiv">
				<div class="progressbg">
					<div class="progressbg">
					<img src="img/coffeepot.png" class="imgA1"/>
						<div class="meter">
								<span id="progressbar" style="width: 100%;"></span>
						</div>
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
						$start = array_sum(explode(' ',Microtime()));
						$end = $start+$timeon;
						saveSession($end, 'php_session');
						saveSession($end, 'php_session1');
					}else if ($progressSession > 0){
						$timeleft = sprintf("%.0f",$currentTime - $progressSession);
						$timeleft = str_replace('-', '', $timeleft);
						$timeelapsed = sprintf("%.0f",$timeon-$timeleft);
						$progress = intval($timeelapsed/$timeon*100);
						//echo '--------------------------------------------->Time elapsed: '.$timeelapsed.' Time left: '.$timeleft;
						//echo '<br>Percent:'.$progress;
					}

					for($i=$progress; $i<=$timeon; $i++){
						/*$percent = intval($i/$total * 100);
						$percentreverse = intval(100/$total*$i );*/
						echo $i.'<--$i|-->	';
						$percent = sprintf("%.2f",$i/$timeon);

						 if($i == 101 /*$gpioTurnon == false*/){ // Returns false or true if the pin is on or off 
								//header('location: index.php?status=error');
								echo '<script language="javascript">
							document.getElementById("error").style.display = "block";
							</script>';
							$error = true;
							i == 101; // Stopping the loop
						}

						if(!$error) {
						   calculateTime($progressSession);
							echo '<script language="javascript">
							document.getElementById("progress").innerHTML="<br>----------------------------------->'.$percent.'% Timeleft: '.$timeleft.'Time elapsed: '.$timeelapsed.'";
							</script>';
							echo '<script language="javascript">
							document.getElementById("progressbar").style.width="'.$percent.'%";
							</script>';
							echo str_repeat(' ',1024*64);
							flush();
							sleep(1); // testvalue..
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
