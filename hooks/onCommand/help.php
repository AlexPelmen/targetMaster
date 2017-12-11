<?Php
	class help{
		public
			$cmd = array( "помощ", "помог" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "help" ];
		}		
	}
?>