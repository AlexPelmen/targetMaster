<?Php
	class react{
		public function go( $tM){
			$uid = $tM->vk->uid;
			$res = $tM->DB->query( "SELECT * FROM users WHERE id = $uid" );
			$row = mysqli_fetch_array( $res );
			
			if( ! $row ){
				//Первый раз
				$tM->output = $tM->replics[ 'hello' ]; 
				$res = $tM->DB->query( "SELECT id FROM themes ORDER BY RAND() LIMIT 3" );
				$themes = "";
				while( $row = mysqli_fetch_array( $res ) )
					$themes .= $row[ 0 ].',';
				$themes = substr( $themes, 0, -1 );
					
				$tM->DB->query( "INSERT INTO users( id, enabled, themes ) VALUES( $uid, 1, '$themes' )" );
				$tM->refreshUserTasks( $uid );
				$tM->addWaiting( "firstTask", 60 );
			}
			else{
				//Есть ли ожидания?
				$res = $tM->DB->query( "SELECT * FROM waitings WHERE uid = {$tM->vk->uid}" );
				if( $row = mysqli_fetch_array( $res ) ){
					//Есть ожидания
					$test = $tM->hooks[ "onWait" ][ $row[ 'func' ] ]->go( $tM );
					if( $test )
						$tM->deleteWaiting( $row[ 'id' ] );			
				}
			}			
		}
	}		
	
?>