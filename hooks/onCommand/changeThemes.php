<?Php
	class changeThemes{
		public
			$cmd = "выбрать темы";
		public function go( $tM ){
			$tM->output = "Вот темы. Напиши номера тем, которые тебе нравятся
			
			";
			$res = $tM->DB->query( "SELECT * FROM themes" );
			while( $row = mysqli_fetch_array( $res ) )
				$tM->output .= $row[ 'id' ].') '.$row[ 'theme' ].'
				';
			$tM->addWaiting( "changeThemesRewrite", 300 );
		}		
	}
?>