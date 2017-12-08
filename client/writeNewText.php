<?php
	$text = $_GET[ 'text' ];
	$tid = $_GET[ 'tid' ];
	require "../database.php";
	if( ! trim( $text ) ){
		echo "<h2>Дичь какая-то</h2>";
		exit();
	}
	$text = str_replace( "'", "\\'", $text );
	$DB = link_db();
	$DB->query( "SET NAMES utf8" );
	$DB->query( "INSERT INTO texts( tid, text ) VALUES( $tid, '$text' )" ); 
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "writeNewTheme.php" method = "get" >
			<h2>Записано</h2>
			<a href = "lookTheme.php?theme=<?php echo $tid; ?>" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>