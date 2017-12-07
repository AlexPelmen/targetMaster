<?php 

	//Запись токена в файлик
	$token = $_POST[ "token" ];
	if( trim( $token ) == "" ) echo "<h2>Дичь какая-то</h2>";
	$f = fopen( "../settings/access_token.txt", 'w' );
	fputs( $token );
	fclose( $f );	
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<p class = "Infostring" >Текущий access_token: <? $token ?></p>
			<p>Ввести новый:</p>
			<input type = "Text" name = "token" class = "Text" />
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>