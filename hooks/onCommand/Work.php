<?Php
	class Work{
		public
			$cmd = array( "работ" );
		public function go( $tM ){
			$tM->output = $tM->replics[ "wakeUp" ];
			$tM->DB->query( "UPDATE users SET enabled = 1 WHERE id = {$tM->vk->uid}" );
		}		
	}
?>