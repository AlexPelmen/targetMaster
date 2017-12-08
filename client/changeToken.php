<?php 

	//Запись токена в файлик
	$token = $_POST[ "token" ];
	if( trim( $token ) == "" ){ 
		echo "<h2>Дичь какая-то</h2>";
		exit();
	}
	$f = fopen( "../settings/access_token.txt", 'w' );
	fputs( $f, $token );
	fclose( $f );	
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<h2>Записано</h2>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>