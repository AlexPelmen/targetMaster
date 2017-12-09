<?php 
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	require '../database.php';
	$DB = link_db();
	$DB->query( 'SET NAMES utf8');
	
	$res = $DB->query( 'SELECT * FROM replics' );			
	while( $row = mysqli_fetch_array( $res ) ){
		$replics[ $row[ 'name' ] ] = $row[ 'value' ];
		$desc[ $row[ 'name' ] ] = $row[ 'descr' ];
	}
	$keys = array_keys( $replics );	
?>

<html> 
    <head>
        <link rel='stylesheet' type='text/css' href='style.css' > 
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>  
    </head>
 
    <body>
		<form id = 'content' action = 'saveReplics.php' method = 'post' >
			<?php 
				foreach( $keys as $k ){
					echo "<p>{$desc[ $k ]}</p>";
					echo "<textarea class = 'Textarea' name = '$k' >{$replics[ $k ]}</textarea>";
				}
			?>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
			<input type = "submit" name = "save" id = "save" value = "Сохранить" class = "Btn" /></a>			
		</form>
    </body>
</html>