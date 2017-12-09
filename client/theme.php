<?php
	session_start(); if( ! isset( $_SESSION[ 'valid' ] ) )  exit(); 
	if( $_SESSION[ 'valid' ] != "RelaxMyFriend"  ) exit();
	
	$themes = array();
	$keys = array();
	require "../database.php";
	$DB = link_db();
	$DB->query( "SET NAMES utf8");
	
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
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
			<a href = "addTheme.php" ><input type = "button" name = "addText" id = "addText" value = "Добавить" class = "Btn" /></a>
			<p></p>
			<table class = "OutputTable" >
			<?php //Вывод списка тем
				foreach( $keys as $k )
					echo "
						<tr>
							<td class = 'Column1' >
								<a href = 'lookTheme.php?theme=$k' >
									<div class = 'ListEl ThemeList' >{$themes[ $k ]}</div>
								</a>
							</td>
							<td class = 'Column2' >
								<a href = 'editTheme.php?theme=$k' >
									<div class = 'ListEl EditListBtn' >|</div>
								</a>
							</td>
							<td class = 'Column3' >
								<a href = 'deleteTheme.php?theme=$k' >
									<div class = 'ListEl DeleteListBtn' >X</div>
								</a>
							</td>
						</tr>
					";			
			?>
			</table>
		</form>
    </body>
</html>