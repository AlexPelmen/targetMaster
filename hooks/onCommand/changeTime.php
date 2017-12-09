<?Php
	class changeTime{
		public
			$cmd = "изменить время";
		public function go( $tM ){
			$tM->output = $tM->replics[ "changeTime" ];
			$tM->addWaiting( "changeTimeRewrite", 60 );
		}		
	}
?>