<?php 
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$res = $DB->query( "SELECT id, text FROM texts WHERE theme = $theme" );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Меню" class = "Btn" /></a>
			<?php
				while( $row = mysqli_fetch_array( $res ) ){
					echo "
						<form class = 'ThemeForm' action = 'editText.php?id={$row['id']}' >
							<textarea class = 'Textarea'>{$row['text']}</textarea>
							<input type = 'submit' name = 'edit' value = 'Исправить' class = 'EditBtn' />
						</form>
					";
				}
			?>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Меню" class = "Btn" /></a>
		</form>
    </body>
</html>