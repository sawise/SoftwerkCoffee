<?php
	require_once('../config.php');
   //	require_once(ROOT_PATH.'/classes/authorization.php');
   $page_title = "History";
   
	$db = new Db();
	$histories = $db->getHistory();
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>


	<section id="mainDiv" class="index divbg">
		<!--<div class="inDiv"><a href="#" onClick="run()">Softwerk Coffee</a></div>-->
	
		<div class="inDiv">
<table class="table table-striped">
        	<th>Time</a></th>
            <th>User</a></th>
            <th>Action</a></th>
         </thead>
		 <tbody>
            <tr>
		<?php foreach($histories as $history) : ?>
    		<td><?php echo $history->date_time ?></td>
    		<td><?php echo $history->username ?></td>
    		<td><?php echo $history->actionname ?></td></tr>
			<?php endforeach ?>

 			
 		</tbody></table>
        	
		</div>
		

	</section> 


    


<?php require_once(ROOT_PATH.'/footer.php'); ?>
