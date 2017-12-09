<?Php
	class waitings{
		public function go( $tM ){
			//Выгоревшие ожидания
			$now = time();
			$res = $tM->DB->query( "SELECT * FROM waitings WHERE insptime < $now" );
			if( $row = mysqli_fetch_array( $res ) ){
				$tM->vk->uid = $row[ 'uid' ];
				$tM->vk->message_send( $tM->replics[ "takeItEasy" ] );
				$tM->deleteWaiting( $row[ 'id' ] );				
			}
		}		
	}
?>