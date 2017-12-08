<?php 
	$users = "";
	$activeUsers = "";
	$taskStartTime = 0;
	$taskStopTime = 0;
	$taskRange = "";
	$aveTasks = 0;
	$colTasks = 0;
	require "../database.php";
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
		$activeUsers = $row[0];
	else
		$activeUsers = "Никого нет";
	
	//Получаем средний период рассылки и количество рассылок
	$res = $DB->query( "SELECT sTime, eTime, col FROM users" );
	if( $row = mysqli_fetch_array( $res ) ){		
		$taskStartTime = toMinutes( $row[ 'sTime' ]);
		$taskStopTime = toMinutes( $row[ 'eTime' ]);
		$colTasks += $row[ 'col' ];
		$aveTasks = $row[ 'col' ];
	}
	else
		$taskRange = "В БД пусто";
	
	//переводит hh:mm в минуты
	function toMinutes( $str ){
		$expTime = explode( ':', $str );
		return $expTime[0] * 60 + $expTime[1];
	}
	
	//Это мы так среднее значение считаем
	while( $row = mysqli_fetch_array( $res ) ){
		$taskStartTime = ( $taskStartTime + toMinutes( $row[ 'sTime' ] ) ) / 2;
		$taskStopTime = ( $taskStopTime + toMinutes( $row[ 'eTime' ] ) ) / 2;
		$colTasks += $row[ "col" ];
		$aveTasks = ( $aveTasks + $row[ "col" ] ) / 2;
	}
	
	//переводит минуты в hh:mm
	function toStdTime( $min ){
		$h = round( $min / 60 );
		$min = $min % 60;
		if( ! round( $h / 10 ) ) $h = '0'.$h;
		if( ! round( $min / 10 ) ) $min = '0'.$min;
		return $h.':'.$min;
	}
	
	$taskRange = "C ".toStdTime( $taskStartTime )." до ".toStdTime( $taskStopTime );
?>

<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" > 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
    </head>
 
    <body>
		<form id = "content" action = "" method = "get" >
			<!--Выводим: общее кол-во юзеров, юзеров с рассылкой, среднее время рассылки, среднее количество рассылок за день, часто подключаемые темы??? -->
			<p class = "Infostring" >Всего пользователей: <b><?php echo $users; ?></b></p>
			<p class = "Infostring" >Активные пользователи: <b><?php echo $activeUsers; ?></b></p>
			<p class = "Infostring" >Период рассылки (в среднем): <b><?php echo $taskRange; ?></b></p>
			<p class = "Infostring" >Количество рассылок за день (в среднем): <b><?php echo $aveTasks; ?></b></p>
			<p class = "Infostring" >Всего рассылок за день: <b><?php echo $colTasks; ?></b></p>
			<a href = "index.php" ><input type = "button" name = "back" id = "back" value = "Назад" class = "Btn" /></a>
		</form>
    </body>
</html>