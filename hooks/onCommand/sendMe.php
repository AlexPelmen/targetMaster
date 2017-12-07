<?Php
	class sendMe{
		public
			$cmd = "установка";
		public function go( $tM ){
			$tM->sendTask( $tM->vk->uid );
		}		
	}
?>