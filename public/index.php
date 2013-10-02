<?php
	require_once('../config.php');
   require_once(ROOT_PATH.'/classes/authorization.php');
	$progressSession = 0; 
	if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
		$progressSession = getSession(); 
	}
	
	$page_title = "Coffee";
	$error = false;
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	
	    <?php //TESTING
	    			/*echo json_encode(array('pheeds' => $pheeds, 'res' => $res));

					$request = new RestRequest1('http://example.com/api/user/1', 'GET');
					$request->execute();

					echo '<pre>' . print_r($request, true) . '</pre>';*/

						/*$data = RestUtils::processRequest();
					switch($data->getMethod) {
							// this is a request for all users, not one in particular
							case 'get':
								$user_list = getUserList(); // assume this returns an array

								if($data->getHttpAccept == 'json')
								{
									RestUtils::sendResponse(200, json_encode($user_list), 'application/json');
								}
								else if ($data->getHttpAccept == 'xml')
								{
									// using the XML_SERIALIZER Pear Package
									$options = array
									(
										'indent' => '     ',
										'addDecl' => false,
										'rootName' => $fc->getAction(),
										XML_SERIALIZER_OPTION_RETURN_RESULT => true
									);
									$serializer = new XML_Serializer($options);

									RestUtils::sendResponse(200, $serializer->serialize($user_list), 'application/xml');
								}

								break;
							// new user create
							case 'post':
								$user = new User();
								$user->setFirstName($data->getData()->first_name);  // just for example, this should be done cleaner
								// and so on...
								$user->save();

								// just send the new ID as the body
								RestUtils::sendResponse(201, $user->getId());
								break;
						}*/?>
<div class="row divbg">
			<div class="inDiv">Softwerk Coffee</div>
			
			<div class="inDiv">
				<img id="coffeepot" src="img/coffeepot.png">
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
					$total = 28;
					$progress = 0;
					if ($progressSession > 0){
						$progress = $progressSession;
						saveSession(0);
					}
					
					for($i=$progress; $i<=$total; $i++){
						$percent = intval($i/$total * 100)."%";
						$percentreverse = intval(100/$total*$i )."%";
						$value = "";					
						if($i < 10){
							$value = "0".$i;
						} else {
							$value = $i;
						}

						 if($i == 29 /*$gpioTurnon == false*/){ // Returns false or true if the pin is on or off 
								//header('location: index.php?status=error');
								echo '<script language="javascript">
							document.getElementById("error").style.display = "block";
							</script>';
							$error = true;
							i == 28; // Stopping the loop
						}

						if(!$error) {
								echo '<script language="javascript">
							document.getElementById("progress").innerHTML="'.$percent.'";
							</script>';
							echo '<script language="javascript">
							document.getElementById("coffeepot").src="img/coffeepot'.$value.'.png";
							</script>';
							saveSession($i);
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
					saveSession(0);				
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
