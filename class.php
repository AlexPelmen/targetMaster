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
	}
?>