<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');
 
   $url = 'http://localhost/api/?user='.USER.'&pass='.PASS.'&command=';

	$progressSession = 0; 
	$coffeepowderStatus = 0;
	$autoswitch = 0;
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
	if(file_exists(ROOT_PATH.'/tmp/coffeepowderstatus.txt')){
		$autoswitch = getSession('autoswitch'); 
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
				</div><div id="loaderImagee" style="display:none; "><img src="img/pacmanloader.gif"></div>
			</div>
		</div>
		<div class="inDiv">
        	<div id="info-div">
				<span id="error" class="error" style="display:none;">ERROR!</span>
				<span id="progress"></span>
            </div>
			<div class="switch-div">
				<label class="checkbox toggle ios" style="width:100px"  onclick="">
						<input id="coffeeSwitch" type="checkbox">
		

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
			  /*if((isset($_GET['status']) && $_GET['status'] == "on") || ($progressSession > 0 && !isset($_GET['status']))){
               echo  progressBar($progressSession);
              $crontab->exec("sudo python /home/pi/coffee-on.py");
              saveSession('1', 'coffeepowderStatus');
                
                } if(isset($_GET['status']) && $_GET['status'] == "off") {
                 	$crontab->exec("sudo python /home/pi/coffee-off.py");
                    saveSession('0', 'php_session');  
                 }*/
		?>
	</section> 

<script>
	<?php 
	if ($progressSession > 0){
		echo "document.getElementById('coffeeSwitch').checked = true;";
		echo "coffeeSwitch();";
	} else {
		echo "document.getElementById('coffeeSwitch').checked = false;";
	}
	if ($coffeepowderStatus > 0){
		echo "document.getElementById('coffeepowderSwitch').checked = true;";
	} else {
		echo "document.getElementById('coffeepowderSwitch').checked = false;";
	}
	if(strlen($autoswitch) <= 0){
		echo "document.getElementById('autoSwitch').checked = true;";
	} else {
		echo "document.getElementById('autoSwitch').checked = false;";
	}
	?>


document.getElementById('coffeeSwitch').addEventListener('change', coffeeSwitch, false);
function coffeeSwitch(){
	xmlHttp = new XMLHttpRequest();
	var session = 0;
	xmlHttp.open( "GET", "<?php echo $url ?>getSession", false );
	xmlHttp.send( null );
	xmlHttp.onreadystatechange=function()
	  {
	  if (xmlHttp.readyState !=4)
	    {
	    document.getElementById("loaderImagee").style.display="block";
	    } else {
	    		document.getElementById("loaderImagee").style.display="none";
	    }
	  } 
	session = xmlHttp.responseText;
		var start = 0;
		var end = 0;
		var timeleft = 0;
		var timeelapsed = 0;
		var progress = 0;
		var timeon = 600;
		var dateunix = Math.round(new Date().getTime()/1000.0);
		if(session <= 0){
				start =  dateunix;
				end =  start+timeon;
				xmlHttp.open( "GET", "<?php echo $url ?>saveSession&percent="+end, false );
				xmlHttp.send( null );
		}else if (session > dateunix){
				 end =  session;
				 timeleft =  end-dateunix;
				 timeelapsed =  timeon- timeleft;
				 progress = timeelapsed;
		} else if ( session <  dateunix){
				 progress =  timeon;
		}
		
			
			var x = progress; 
			setInterval( function() {
				if (x <= timeon) {
					var percent = x/timeon*100;
					percent = percent.toFixed(2);
					var now = Math.round(new Date().getTime()/1000.0);
					var timeleft =  end-now;
					var timeelapsed = timeon-timeleft;
					if(document.getElementById('coffeeSwitch').checked && x != timeon){
						document.getElementById("progressbar").style.height="+"+percent+"%";
						document.getElementById("progress").innerHTML="<br>"+percent+"% &nbsp;&nbsp;|&nbsp;&nbsp; Time left: "+timeleft+" s &nbsp;&nbsp;|&nbsp;&nbsp; Time elapsed: "+timeelapsed+" s";
					} else if(document.getElementById('coffeeSwitch').checked == false){
						console.log("Coffee is off");
							xmlHttp.open( "GET", "<?php echo $url ?>turnOff", false );
							xmlHttp.send( null );
							while(xmlHttp.readyState!=4){
								 document.getElementById("loaderImagee").style.display="block";
							}				
						  document.getElementById("progressbar").style.height="0%";
							document.getElementById("progress").innerHTML="STOPPED!";
							x = timeon;
				}	else if (x >= timeon && document.getElementById('coffeeSwitch').checked != false){
					document.getElementById("progressbar").style.height="100%";
					document.getElementById("progress").innerHTML="DONE!";
				} 
					//Put errorstatement here
					//document.getElementById("error").style.display = "block";
				x++;
			}}, 1000);
			console.log("Coffee is on");
	}

document.getElementById('coffeepowderSwitch').addEventListener('change', coffeepowderSwitch, false);
function coffeepowderSwitch(){
	xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", "<?php echo $url ?>toggleCoffeepowder", false );
		xmlHttp.send( null );
		console.log(xmlHttp.responseText);

}
document.getElementById('autoSwitch').addEventListener('change', coffeePowder, false);

function coffeePowder(){
	xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", "<?php echo $url ?>toggleautoswitch", false );
		xmlHttp.send( null );
	   console.log(xmlHttp.responseText);
	}
</script>
    


<?php require_once(ROOT_PATH.'/footer.php'); ?>
