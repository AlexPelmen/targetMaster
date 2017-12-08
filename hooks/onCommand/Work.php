<?Php
	class Work{
		public
			$cmd = "работай";
		public function go( $tM ){
			$tM->output = "Я снова буду присылать тебе установки!";
			$tM->DB->query( "UPDATE users SET enabled = 1 WHERE id = {$tM->vk->uid}" );
		}		
	}
?>