<?Php
	class changeColTasks{
		public
			$cmd = array( "колич" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "colTasks" ];
			$tM->addWaiting( "rewriteColTasks", 60 );
		}		
	}
?>