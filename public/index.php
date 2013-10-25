

<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');

   $url = 'api/?user='.USER.'&pass='.PASS.'&command=';

	$progressSession = 0; 
	$coffeepowderStatus = 0;
	$coffeeStatus = "Coffee is OFF";
	$autoswitch = 0;
	if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
		$progressSession = getSession('php_session'); 
		echo $progressSession;
		echo '<script language="javascript">
										console.log("currentsession: '.$progressSession.'");
								</script>';
	}
	if(file_exists(ROOT_PATH.'/tmp/coffeestatus.txt')){
		$coffeeStatus = getSession('coffeestatus'); 
		echo $coffeeStatus;
	}
		if(file_exists(ROOT_PATH.'/tmp/coffeepowderstatus.txt')){
		$coffeepowderStatus = getSession('coffeepowderstatus'); 
		echo $coffeepowderStatus;
	}
	if(file_exists(ROOT_PATH.'/tmp/autoswitch.txt')){
		$autoswitch = getSession('autoswitch'); 
		echo strlen($autoswitch);
	}
  
	$page_title = "Coffee";
	$error = false;
	$timestart = 0;
	$timeend = 0;
	$timeleft = 0;
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>


	<section id="mainDiv" class="index divbg">
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
		var timeon = 600;
		var dateunix = Math.round(new Date().getTime()/1000.0);
		if(session <= 0){
			togglePHP("turnOn", 0);	
				start =  dateunix;
				end =  start+timeon;
				 togglePHP("saveSession", end);
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
					console.log(secondsElapsed);
 					if(document.getElementById('coffeeSwitch').checked && x != timeon){
                        document.getElementById('progress').style.display='';
                        document.getElementById("progressbar").style.height="+"+percent+"%";
                       document.getElementById("progress").innerHTML="<br>"+percent+"%  |  Time left: "+minutesLeft+$
                } else if(document.getElementById('coffeeSwitch').checked == false){
                        console.log("Coffee is off");
                        togglePHP("turnOff", 0);        
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
        togglePHP("toggleCoffeepowder", 0);
        if(document.getElementById('coffeepowderSwitch').checked){
                document.getElementById('coffeeSwitch').disabled = false;
                document.getElementById('CoffeeswitchDiv').className = "checkbox toggle ios";
        } else if(document.getElementById('coffeepowderSwitch').checked == false && document.getElementById('coffeeSwitch').checked == false)$
                document.getElementById('coffeeSwitch').disabled = true;
                document.getElementById('CoffeeswitchDiv').className = "checkbox toggle iosdisabled";
        }
}

document.getElementById('autoSwitch').addEventListener('change', coffeePowder, false);

function coffeePowder(){
	togglePHP("toggleautoswitch", 0);

	}

	        function togglePHP(command, session){
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
    


<?php $end = "end"; require_once(ROOT_PATH.'/footer.php'); ?>
