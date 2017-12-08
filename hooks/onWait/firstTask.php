<?Php	
	class firstTask{
		public function go( $tM ){
			$agreeAnswers = array( 'да','+','ага','ок','окей','хорошо','конечно','угу','хочу', 'д', 'y', 'yes' );
			$denyAnswers = array( 'нет','неа','не','-','не хочу','нит', 'н', 'n', 'no' );
			$text = $tM->vk->body;
			//ответил "да"
			foreach( $agreeAnswers as $a )
				if( trim( mb_strtolower( $text ) ) == $a ){
					$tM->output = "Вот твоя первая установка:";
					$tM->sendTask( $tM->vk->uid );					
					return true;					
				}
			//ответил "нет"
			foreach( $denyAnswers as $a )
				if( trim( mb_strtolower( $text ) ) == $a ){
					$tM->output = "Окей, я пришлю тебе установку чуть позже";
					return true;					
				}
			$tM->output = "ммм... не понял. Напиши да/нет";
			return false;
		}		
	}
?>