<?php 
	if( isset( $_SESSION[ 'valid' ] ) )
		if( $_SESSION[ 'valid' ] == "RelaxMyFriend"  )
			header('Location: http://localhost/targetMaster/client/index.php');
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "AuthConfirm" method = "post" >
			<p class = "Infostring" >Вводи пароль:</p>
			<input type = "Password" class = "Text" name = "pswd" id = "pswd" />
			<input type = "Submit" class = "Btn" name = "Ok" id = "Ok" value = "Войти" />
		</form>
    </body>
</html>