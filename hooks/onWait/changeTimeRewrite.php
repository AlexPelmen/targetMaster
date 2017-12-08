<?Php	
	class changeTimeRewrite{
		public function go( $tM ){
			$text = $tM->vk->body;
			$shards = explode( ':', $text );
			if( count( $shards ) < 3 ){
				$tM->output = "Напиши как я показал: с hh:mm до hh:mm";
				return false;
			}
			$h1 = mb_substr( $shards[0], -2, 2 ); 
			$m1 = mb_substr( $shards[1], 0, 2 ); 
			$h2 = mb_substr( $shards[1], -2, 2 ); 
			$m2 = mb_substr( $shards[2], 0, 2 );
			
			if( !is_numeric( $h1.$m1.$h2.$m2 ) ){
				$tM->output = "Что-то не так. Я не понимаю";
				return false;
			}
			if( (int)($h1.$m1) >= (int)($h2.$m2) ){
				$tM->output = "Напиши еще раз... смотри, у тебя первое время больше чем второе... это как? Я хз, когда тебе присылать установки";
				return false;
			}
			$tM->DB->query( "UPDATE `users` SET `sTime` = '$h1:$m1', `eTime` = '$h2:$m2' WHERE `id` = {$tM->vk->uid};" );
			$tM->refreshUserTasks( $tM->vk->uid );
			$tM->output = "Все... время поменял";
			return true;
		}		
	}
?>