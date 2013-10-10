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

			<div class="row divbg">
			<div class="inDiv"><a href="#" onClick="run()">Softwerk Coffee</a></div>
			<div class="inDiv">
				<div class="progressbg">
					<img src="img/coffeepot.png" class="imgA1"/>
						<div class="meter">
								<span id="progressbar" style="height: 0%;"></span>
						</div>
				</div>		
			</div>