<?php 
	$users = "";
	$activeUsers = "";
	$taskStartTime = 0;
	$taskStopTime = 0;
	$taskRange = "";
	$aveTasks = 0;
	$colTasks = 0;
	require "../databesa.php";
	$DB = link_db();
	
	//Получаем всех пользователей
	$res = $DB->query( "SELECT COUNT(*) FROM users" );
	if( $row = mysqli_fetch_array( $res ) )
		$users = $row[0];
	else
		$users = "Никого нет";
	
	//Получаем пользователей с рассылкой
	$res = $DB->query( "SELECT COUNT(*) FROM users WHERE enabled = 1" );
	if( $row = mysqli_fetch_array( $res ) )
		$users = $row[0];
	else
		$users = "Никого нет";
	
	//Получаем средний период рассылки и количество рассылок
	$res = $DB->query( "SELECT sTime, eTime, col FROM users" );
	if( $row = mysqli_fetch_array( $res ) ){
		$taskStartTime = $row[ 'sTime' ];
		$taskStopTime = $row[ 'eTime' ];
		$colTasks += $row[ 'col' ];
		$aveTasks = $row[ 'col' ];
	}
	//Это мы так среднее значение считаем
	while( $row = mysqli_fetch_array( $res ) ){
		$taskStartTime = ( $taskStartTime + $row[ 'sTime' ] ) / 2;
		$taskStopTime = ( $taskStopTime + $row[ 'eTime' ] ) / 2;
		$colTasks += $row[ "col" ];
		$aveTasks = ( $aveTasks + $row[ "col" ] ) / 2;
	}
	$taskRange = date( " С h:i ", $taskStartTime ).date( " до h:i ", $taskStopTime );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "" method = "get" >
			<!--Выводим: общее кол-во юзеров, юзеров с рассылкой, среднее время рассылки, среднее количество рассылок за день, часто подключаемые темы??? -->
			<p class = "Infostring" >Всего пользователей: <?php $colUsers; ?></p>
			<p class = "Infostring" >Активные пользователи: <?php $activeUsers; ?></p>
			<p class = "Infostring" >Период рассылки (в среднем): <?php $taskRange; ?></p>
			<p class = "Infostring" >Количество рассылок за день (в среднем): <?php $aveTasks; ?></p>
			<p class = "Infostring" >Всего рассылок за день: <?php $colTasks; ?></p>
			<input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" />
		</form>
    </body>
</html>