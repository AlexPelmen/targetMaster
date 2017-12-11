<?php
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$DB->query( "DELETE FROM texts WHERE tid = $theme" );
	
	$res = $DB->query( "SELECT id, themes FROM users" );
	while( $row = mysqli_fetch_array( $res ) ){
		$id = $row[ 'id' ];
		$themes_str = $row[ 'themes' ];
		$themes_str = str_replace( $theme.',', '', $themes_str );
		$themes_str = str_replace( $theme, '', $themes_str );
		$DB->query( "UPDATE users SET themes = '$themes_str' WHERE id = $id" );
	}
	$DB->query( "DELETE FROM themes WHERE id = $theme" );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<h2>Удалено!</h2>
			<a href = "theme.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>