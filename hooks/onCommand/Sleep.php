<?Php
	class Sleep{
		public
			$cmd = array( "усни", "спи", "засни", "заткн", "нах" );
		public function go( $tM ){
			$tM->output = $tM->replics[ 'sleep' ];
			$tM->DB->query( "UPDATE users SET enabled = 0 WHERE id = {$tM->vk->uid}" );
		}		
	}
?>