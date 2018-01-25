<?php
	$date1 = new DateTime(date("Y-m-d"));
	$datetime2 = new DateTime('2009-10-13');
	$diff = $date1->diff($datetime2);
	var_dump($diff->days);
?>