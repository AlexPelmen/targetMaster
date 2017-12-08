<?php 
	$token = trim( file_get_contents( "../settings/access_token.txt" ) );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<p class = "Infostring" >Текущий access_token: <b><?php echo $token ?></b></p>
			<p class = "Infostring" >Ввести новый:</p>
			<input type = "Text" name = "token" class = "Text" />
			<input type = "submit" name = "ok" value = "Изменить" class = "Btn" />
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>