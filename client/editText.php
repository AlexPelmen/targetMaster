<?php 
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$theme = $_GET[ 'id' ];
	$text = $_GET[ 'text' ];
	$output = "";
	if( isset( $_GET[ 'edit' ] ) ){
		$DB->query( "UPDATE texts SET text = '$text' WHERE id = $theme" );	
		$output = "Перезаписано!";
	}
	elseif( isset( $_GET[ 'delete' ] ) ){
		$DB->query( "DELETE FROM texts WHERE id = $theme" );
		$output = "Удалено!";
	}
	else{
		echo( "Что-то не так!" );
		$output = "Какая-то ошибка!";
	}
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head> 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<h2><? $output ?><h2>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Меню" class = "Btn" /></a>
		</form>
    </body>
</html>