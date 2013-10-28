<?php
	require_once('../config.php');
    require_once(ROOT_PATH.'/classes/authorization.php');
	
	$page_title = "Settings";

  if(isset($_GET['autoswitchTime'])){
    saveSession($_GET['autoswitchTime'], 'autoswitchtime'); 
  }
    $autoswitchTime = getSession('autoswitchtime');
	
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>
	<div id="settings-div">
 		<a href="index.php">&larr; Back to Coffee</a>
   	</div>
    <section class="settings divbg">
      <form method="get" action="settings.php">
         Autoswitch: <input type="text" id="autoswitchTime" name="autoswitchTime" value=<?php     echo '"'.$autoswitchTime.'"';    ?>/>
                <button type="submit" class="btn btn-default">Save</button>
                <button href="index.php" class="btn btn-default">Go back</button>
      </form>
      <pre>
# Minute   Hour   Day of Month       Month          Day of Week        Command    
# (0-59)  (0-23)     (1-31)    (1-12 or Jan-Dec)  (0-6 or Sun-Sat)                
    0        2          12             *               0,6           /usr/bin/find<br>

    This cron-example executes the command at 2AM every 12 mounth on Sunday and Saturday.<br>More about Cron: <a href="http://www.pantz.org/software/cron/croninfo.html" target="_blank">http://www.pantz.org/software/cron/croninfo.html</a>
</pre>
<!--<table class="table"> 
  <th>Minute</th>
  <th>Hour</th>
  <th>Day of Month</th>
  <th>Month</th>
  <th>Day of Week</th>
  <th>Command</th>
</thead>
</tbody>
<td>(0-59)</td>
  <td>(0-23)</td>
  <td>(1-31)   </td>
  <td> (1-12)</td>
  <td>(0-6) </td>
  <td></td><tr>
  <td> 0</td>
  <td>18</td>
  <td>12</td>
  <td>10</td>
  <td>0,6,4</td>
  <td>python coffee-on.py</td></tr>-->

</tbody>


                                  
   
        
            
           
           
           
         
         
    	
    	<!--<input type="button" class="btn btn-default" value="Start Timer" onclick="doTimer()" />
   
        <input type="text" id="txt" />
   
        <input type="button" class="btn btn-default" value="Stop Timer" onclick="stopCount()" />
        
        <div id="time-block">
        	<input type="button" class="btn" value="Time" onclick="timeFunction()" />
        	<div id="time">
       		</div>
       	</div>
   		-->
    </section>
<?php require_once(ROOT_PATH.'/footer.php'); ?>