<?Php
	class Sleep{
		public
			$cmd = "усни";
		public function go( $tM ){
			$tM->output = "Напиши 'работай', когда захочешь снова получать установки";
			$tM->DB->query( "UPDATE users SET enabled = 0 WHERE id = {$tM->vk->uid}" );
		}		
	}
?>