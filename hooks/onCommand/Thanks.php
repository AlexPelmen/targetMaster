<?Php
	class Thanks{
		public
			$cmd = array( "спасиб" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "Thanks" ];
		}		
	}
?>