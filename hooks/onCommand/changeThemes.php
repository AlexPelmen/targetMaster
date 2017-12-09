<?Php
	class changeThemes{
		public
			$cmd = "выбрать темы";
		public function go( $tM ){
			$tM->output = $replics[ "changeThemes" ];
			$res = $tM->DB->query( "SELECT * FROM themes" );
			while( $row = mysqli_fetch_array( $res ) )
				$tM->output .= $row[ 'id' ].') '.$row[ 'theme' ].'
				';
			$tM->addWaiting( "changeThemesRewrite", 300 );
		}		
	}
?>