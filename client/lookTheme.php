<?php 
	$theme = $_GET[ 'theme' ];
	require "../database.php";
	$DB = link_db();
	$DB->query( "SET NAMES utf8" );
	$res = $DB->query( "SELECT id, text FROM texts WHERE tid = $theme" );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "changeToken.php" method = "post" >
			<a href = "theme.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
			<a href = "addText.php?tid=<?php echo $theme; ?>" ><input type = "button" name = "addText" id = "addText" value = "Добавить" class = "Btn" /></a>
			
			<p></p>
			<table class = "OutputTable" >
			<?php
				while( $row = mysqli_fetch_array( $res ) ){
					echo "
						<tr>
							<td class = 'Column1' >
								<textarea class = 'Textarea' name = 'text' disabled >{$row['text']}</textarea>
							</td>
							<td class = 'Column3' >
								<a href = 'deleteText.php?id={$row['id']}&theme={$theme}' >
									<div class = 'ListEl DeleteListBtn' >X</div>
								</a>
							</td>
						</tr>
					";
				}
			?>
			</table>
		</form>
    </body>
</html>