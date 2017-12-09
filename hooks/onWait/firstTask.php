<?Php	
	class firstTask{
		public function go( $tM ){
			$agreeAnswers = array( 'да','+','ага','ок','окей','хорошо','конечно','угу','хочу', 'д', 'y', 'yes' );
			$denyAnswers = array( 'нет','неа','не','-','не хочу','нит', 'н', 'n', 'no' );
			$text = $tM->vk->body;
			//ответил "да"
			foreach( $agreeAnswers as $a )
				if( trim( mb_strtolower( $text ) ) == $a ){
					$tM->output = $tM->replics[ "firstTask" ];
					$tM->sendTask( $tM->vk->uid );					
					return true;					
				}
			//ответил "нет"
			foreach( $denyAnswers as $a )
				if( trim( mb_strtolower( $text ) ) == $a ){
					$tM->output = $tM->replics[ "sendTaskLater" ];
					return true;					
				}
			$tM->output = $tM->replics[ "writeYesNo" ];
			return false;
		}		
	}
?>