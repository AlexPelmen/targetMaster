<?php
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "writeNewTheme.php" method = "get" >
			<input type = "text" name = "theme" id = "theme"  class = "Text" />
			<input type = "submit" name = "addText" id = "addText" value = "Добавить" class = "Btn" />
			<a href = "theme.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>