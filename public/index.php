<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');

   $browser = $_SERVER['HTTP_USER_AGENT'];

	$progressSession = 0; 
	$coffeepowderStatus = 0;
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
	}
		if(file_exists(ROOT_PATH.'/tmp/coffeepowderstatus.txt')){
		$coffeepowderStatus = getSession('coffeepowderstatus'); 
		echo $coffeepowderStatus;
	}
	//$crontab = new Ssh2_crontab_manager('dev.softwerk.se', '2222', 'pi', 'raspberry');
	$crontab = new Ssh2_crontab_manager('localhost', '22', 'sam', 'Jonsson91');
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
							<input id="coffeepowderSwitch" type="checkbox">
						<span>
							Loaded
							<span>No</span>
							<span>Yes</span>
						</span>
						<a class="slide-button"></a>
					</label>
          	</div>

          	<div class="switch-div">
				<label class="checkbox toggle ios" style="width:100px"  onclick="">
						<input id="autoSwitch" type="checkbox">
					<span>
						Autoswitch
						<span>Off</span>
						<span>On</span>
					</span>
					<a class="slide-button"></a>
				</label>
          	</div>
		</div>
		
		<?php 		
			  if((isset($_GET['status']) && $_GET['status'] == "on") || ($progressSession > 0 && !isset($_GET['status']))){
               echo  progressBar($progressSession);
              $crontab->exec("sudo python /home/pi/coffee-on.py");
              saveSession('1', 'coffeepowderStatus');
                
                } if(isset($_GET['status']) && $_GET['status'] == "off") {
                 	$crontab->exec("sudo python /home/pi/coffee-off.py");
                    saveSession('0', 'php_session');  
	                 saveSession('0', 'coffeepowderStatus');
                 }
		?>
	</section> 

<script>
	<?php 
	if ($coffeepowderStatus > 0){
		echo "document.getElementById('coffeepowderSwitch').checked = true;";
	} else {
		echo "document.getElementById('coffeepowderSwitch').checked = false;";
	}
	?>

document.getElementById('coffeepowderSwitch').addEventListener('change', coffeeSwitch, false);
function coffeeSwitch(){
	if(document.getElementById('coffeepowderSwitch').checked){
		console.log("Coffee loaded");
	} else {
		console.log("Coffee not loaded");
	}
}
document.getElementById('autoSwitch').addEventListener('change', coffeePowder, false);

function coffeePowder(){
	xmlHttp = new XMLHttpRequest();
	if(document.getElementById('autoSwitch').checked){
		xmlHttp.open( "GET", "http://localhost/api/?user=<?php echo USER ?>&pass=<?php echo PASS ?>&command=toggleautoswitch", false );
	   console.log("Autoswitch is on");
	 } else {
	 	xmlHttp.open( "GET", "http://localhost/api/?user=<?php echo USER ?>&pass=<?php echo PASS ?>&command=untoggleautoswitch", false );
	   console.log("Autoswitch is off");
	 }
	}
</script>
    

<?php require_once(ROOT_PATH.'/footer.php'); ?>
