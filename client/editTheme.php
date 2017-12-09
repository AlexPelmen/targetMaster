<?php
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$DB->query( "SET NAMES utf8" );
	$res = $DB->query( "SELECT * FROM themes WHERE id = $theme" );
	if( ! $row = mysqli_fetch_array( $res ) ){	 
		echo "<h2>Какая-то дичь</h2>";
		exit();
	}
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = 'rewriteText.php' >
			<a href = "theme.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
			<input type = 'submit' name = 'edit' value = 'Исправить' class = 'Btn' />
			<input type = "hidden" name = "theme" value = "<?php echo $row['id']; ?>" />
			<p></p>
			<input type = "text" class = 'Text' name = 'text' value = "<?php echo $row['theme']; ?>" />
		</form>
    </body>
</html>