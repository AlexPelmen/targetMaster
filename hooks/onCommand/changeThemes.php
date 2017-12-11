<?Php
	class changeThemes{
		public
			$cmd = array( "темы", "тема", "тему", "теме", "темой" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "changeThemes" ];
			$res = $tM->DB->query( "SELECT * FROM themes" );
			$i = 0;
			while( $row = mysqli_fetch_array( $res ) )
				$tM->output .= ++$i.') '.$row[ 'theme' ].'
				';
			$tM->addWaiting( "changeThemesRewrite", 300 );
		}		
	}
?>