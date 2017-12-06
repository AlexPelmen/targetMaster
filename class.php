<?php
	define( "PATH_TO_HOOKS", "hooks/" );
	class targetMaster{
		public
			//Задержка таймера
			$interval = 5,
			
			//Хуки после подгрузки
			$hooks = array( 
				"onMessage" => array(), 
				"onTimer" 	=> array(),
				"onCommand" => array()				
			),
			
			//База данных
			$DB,
			
			//АПИ
			$vk,
			
			//Текущее сообщение
			$curMessage,

			//Вывод
			$output;
			
		
		function __construct(){
			$this->getHooks();
			require "database.php";
			$this->DB = link_db();
			$this->DB->query( "SET NAMES utf8" );
			
			require "VkApi.php";
			$this->vk = new VkApi;
			$this->vk->access_token = trim( file_get_contents( "settings/access_token.txt" ) );
		}
 		
		//Получаем названия файлов с хуками
		private function getHooks(){
			//Хуки для каждого сообщения
			$hooks = scandir( PATH_TO_HOOKS."onMessage" );
			foreach( $hooks as $h ){
				if( $h == "." || $h == ".." ) continue;
				require_once PATH_TO_HOOKS."onMessage/".$h;
				$name = substr( $h, 0, -4 );
				$class = new $name;
				array_push( $this->hooks[ "onMessage" ], $class );
			}
			//Хуки для каждой итерации
			$hooks = scandir( PATH_TO_HOOKS."onTimer" );
			foreach( $hooks as $h ){
				if( $h == "." || $h == ".." ) continue;
				require_once PATH_TO_HOOKS."onTimer/".$h;
				$name = substr( $h, 0, -4 );
				$class = new $name;
				array_push( $this->hooks[ "onTimer" ], $class );
			}
			//Комманды
			$hooks = scandir( PATH_TO_HOOKS."onCommand" );
			foreach( $hooks as $h ){
				if( $h == "." || $h == ".." ) continue;
				require_once PATH_TO_HOOKS."onCommand/".$h;
				$name = substr( $h, 0, -4 );
				$class = new $name;
				$this->hooks[ "onCommand" ][ $h ] = $class;
			}
		}
		
		//Вечный цикл
		public function start(){
			//while( true ){				
				foreach( $this->hooks[ "onTimer" ] as $h ) $h->go( $this );
				$messages = $this->vk->messages_get( 60 )->response;
				//var_dump($messages );
				$i = 0;
				while( isset( $messages[ ++$i ] ) ){
					$this->getMessageInfo( $messages[ $i ] );
					if( $this->checkBanList( $this->vk->uid ) ) continue;
					if( $messages[ $i ]->read_state ) continue;
					$this->output = "";
					foreach( $this->hooks[ "onMessage" ] as $h ) $h->go( $this );
					if( $this->checkCommand( $messages[ $i ]->body ) )
						foreach( $this->hooks[ "onCommand" ] as $h ) $h->go( $this );
					if( $this->output ) $this->vk->message_send( $this->output );
				}		
				//sleep( $this->interval );
			//}
		}
		
		//Получаем инфу от сообщения
		public getMessageInfo( $mess ){
			$this->vk->uid = $mess->user_id;
			$this->vk->mid = $mess->mid;
			$this->vk->body = $mess->body;
			if( isset( $mess->chat_id ) ) $this->vk->chat_id = $mess->chat_id;			
		}
		
		//Есть ли такая комманда
		public function checkCommand( $cmd ){
			$cmds = array_keys( $this->hooks[ "onCommand" ] );
			foreach( $cmds as $c )
				if( $cmd == mb_substr( $c, 0, -4 ) )
					return true;
			return false;
		}
		
		//Выполнение комманды
		public function doCommand( $cmd ){
			$this->hooks[ "onCommand" ][ $cmd ]->go();
		}
		
		//Проверка на бан
		public function checkBanList( $user ){
			$f = fopen( "settings/banList.txt" );
			while( $b = fgets( $f ) )
				if( $b == $user ) return true;
			return false;
		}
		
		//Добавим юзера в бан-лист
		public function addBan( $user ){
			$f = fopen( "settings/banList.txt" );
			fputs( $user );
			fclose( $f );
		}
		
		//Добавим ожидание
		public function addWaiting( $func, $time ){
			$insptime = time() + $time;
			$this->DB->query( "INSERT INTO waitings( uid, func, insptime ) VALUES( {$this->curMessage->uid}, '$func', $insptime )" );
		}
		
		//Получить текущее ожидание пользователя
		public function getWaiting( $uid ){
			$res = $this->DB->query( "SELECT * FROM waitings WHERE uid = $uid" );
			$row = mysqli_fetch_array( $res );
			return $row;
		}
		
		//удалим ожидание
		public function deleteWaiting( $id ){
			$this->DB->query( "DELETE FROM waitings WHERE id = $id" );
		}
		
		//Перепросчитать время для данного юзера
		public function refreshUserTasks( $user ){
			$res = $this->DB->query( "SELECT sTime, eTime, col FROM users WHERE uid = $user" );
			$row = mysqli_fetch_array( $res );
			if( $row ){
				$tasks = $this->refreshTasks( $row );
				foreach( $tasks as $t )
					$this->DB->query( "INSERT INTO tasks( uid, tasks ) VALUES( $user, $t )" );					
			}				
		}
		
		//Обновляем время установок для каждого юзера
		public function refreshAllTasks(){
			$res = $this->DB->query( "SELECT id, sTime, eTime, col FROM users WHERE enabled = 1" );
			while( $row = mysqli_fetch_array( $res ) ){
				$tasks = $this->refreshTasks( $row );
				foreach( $tasks as $t )
					$this->DB->query( "INSERT INTO tasks( uid, tasks ) VALUES( {$row[ 'id' ]}, $t )" );				
			}
		
		//Это просто заполнение массивчика случайными моментами времени
		private function refreshTasks( $row ){			
			$tasks = array();
			$cur = getdate();
			
			$s = $row[ 'sTime' ];
			$e = $row[ 'eTime' ];
			$col = $row[ 'col' ];
			
			$sh = substr( $s, 0, 2 );
			$sm = substr( $s, 3, 2 );
			$eh = substr( $e, 0, 2 );
			$em = substr( $e, 3, 2 );
			
			$sInt = strtotime( $cur[ "mday" ].' '.$cur[ "month" ].' '.$cur[ "year" ].' '.$sh." hours ".$sm." minutes" );
			$eInt = strtotime( $cur[ "mday" ].' '.$cur[ "month" ].' '.$cur[ "year" ].' '.$eh." hours ".$em." minutes" );
			
			for( $i = 0; $i < $col; $i++ )
				array_push( $tasks, rand( $sInt, $eInt ) );
			
			return $tasks;				
		}
		
	}
?>