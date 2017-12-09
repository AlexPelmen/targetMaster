<?php
	require "class.php";
	$bot = new targetMaster;
	$bot->refreshAllTasks();
	$bot->start();
	
?>