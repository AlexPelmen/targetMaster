<?Php
	class changeTime{
		public
			$cmd = array( "врем" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "changeTime" ];
			$tM->addWaiting( "changeTimeRewrite", 60 );
		}		
	}
?>