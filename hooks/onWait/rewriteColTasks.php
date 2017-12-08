<?Php	
	class rewriteColTasks{
		public function go( $tM ){
			$text = $tM->vk->body;
			if( ! is_numeric( $text ) ){
				$tM->output = "Напиши число!!!";
				return false;
			}
			$tM->DB->query( "UPDATE `users` SET `col` = $text WHERE `id` = {$tM->vk->uid};" );
			$this->refreshUserTasks( $tM->vk->uid );
			$tM->output = "Ок... все поменял";
			return true;
		}		
	}
?>