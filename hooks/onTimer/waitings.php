<?Php
	class waitings{
		public function go( $tM ){
			$now = time();
			$res = $tM->DB->query( "SELECT * FROM waitings WHERE insptime < $now" );
			if( $row = mysqli_fetch_array( $res ) ){
				$tM->sendTask( $row[ 'uid' ] );
				$tM->DB->query( "DELETE FROM tasks WHERE id = {$row["id"]}" );
			}
		}		
	}
?>