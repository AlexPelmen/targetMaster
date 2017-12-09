<?Php
	class help{
		public
			$cmd = "помощь";
		public function go( $tM ){
			$tM->output = $tM->replics[ "help" ];
		}		
	}
?>