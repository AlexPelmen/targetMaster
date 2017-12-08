<?Php
	class changeColTasks{
		public
			$cmd = "изменить количество";
		public function go( $tM ){
			$tM->output = "Напиши, сколько установок в день ты хочешь получать";
			$tM->addWaiting( "rewriteColTasks", 60 );
		}		
	}
?>