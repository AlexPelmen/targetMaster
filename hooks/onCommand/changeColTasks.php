<?Php
	class changeColTasks{
		public
			$cmd = "изменить количество";
		public function go( $tM ){
			$tM->output = $tM->replics[ "colTasks" ];
			$tM->addWaiting( "rewriteColTasks", 60 );
		}		
	}
?>