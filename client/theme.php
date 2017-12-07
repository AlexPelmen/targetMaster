<?php 
	$themes = array();
	require "../database.php";
	$DB = link_db();
	
	$res = $DB->query( "SELECT theme FROM themes" );
	while( $row = mysqli_fetch_array( $res ) )
		array_push( $themes, $row[0] );
	
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "" method = "get" >
			<?php //Вывод списка тем
				foreach( $themes as $t )
					echo "<a href = 'lookTheme.php?theme=$t' ><div class = 'ThemeList' >$t</div></a>";					
			?>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>