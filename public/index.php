<?php
	require_once('../config.php');
    require_once(ROOT_PATH.'/classes/authorization.php');
	$progressSession = getSession(); 
	$page_title = "Coffee";
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
<script>/*
function toggle(){
	if (document.getElementById("switch").checked == true){
		alert("ON!");
		progress();
	} else {
		alert("OFF!");	
	}
}
	function progress(){
		for (var i=0;i<28;i++){

			var value = "";	
					
			if(i < 10){
					$value = "0".i;
				} else {
					$value = i;
			}
			alert(value);
				document.getElementById("coffeepot").src="value";
flush();
		}
	}*/
</script>
	
<div class="row divbg">
			<div class="inDiv">Softwerk Coffee</div>
			
			<div class="inDiv">
				<img id="coffeepot" src="img/coffeepot.png">
			</div>
			
			<div class="inDiv">
					<label class="checkbox toggle ios" style="width:100px"  onclick="">
					<?php if(!isset($_GET['status']) && $progressSession == 0 || (isset($_GET['status']) && $_GET['status'] == "off") || (isset($_GET['status']) && $_GET['status'] == "error")) : ?>
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
				<?php if($_GET['status'] == "error") : ?>
				<label class="checkbox toggle ios error" style="width:100px" >
					<span>
					<span>Error</span>
					</span>
				</label>
			<?php endif ?>
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
						echo $percent.'<->'.$percentreverse;
						if($i == 0){
							//header('location: index.php?status=error');
						}
						echo '<script language="javascript">
						document.getElementById("coffeepot").src="img/coffeepot'.$value.'.png";
						</script>';
						saveSession($i);

						echo str_repeat(' ',1024*64);
						flush();
						sleep(1);
					}
				} if(isset($_GET['status']) && $_GET['status'] == "off") {
					saveSession(0);				
				}
			?>
</div> 

<?php /*GPIO draft 
	$gpio = new GPIO(); 
	$gpio->setup(17, "out"); // Enable control for pin 17
	$gpio->output(17, 1); //Turning on pin 17
	$gpio->output(17, 0); Turn off pin 17
	$gpio->input(17); // Returns false or true if the pin is on or off
	*/

 ?>
    
    
<?php require_once(ROOT_PATH.'/footer.php'); ?>
