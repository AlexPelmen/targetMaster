<?php 
	$d = getdate();
	echo strtotime( $d[ "mday" ].' '.$d[ "month" ].' '.$d[ "year" ].' '."12 hours 30 minutes" );
?>