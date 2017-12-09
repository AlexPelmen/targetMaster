<?php 
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	require '../database.php';
	$DB = link_db();
	$DB->query( 'SET NAMES utf8');
	
	$res = $DB->query( 'SELECT name FROM replics' );			
	while( $row = mysqli_fetch_array( $res ) ){
		$str = $row[ "name" ];
		$text = str_replace( "'", "\\'", $_POST[ $row[ "name" ] ] );
		$DB->query( "UPDATE replics SET value = '$text' WHERE name = '{$row[ "name"]}'" );	
	}
?>

<html> 
    <head>
        <link rel='stylesheet' type='text/css' href='style.css' > 
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>  
    </head>
 
    <body>
		<form id = 'content' action = '' method = 'get' >
			<h2>Записано</h2>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>