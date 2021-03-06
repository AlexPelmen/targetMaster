<?php
	define( "PATH_TO_HOOKS", __DIR__ . "/hooks/" );
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
			
			//Реплики
			$replics,

			//Вывод
			$output;
			
		
		function __construct(){
			$this->getHooks();
			require __DIR__ . "/database.php";
			$this->DB = link_db();
			$this->DB->query( "SET NAMES utf8" );
			
			require __DIR__ . "/VkApi.php";
			$this->vk = new VkApi;
			$this->vk->access_token = trim( file_get_contents( __DIR__ . "/settings/access_token.txt" ) );
			
			$res = $this->DB->query( "SELECT * FROM replics" );			
			while( $row = mysqli_fetch_array( $res ) )
				$this->replics[ $row[ 'name' ] ] = $row[ 'value' ];
			
		}
 		
		//Получаем названия файлов с хуками
		private function getHooks(){
			//Хуки для каждого сообщения			
			$this->connect( "onMessage" );
			//Хуки для каждой итерации
			$this->connect( "onTimer" );
			//Функции ожиданий
			$hooks = scandir( PATH_TO_HOOKS."onWait" );
			foreach( $hooks as $h ){
				if( $h == "." || $h == ".." ) continue;
				require_once PATH_TO_HOOKS."onWait/".$h;
				$name = substr( $h, 0, -4 );
				$class = new $name;
				$this->hooks[ "onWait" ][ $name ] = $class;
			}	
			//Команды
			$this->connect( "onCommand" );		
		}
		
		//Подключение класса
		private function connect( $str )
		{
			$hooks = scandir( PATH_TO_HOOKS.$str );
			$this->hooks[ $str ] = array();
			foreach( $hooks as $h ){
				if( $h == "." || $h == ".." ) continue;
				require_once PATH_TO_HOOKS."$str/".$h;
				$name = substr( $h, 0, -4 );
				$class = new $name;
				array_push( $this->hooks[ $str ], $class );
			}
		}
		
		//Вечный цикл
		public function start(){
			while( true ){				
				$messages = $this->vk->messages_get( 300 )->response;
				//var_dump($messages );
				$i = 0;
				while( isset( $messages[ ++$i ] ) ){
					$this->getMessageInfo( $messages[ $i ] );
					if( $messages[ $i ]->read_state ) continue;
					$this->output = "";
					
					//Выполняем все хуки для сообщения
					foreach( $this->hooks[ "onMessage" ] as $h ) $h->go( $this );
					//Команда ли?
					$this->checkCommand( mb_strtolower( $this->vk->body ) );
										
					if( ! $this->output ) $this->output = $this->replics[ 'unknownCommand' ];
					if( $this->output ) $this->vk->message_send( $this->output );
				}				
				sleep( $this->interval );
				foreach( $this->hooks[ "onTimer" ] as $h ) $h->go( $this );
			}
		}
		
		//Удаляем ожидания и извещает об этом юзера
		public function resetWaitings(){
			if( $row = $this->getWaiting( $this->vk->uid ) ){
				$this->deleteWaiting( $row[ "id" ] );
				$this->vk->message_send( "Лан... забей!" );	
			}				
		}
		
		//Получаем инфу от сообщения
		public function getMessageInfo( $mess ){
			$this->vk->uid = $mess->uid;
			$this->vk->mid = $mess->mid;
			$this->vk->body = $mess->body;
			if( isset( $mess->chat_id ) ) $this->vk->chat_id = $mess->chat_id;			
		}
		
		//Есть ли такая комманда
		public function checkCommand( $text ){
			$cmdfoos = $this->hooks[ "onCommand" ];
			foreach( $cmdfoos as $f ){
				foreach( $f->cmd as $cmd )
					if( strpos( $text, $cmd ) !== false ){
						$this->resetWaitings();
						$f->go( $this );
						return true;
					}
			}
			return false;
		}
		
		//Проверка на бан
		public function checkBanList( $user ){
			$f = fopen( __DIR__ . "/settings/banList.txt", 'r' );
			while( $b = fgets( $f ) )
				if( $b == $user ) return true;
			return false;
		}
		
		//Добавим юзера в бан-лист
		public function addBan( $user ){
			$f = fopen( __DIR__ . "/settings/banList.txt", 'w+' );
			fputs( $user );
			fclose( $f );
		}
		
		//Добавим ожидание
		public function addWaiting( $func, $time ){
			$insptime = time() + $time;
			$this->DB->query( "INSERT INTO waitings( uid, func, insptime ) VALUES( {$this->vk->uid}, '$func', $insptime )" );
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
			$res = $this->DB->query( "SELECT sTime, eTime, col FROM users WHERE id = $user" );
			if( $row = mysqli_fetch_array( $res ) ){
				$tasks = $this->refreshTasks( $row );
				$this->DB->query( "DELETE FROM tasks WHERE uid = $user" );
				foreach( $tasks as $t )
					$this->DB->query( "INSERT INTO tasks( uid, time ) VALUES( $user, $t )" );					
			}				
		}
		
		//Обновляем время установок для каждого юзера
		public function refreshAllTasks(){
			$res = $this->DB->query( "SELECT id, sTime, eTime, col FROM users WHERE enabled = 1" );
			$this->DB->query( "DELETE FROM tasks" );
			while( $row = mysqli_fetch_array( $res ) ){
				$tasks = $this->refreshTasks( $row );
				foreach( $tasks as $t )
					$this->DB->query( "INSERT INTO tasks( uid, time ) VALUES( {$row[ 'id' ]}, $t )" );				
			}
		}
		
		//Это просто заполнение массивчика случайными моментами времени
		private function refreshTasks( $row ){
			if( $row[ 'col' ] < 1 ) return false;
			if( trim( $row[ 'themes' ] ) == "" ) return false;
			$tasks = array();
			$cur = getdate();
			
			$s = $row[ 'sTime' ];
			$e = $row[ 'eTime' ];
			$col = $row[ 'col' ];
			
			$exp = explode( ':', $s );
			$sh = $exp[0];
			$sm = $exp[1];
			$exp = explode( ':', $e );
			$eh = $exp[0];
			$em = $exp[1];
			
			$sInt = strtotime( $cur[ "mday" ].' '.$cur[ "month" ].' '.$cur[ "year" ].' '.$sh." hours ".$sm." minutes" );
			$eInt = strtotime( $cur[ "mday" ].' '.$cur[ "month" ].' '.$cur[ "year" ].' '.$eh." hours ".$em." minutes" );
						
			for( $i = 0; $i < $col; $i++ ){
				$task = rand( $sInt, $eInt );
				if( $task > time() )
					array_push( $tasks, $task );
			}			
			return $tasks;				
		}
		
		//Отправить задание пользователю
		public function sendTask( $uid ){
			$res = $this->DB->query( "SELECT themes FROM users WHERE id = $uid" );
			if( $row = mysqli_fetch_array( $res ) ){
				$themes = explode( ',', $row[0] );
				$t = rand( 0, count( $themes )- 1);
				$this->output = $this->getTaskText( $themes[ $t ] );
				if( ! $this->output )
					$this->output = "Я хз что тебе прислать...";
			}
			else
				$this->output = $this->replics[ 'noThemes' ];
		}
		
		//Получить случайный текст, соответствующий данной теме
		public function getTaskText( $theme ){
			$res = $this->DB->query( "SELECT text FROM texts WHERE tid = $theme ORDER BY RAND() LIMIT 1" );
			if( $row = mysqli_fetch_array( $res ) )
				return $row[ 0 ];
			return false;			
		}

		//Получаем текст настроек
		public function getUserSettings( $user ){
			$out = $this->replics[ "curSettings" ]."\n";
			$res = $this->DB->query( "SELECT * FROM users WHERE id = $user" );
			if( $row = mysqli_fetch_array( $res ) ){
				$out .= $this->replics[ "settingsCol" ].' '.$row[ 'col' ]."\n";
				$time = 'С '.$row[ 'sTime' ].' до '.$row[ 'eTime' ];
				$out .= $this->replics[ "settingsTime" ].' '.$time."\n";
				$out .= $this->replics[ "settingsThemes" ]."\n";
				
				$exp = explode( ',', $row[ "themes" ] );
				foreach( $exp as $e ){
					$res = $this->DB->query( "SELECT theme from themes WHERE id = $e" );
					if( $row2 = mysqli_fetch_array( $res ) )
						$out .= $row2[0]."\n";
				}
				return $out;
			}
		}		
	}
?>