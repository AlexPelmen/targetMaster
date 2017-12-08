<?php 
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$DB->query( "DELETE FROM texts WHERE tid = $theme" );	
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