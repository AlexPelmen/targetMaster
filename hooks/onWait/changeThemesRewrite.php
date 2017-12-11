<?Php	
	//explode сразу с несколькими делиметрами
	function multiexplode ($delimiters,$string) {    
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
			
	class changeThemesRewrite{
		public function go( $tM ){
			$text = $tM->vk->body;
			$shards = multiexplode( array( ',', '.', ' ', ';', ':', '/', ')' ), $text );
			$themes = array();
			foreach( $shards as $s )
				if( is_numeric( $s ) )
					array_push( $themes, $s );
			if( ! $themes ){
				$tM->output = $tM->replics[ "writeThemeNumbers" ];
				return false;
			}
				
			//Формирование строк вывода юзеру и записи в бд
			$out = "";
			$todb = "";
			$i = 0;
			$res = $tM->DB->query( "SELECT id, theme FROM themes" );
			while( $row = mysqli_fetch_array( $res ) ){
				$key = array_search( ++$i, $themes );
				if( $key !== false ){
					$out .= $row[ 'theme' ].', ';
					$todb .= $row[ 'id' ].',';
					unset( $themes[ $key ] );
				}
			}
						
			//Вывод сообщения об ошибке
			if( $themes )
				foreach( $themes as $t )
					$tM->output .= "Темы №".$t." нет
						";					
			
			if( ! $todb ){
				$tM->output .= $tM->replics[ "tryAgain" ];
				return false;
			}
			
			$out = substr( $out, 0, -2 );
			$todb = substr( $todb, 0, -1 );
			
			$tM->DB->query( "UPDATE `users` SET `themes` = '$todb' WHERE id = {$tM->vk->uid}" );
			
			$tM->output .= $tM->replics[ "themesAdded" ].' '.$out;					
			return true;
		}		
	}
?>