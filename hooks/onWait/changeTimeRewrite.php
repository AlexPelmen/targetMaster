<?Php	
	class changeTimeRewrite{
		public function go( $tM ){
			$text = $tM->vk->body;
			$shards = explode( ':', $text );
			if( count( $shards ) < 3 ){
				$tM->output = $tM->replics[ "writeTimeCorrect" ];
				return false;
			}
			$h1 = mb_substr( $shards[0], -2, 2 ); 
			$m1 = mb_substr( $shards[1], 0, 2 ); 
			$h2 = mb_substr( $shards[1], -2, 2 ); 
			$m2 = mb_substr( $shards[2], 0, 2 );
			
			if( !is_numeric( $h1.$m1.$h2.$m2 ) ){
				$tM->output = $tM->replics[ "wrongTime" ];
				return false;
			}
			if( (int)($h1.$m1) >= (int)($h2.$m2) ){
				$tM->output = $tM->replics[ "firstTimeIsMore" ];
				return false;
			}
			$tM->DB->query( "UPDATE `users` SET `sTime` = '$h1:$m1', `eTime` = '$h2:$m2' WHERE `id` = {$tM->vk->uid};" );
			$tM->refreshUserTasks( $tM->vk->uid );
			$tM->output = $tM->replics[ "timeChanged" ];
			return true;
		}		
	}
?>