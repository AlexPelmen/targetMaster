<?php 
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	$tid = $_GET[ 'tid' ];
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "writeNewText.php" method = "get" >
			<textarea class = "Textarea"  name = "text" id = "text" ></textarea>
			<input type = "submit" name = "addText" id = "addText" value = "Добавить" class = "Btn" />
			<input type = "hidden" name = "tid" value = "<?php echo $tid; ?>" class = "Btn" />
			<a href = "lookTheme.php?theme=<?php echo $tid; ?>" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>