<?Php	
	class rewriteColTasks{
		public function go( $tM ){
			$text = $tM->vk->body;
			if( ! is_numeric( $text ) ){
				$tM->output = $tM->replics[ "writeNumber" ];
				return false;
			}
			$tM->DB->query( "UPDATE `users` SET `col` = $text WHERE `id` = {$tM->vk->uid};" );
			$this->refreshUserTasks( $tM->vk->uid );
			$tM->output = $tM->replics[ "colChanged" ];
			return true;
		}		
	}
?>