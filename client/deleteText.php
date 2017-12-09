<?php 
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	$id = $_GET[ 'id' ];
	$tid = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$DB->query( "DELETE FROM texts WHERE id = $id" );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<h2>Удалено!</h2>
			<a href = "lookTheme.php?theme=<?php echo $tid;?>" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>