<?php
	require_once('../config.php');
   	require_once(ROOT_PATH.'/classes/authorization.php');
	
	if(isset($_SESSION['user_id'])) {
		$userid = $_SESSION['user_id'];
		$db = new Db();
		$username = $db->getUser($userid)->username;
		$password = $db->getUser($userid)->password;
		$url = 'api/?user='.$username.'&pass='.$password.'&command=';
	}

	$progressSession = 0; 
	$coffeepowderStatus = 0;
	$coffeeStatus = "Coffee is OFF";
	$autoswitch = 0;
	if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
		$progressSession = getSession('php_session'); 
		echo '<p style="display:none;">'.$progressSession.'</p>';
		echo '<script language="javascript">
					console.log("currentsession: '.$progressSession.'");
				</script>';
	}
	if(file_exists(ROOT_PATH.'/tmp/coffeestatus.txt')){
		$coffeeStatus = getSession('coffeestatus'); 
		echo '<p style="display:none;">'.$coffeeStatus.'</p>';
	}
		if(file_exists(ROOT_PATH.'/tmp/coffeepowderstatus.txt')){
		$coffeepowderStatus = getSession('coffeepowderstatus'); 
		echo '<p style="display:none;">'.$coffeepowderStatus.'</p>';
	}
	if(file_exists(ROOT_PATH.'/tmp/crontab.txt')){
		$autoswitch = getSession('crontab'); 
		echo '<p style="display:none;">'.strlen($autoswitch).'</p>';
	}
	$page_title = "Coffee";
	$error = false;
	$timestart = 0;
	$timeend = 0;
	$timeleft = 0;
		
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>


	<section id="mainDiv" class="index divbg">
    
        <ul class="nav nav-pills nav-fixed-top">
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="history.php">History</a></li>
          <li><a href="statistics.php">Statistics</a></li>
        </ul>
        
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
				<pre id="progress"></pre>
            </div>
			<div class="switch-div">
				<label id="CoffeeswitchDiv" class="checkbox toggle ios" style="width:100px"  onclick="">
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
		

	</section> 

<script>
	<?php 
	 if ($progressSession > 0 && strpos($coffeeStatus,'ON')){
    	echo "document.getElementById('coffeeSwitch').checked = true; coffeeSwitch();";
    } else {
    	//Sam was here
       echo "document.getElementById('coffeeSwitch').checked = false;
       				togglePHP('turnOff', 0);
       				document.getElementById('progress').style.display=\"none\";";
    }
	if ($coffeepowderStatus > 0){
		echo "document.getElementById('coffeepowderSwitch').checked = true;";
	} else {
		echo "document.getElementById('coffeepowderSwitch').checked = false;";
		if($progressSession <= 0){
		echo "document.getElementById('coffeeSwitch').disabled = true;
		document.getElementById('CoffeeswitchDiv').className = \"checkbox toggle iosdisabled\";";
		}
	}
	if(strlen($autoswitch) > 0){
		echo "document.getElementById('autoSwitch').checked = true;";
	} else {
		echo "document.getElementById('autoSwitch').checked = false;";
	}
	?>


document.getElementById('coffeeSwitch').addEventListener('change', coffeeSwitch, false);
function coffeeSwitch(){	
	var session = togglePHP("getSession", 0);
	console.log(session);
		var start = 0;
		var end = 0;
		var timeleft = 0;
		var timeelapsed = 0;
		var progress = 0;
		var timeon = 780;
		var dateunix = Math.round(new Date().getTime()/1000.0);
		if(session <= 0){
			togglePHP("turnOn", 0, "<?php echo $userid ?>");	
				start =  dateunix;
				end =  start+timeon;
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
					percent = percent.toFixed(1);
					var now = Math.round(new Date().getTime()/1000.0);
					var timeleft =  end-now;
					var timeelapsed = timeon-timeleft;
					var minutesLeft = parseInt( timeleft / 60 ) % 60;
					var secondsLeft = secondswithTwochar(timeleft % 60);
					var minutesElapsed = parseInt( timeelapsed / 60 ) % 60;
					var secondsElapsed =  secondswithTwochar(timeelapsed % 60);
					console.log(now);
 					if(document.getElementById('coffeeSwitch').checked && x != timeon){
                        document.getElementById('progress').style.display='';
                        document.getElementById("progressbar").style.height="+"+percent+"%";
                       document.getElementById("progress").innerHTML="<br>"+percent+"%  |  Time left: "+minutesLeft+":"+secondsLeft+"  |  Time elapsed: "+minutesElapsed+":"+secondsElapsed;
                } else if(document.getElementById('coffeeSwitch').checked == false && x < timeon){
                        console.log("Coffee is off");
                        togglePHP("turnOff", 0, "<?php echo $userid ?>");        
                        document.getElementById("progressbar").style.height="0%";
                        document.getElementById("progress").innerHTML="STOPPED!";
                        if(document.getElementById("coffeepowderSwitch").checked == false){
                                document.getElementById("coffeeSwitch").disabled = true;
                                document.getElementById('CoffeeswitchDiv').className = "checkbox toggle iosdisabled";
                        }
                        x = timeon;
				}	else if (x >= timeon && document.getElementById('coffeeSwitch').checked != false){
					document.getElementById("progressbar").style.height="100%";
					document.getElementById("progress").innerHTML="DONE!";
				} 
					//Put errorstatement here
					//document.getElementById("error").style.display = "block";
				x++;
			}}, 1000);
	}

document.getElementById('coffeepowderSwitch').addEventListener('change', coffeepowderSwitch, false);
function coffeepowderSwitch(){
        
        if(document.getElementById('coffeepowderSwitch').checked){
        	togglePHP("toggleCoffeepowder", 0, <?php echo $userid ?>);
                document.getElementById('coffeeSwitch').disabled = false;
                document.getElementById('CoffeeswitchDiv').className = "checkbox toggle ios";
        } else if(document.getElementById('coffeepowderSwitch').checked == false){
        	togglePHP("untoggleCoffeepowder", 0, <?php echo $userid ?>);
                document.getElementById('coffeeSwitch').disabled = true;
                if(document.getElementById('coffeeSwitch').checked == false){
                		document.getElementById('CoffeeswitchDiv').className = "checkbox toggle iosdisabled";
               }
        }
}

document.getElementById('autoSwitch').addEventListener('change', autoSwitch, false);
function autoSwitch(){
	 if(document.getElementById('autoSwitch').checked){
	 	togglePHP("toggleautoswitch", 0, 0);
	 } else {
	 	togglePHP("untoggleautoswitch", 0, 0);
	 }

}
       function togglePHP(command, session, userid){
                xmlHttp = new XMLHttpRequest();
                  xmlHttp.onreadystatechange=function(){
	                  if (xmlHttp.readyState!=4){
								jQuery('#loaderImagee').show();
	                  } else {
	                     jQuery('#loaderImagee').fadeOut(1000);
	                   }
	                }
                if(session > 0){
                        xmlHttp.open( "GET", "<?php echo $url ?>"+command+"&percent="+session, false );
                } else if(userid > 0){
                		xmlHttp.open( "GET", "<?php echo $url ?>"+command+"&u_id="+userid, false );
                } else {
                        xmlHttp.open( "GET", "<?php echo $url ?>"+command, false );
                }

                xmlHttp.send();
                console.log(xmlHttp.responseText);
                return xmlHttp.responseText;
        }

        function secondswithTwochar(value){
        	if(value < 10){
        		value = "0"+value;
        		return value;
        	} else {
        		return value;
        	}
        }

</script>
    


<?php require_once(ROOT_PATH.'/footer.php'); ?>
