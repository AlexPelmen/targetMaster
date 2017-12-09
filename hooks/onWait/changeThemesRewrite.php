<?Php	
	class changeThemesRewrite{
		public function go( $tM ){
			
			//explode сразу с несколькими делиметрами
			function multiexplode ($delimiters,$string) {    
				$ready = str_replace($delimiters, $delimiters[0], $string);
				$launch = explode($delimiters[0], $ready);
				return  $launch;
			}

			$text = $tM->vk->body;
			$shards = multiexplode( array( ',', '.', ' ', ';', ':', '/' ), $text );
			$themes = array();
			foreach( $shards as $s )
				if( is_numeric( $s ) )
					array_push( $themes, $s );
			if( ! $themes ){
				$tM->output = $tM->replics[ "writeThemeNumbers" ];
				return false;
			}
						
			$out = "";
			$todb = "";
			foreach( $themes as $t ){
				$res = $tM->DB->query( "SELECT theme FROM themes WHERE id = $t" );
				if( $row = mysqli_fetch_array( $res ) ){
					$out .= $row[ 'theme' ].', ';
					$todb .= $t.',';
				}
				else
					$tM->output .= "Темы №".$t." нет
				";
			}
			
			if( ! $todb ){
				$tM->output .= $tM->replics[ "tryAgain" ];
				return false;
			}
			
			$out = substr( $out, 0, -2 );
			$todb = substr( $todb, 0, -1 );
			
			$tM->output .= $tM->replics[ "themesAdded" ].$out;			
			
			$tM->DB->query( "UPDATE `users` SET `themes` = '$todb'" );			
			return true;
		}		
	}
?>