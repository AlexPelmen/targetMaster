<?Php
	class react{
		public function go( $tM){
			$uid = $tM->vk->uid;
			$res = $tM->DB->query( "SELECT * FROM users WHERE id = $uid" );
			$row = mysqli_fetch_array( $res );
			
			if( ! $row ){
				//Первый раз
				$tM->output = "Привет, я бот Васян... первый раз тебя вижу. Кароч, я тебе буду установки рассылать в случайное время и бал бла бла куча текста... пошел в жопу)";
				var_dump( $uid );
				$tM->DB->query( "INSERT INTO users( id, enabled ) VALUES( $uid, 1 )" );
				$tM->addWaiting( "firstTask", 60 );
			}
			else{
				//Есть ли ожидания?
				$res = $tM->DB->query( "SELECT * FROM waitings WHERE uid = {$tM->vk->uid}" );
				if( $row = mysqli_fetch_array( $res ) ){
					//Есть ожидания
					$test = $tM->hooks[ "onWait" ][ $row[ 'func' ] ]->go( $tM );
					if( $test === true )
						$tM->deleteWaiting( $row[ 'id' ] );
					else
						$tM->vk->message_send( $test );				
				}
			}			
		}
	}		
	
?>