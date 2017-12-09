<?php
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
		
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	if( ! trim( $theme ) ){
		echo "<h2>Дичь какая-то</h2>";
		exit();
	}
	$DB = link_db();
	$DB->query( "SET NAMES utf8" );
	$DB->query( "INSERT INTO themes( theme ) VALUES( '$theme' )" ); 
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "writeNewTheme.php" method = "get" >
			<h2>Записано</h2>
			<a href = "theme.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>