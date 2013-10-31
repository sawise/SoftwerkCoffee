<?php
	require_once('../config.php');
   	//require_once(ROOT_PATH.'/classes/authorization.php');
   	$page_title = "Statistics";
   
	$db = new Db();
	$statistics = $db->getStatistics();
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>

	<section id="mainDiv" class="index divbg">
		<div>
        	<p class="stats_p">Total amount of coffee consumed: <span class="stats_bold"><?php echo count($statistics); ?></span> pots / <span class="stats_bold"><?php echo count($statistics)*12; ?></span> cups / <span class="stats_bold"><?php echo count($statistics)*1.5; ?></span> litres.</p>
       	</div>
	</section> 

<?php require_once(ROOT_PATH.'/footer.php'); ?>