<?php
	require_once('../config.php');
   //	require_once(ROOT_PATH.'/classes/authorization.php');
	
?>
<?php //require_once(ROOT_PATH.'/header.php'); ?>


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
			<?php 
			for ($i = 1; $i <= 10; $i++) {
    		echo '<td></td>';
    		echo '<td></td>';
    		echo '<td></td></tr>';
			}
?>
 			
 		</tbody></table>
        	
		</div>
		

	</section> 


    


<?php require_once(ROOT_PATH.'/footer.php'); ?>
