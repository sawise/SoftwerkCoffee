<?php
	require_once('../config.php');
   	require_once(ROOT_PATH.'/classes/authorization.php');
   	$page_title = "Statistics";
   
	$db = new Db();
	$statistics = $db->getStatistics();
	$statspastweek = $db->getStatisticsPastWeek();
	$statspastmonth = $db->getStatisticsPastMonth();
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>

	<section id="mainDiv" class="index divbg">
    
    	<ul class="nav nav-pills">
          <li><a href="index.php">Home</a></li>
          <li><a href="history.php">History</a></li>
          <li class="active"><a href="statistics.php">Statistics</a></li>
        </ul>
        
		<div id="stats-div">
            <table class="table table-bordered">
            	<tr>
                	<td>Coffee consumed this past week:</td>
                    <td><span class="stats-bold"><?php echo count($statspastweek); ?></span> pots</td>
                    <td><span class="stats-bold"><?php echo count($statspastweek)*12; ?></span> cups</td>
                    <td><span class="stats-bold"><?php echo count($statspastweek)*1.5; ?></span> litres</td>
               	</tr>
                <tr>
                	<td>Coffee consumed this past month:</td>
                    <td><span class="stats-bold"><?php echo count($statspastmonth); ?></span> pots</td> 
                    <td><span class="stats-bold"><?php echo count($statspastmonth)*12; ?></span> cups</td> 
                    <td><span class="stats-bold"><?php echo count($statspastmonth)*1.5; ?></span> litres</td>
               	</tr>
                <tr>
                	<td>Total amount of coffee consumed:</td>
                    <td><span class="stats-bold"><?php echo count($statistics); ?></span> pots</td> 
                    <td><span class="stats-bold"><?php echo count($statistics)*12; ?></span> cups</td>
                    <td><span class="stats-bold"><?php echo count($statistics)*1.5; ?></span> litres</td>
               	</tr>
        	</table>
       	</div>
        
	</section> 

<?php require_once(ROOT_PATH.'/footer.php'); ?>