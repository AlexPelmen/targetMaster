<?Php
	class currentSettings{
		public
			$cmd = array( "настр", "опц" );
		public function go( $tM ){
			$tM->output = $tM->getUserSettings( $tM->vk->uid );			
		}
	}
	
	
?>