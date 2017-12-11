<?Php
	class sendMe{
		public
			$cmd = array( "установк" );
		public function go( $tM ){
			$tM->sendTask( $tM->vk->uid );
		}		
	}
?>