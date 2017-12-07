<?php 
	$themes = array();
	$keys = array();
	require "../database.php";
	$DB = link_db();
	
	$res = $DB->query( "SELECT * FROM themes" );
	while( $row = mysqli_fetch_array( $res ) ){
		$themes[ $row['id'] ] = $row[ 'theme' ];
		array_push( $keys, $row['id'] );
	}
	
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "" method = "get" >
			<?php //Вывод списка тем
				foreach( $keys as $k )
					echo "<a href = 'lookTheme.php?theme=$k' ><div class = 'ThemeList' >{$theme[ $k ]}</div></a>";					
			?>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>