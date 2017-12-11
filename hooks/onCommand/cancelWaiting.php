<?Php
	class cancelWaiting{
		public
			$cmd = array( "забудь", "забей", "отста", "отвал", "не хочу", "отъеб", "не над", "отмен" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "cancel" ];
		}		
	}
?>