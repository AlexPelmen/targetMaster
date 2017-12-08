<?Php
	class checkTasks{
		public function go( $tM ){
			//Ночью пересчитываем юзеров
			$now = time();
			$d = getdate();
			$tonight = $now - $d['hours']*3600 - $d['minutes']*60;
			if( $now > $tonight && $now < $tonight + $tM->interval )
				$tM->refreshAllTasks();
			
			//отработка заданий
			$res = $tM->DB->query( "SELECT enabled FROM users WHERE id = {$tM->vk->uid}" );
			@$row = mysqli_fetch_array( $res );
			if( $row[0] ){
				$res = $tM->DB->query( "SELECT * FROM tasks WHERE time < $now" );
				if( $row = mysqli_fetch_array( $res ) ){
					$tM->sendTask( $row[ 'uid' ] );
					$tM->DB->query( "DELETE FROM tasks WHERE id = {$row["id"]}" );
				}
			}
		}		
	}
?>