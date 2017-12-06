<?Php
	class test{
		public function go( $tM){
			$uid = $tM->curMessage->uid;
			$res = $tM->DB->query( "SELECT * FROM users WHERE id = uid" );
			$row = mysqli_fetch_array( $res );
			if( ! $row )
				//Первый раз
				$tM->output = $tM->replics[ "Hello" ];
				$tM->DB->query( "INSERT INTO users( id, enabled ) VALUES( $uid, 1 )" );
				$tM->addWaiting( "firstTask", 60 );
			}
		}		
	}
?>