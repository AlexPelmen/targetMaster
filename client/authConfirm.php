<?php 
	session_start();
	if( $_POST[ "pswd" ] = "fesH21Jd2K" ){
		$_SESSION[ "valid" ] = "RelaxMyFriend";
		header('Location: botof.net/targetMaster/client/index.php');
	}
	else
		header('Location: botof.net/targetMaster/client/auth.php');
?>
