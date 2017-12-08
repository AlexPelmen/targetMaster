<?Php
	class changeTime{
		public
			$cmd = "изменить время";
		public function go( $tM ){
			$tM->output = "Оке... напиши, в какое время тебе удобней всего получать установки.
			Типа такого: С 12:00 до 23:00. Двоеточие обязательно пиши!";
			$tM->addWaiting( "changeTimeRewrite", 60 );
		}		
	}
?>