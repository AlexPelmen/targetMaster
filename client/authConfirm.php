<?php 
	session_start();
	if( $_POST[ "pswd" ] = "fesH21Jd2K" ){
		$_SESSION[ "valid" ] = "RelaxMyFriend";
		header('Location: http://localhost/targetMaster/client/index.php');
	}
	else
		header('Location: http://localhost/targetMaster/client/auth.php');
?>
