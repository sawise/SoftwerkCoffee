<?php
	require_once('../config.php');
    require_once(ROOT_PATH.'/classes/authorization.php');
	
	$page_title = "Settings";
	
	/* Create a file to calculate hash of */
	//file_put_contents('example.txt', 'The quick brown fox jumped over the lazy dog.');
	$user = hash('sha256', 'user');
	
	$file = "example.txt";
	$fh = fopen($file, 'r');
	$data = fread($fh, filesize($file));
	

	//echo hash_file('sha256', 'example.txt');
	
	if($data == $user) {
		echo "true";
	} else {
		echo "false";
	}
	
	fclose($fh);

?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	<div id="settings-div">
 		<a href="index.php">&larr; Back to Coffee</a>
   	</div>
    <section id="settings">
    
    	<input type="button" class="btn btn-default" value="Start Timer" onclick="doTimer()" />
   
        <input type="text" id="txt" />
   
        <input type="button" class="btn btn-default" value="Stop Timer" onclick="stopCount()" />
        
        <div id="time-block">
        	<input type="button" class="btn" value="Time" onclick="timeFunction()" />
        	<div id="time">
       		</div>
       	</div>
   	
    </section>
<?php require_once(ROOT_PATH.'/footer.php'); ?>