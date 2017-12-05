<?php
	class VkApi
	{
		public 
			$access_token,
			$bot_id,
			$mid,
			$uid,
			$chat_id,
			$attachment_in,
			$attachment_out,
			
			$test_chat,
			$sleep,
			$spam_num,
			$antigete_key = "";

		function __construct()
		{
			$this->sleep = 1000;
			$this->spam_num = 0;
		}
		
		public function request($method, $params = array())
		{
			usleep($this->sleep);
			$url = 'https://api.vk.com/method/'.$method;
			$params['access_token'] = $this->access_token;
			@$resp = json_decode($this->curl($url.'?'.http_build_query($params)));
			
			if(($resp == null) or isset($resp->error))
			{
				usleep($this->sleep);
				@$resp = json_decode($this->curl($url.'?'.http_build_query($params)));
			}	
			if(isset($resp->error))
			{
				if($resp->error->error_msg == "User authorization failed: invalid access_token (4).") // or $resp->error->error_code == 7
				{
					global $MySQL, $argv;
					$MySQL->set_work($argv[1], 0);
					echo "\n".date('Y-m-d H:i:s')." ".json_encode($resp, JSON_UNESCAPED_UNICODE);
					die();
				}
				elseif($resp->error->error_code == 14) // капча
				{			
					$captcha_sid = $resp->error->captcha_sid;
					$captcha_img = $resp->error->captcha_img;
					$captcha_img = str_replace("\\", "", $captcha_img);
					
					if($this->antigete_key == "")
					{
						
						$unic = uniqid();
						$this->curl("http://botof.net/scripts/captcha/bot_send.php?pass=asdwerhgdf63445&url=".urlencode($captcha_img)."&id=".urlencode($unic)."&bot_id=".urlencode($this->bot_id));

						$captcha_key = "";
						echo "\n".date('Y-m-d H:i:s')." wait captcha";
						while($captcha_key == "")
						{
							$captcha_key = $this->curl("http://botof.net/scripts/captcha/bot_get.php?pass=asdwerhgdf63445&id=".urlencode($unic));
							sleep(5);
						}
						echo "\n".date('Y-m-d H:i:s')." captcha obtained";	
					}
					else
					{
						$unic = uniqid();
						
						@file_put_contents( __DIR__ . "/captcha/$unic".".jpg", file_get_contents($captcha_img));
						@$captcha_key = $this->recognize( __DIR__ . "/captcha/$unic".".jpg", $this->antigete_key, true, "antigate.com");
						@shell_exec("rm ". __DIR__ . "/captcha/$unic".".jpg");
					}
						
					$params['captcha_sid'] = $captcha_sid;
					$params['captcha_key'] = $captcha_key;
					@$resp = json_decode($this->curl($url.'?'.http_build_query($params)));
				}	
			}
			return $resp;
		}
		
		public function test()
		{
			echo "test";
		}
		
		public function messages_get( $time )
		{
			return $this->request("messages.get", array( /*'count' => $count,*/ 'time_offset' => $time ));
		}
		
		public function messages_markAsRead($message_ids)
		{
			return $this->request("messages.markAsRead", array('message_ids' => $message_ids));
		}
		
		public function photos_getMessagesUploadServer()
		{			
			return $this->request("photos.getMessagesUploadServer", array());
		}
		
		public function photos_saveMessagesPhoto($server, $photo, $hash)
		{			
			return $this->request("photos.saveMessagesPhoto", array('server' => $server, 'photo' => $photo, 'hash' => $hash));
		}
		
		public function audio_getUploadServer()
		{
			return $this->request("audio.getUploadServer", array());
		}
		
		public function audio_save($server, $audio, $hash)
		{			
			return $this->request("audio.save", array('server' => $server, 'audio' => $audio, 'hash' => $hash, 'artist' => 'Ботов Нет', 'title' => $this->mid));
		}
		
		public function audio_search($q)
		{			
			return $this->request("audio.search", array('count' => 10, 'auto_complete' => 1, 'sort' => 2, 'q' => $q));
		}
		
		public function audio_get()
		{			
			return $this->request("audio.get", array());
		}
		
		public function video_get()
		{			
			return $this->request("video.get", array());
		}
		
		public function video_search($q)
		{			
			return $this->request("video.search", array('count' => 10, 'adult' => 0, 'sort' => 2, 'q' => $q));
		}
		
		public function get_sex($user_id) // !!!
		{
			$resp = $this->users_get($user_id);
			if($resp == null or $resp == "" or isset($resp->error))
				return false;
			if($resp->response[0]->sex == 1)
				return "f";
			else
				return "m";	
		}
		
		public function account_getAppPermissions()
		{
			return $this->request("account.getAppPermissions");
		}
		
		public function users_get($user_id, $fields = "sex")
		{
			return $this->request("users.get",array('fields' => $fields, 'user_ids' => $user_id));
		}
		
		public function friends_getRequests($out, $count = 1000)
		{
			return $this->request("friends.getRequests", array('out' => $out, 'count' => $count, 'sort' => 0));
		}
		
		public function friends_delete($user_id)
		{
			return $this->request("friends.delete", array('user_id' => $user_id));
		}
		
		public function friends_add($user_id)
		{
			return $this->request("friends.add",array('user_id' => $user_id));
		}
		
		public function friends_editList($user_id, $code = 28)
		{
			return $this->request("friends.editList", array('add_user_ids' => $user_id, 'list_id' => $code));
		}
		
		public function friends_get($count = 1, $list_id = 0, $fields = "")
		{
			return $this->request("friends.get", array('count' => $count, 'v' => '5.44', 'list_id' => $list_id, 'order' => 'random', 'fields' => $fields));
		}
		
		public function get_Followers($count = 1, $list_id = 0)
		{
			return $this->request("users.getFollowers", array('count' => $count, 'v'=>'5.53'));
		}
		
		public function ban_user($user_id)
		{			
			return $this->request("account.banUser", array('user_id' => $user_id));
		}
		
		public function account_setOnline()
		{
			return $this->request("account.setOnline", array());
		}
		
		public function status_set($text)
		{
			return $this->request("status.set", array('text' => $text, 'v' => '5.44'));
		}
		
		public function likes_isLiked($user_id, $item_id, $owner_id = -112128054, $type = "post")
		{			
			return $this->request("likes.isLiked", array('user_id' => $user_id, 'type' => $type, 'owner_id' => $owner_id, 'item_id' => $item_id, 'v' => '5.44'));
		}
		
		public function groups_isMember($group_id, $user_id)
		{			
			return $this->request("groups.isMember", array('group_id' => $group_id, 'user_id' => $user_id));
		}
		
		public function friends_addList($name = "")
		{			
			return $this->request("friends.addList", array('name' => $name));
		}
		
		public function messages_getChat($chat_id, $fields = '', $name_case = '')
		{
			return $this->request("messages.getChat", array('chat_id' => $chat_id, 'fields' => $fields, 'name_case' => $name_case));
		}
		
		public function messages_addChatUser($chat_id, $user_id)
		{
			return $this->request("messages.addChatUser", array('chat_id' => $chat_id, 'user_id' => $user_id));
		}
		
		public function message_send($text = "")
		{
			if($this->test_chat == true)
				$arr_send["chat_id"] = $this->chat_id;
			else
				$arr_send["user_id"] = $this->uid;
			
			if($this->attachment_out != NULL)
				$arr_send["attachment"] = $this->attachment_out;

			$arr_send["message"] = $text;
			
			//$this->messages_markAsRead($this->mid); // Читаем сообщение
			
			$resp = $this->request("messages.send", $arr_send); // Отправляем запросик
			//var_dump($resp);
			if(isset($resp->error))
			{
				$error_code = $resp->error->error_code; 
				if($error_code == 9) // спам ошибка
				{
					$this->spam_num++;
					if($this->spam_num == 3)
						sleep(300);
					if($this->spam_num == 5)
						sleep(18000);
				}
			}	
			else
				$this->spam_num = 0;
		}
		
		public function add_photo($photo)
		{			
			$photo = new CURLFile($photo);
			$upload_url = $this->photos_getMessagesUploadServer()->response->upload_url;
			if($upload_url != false)
			{
				$ch = curl_init($upload_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array('photo' => $photo));
				$result = curl_exec($ch);
				curl_close($ch);
				
				$obj = json_decode($result, true);
				$rq = $this->photos_saveMessagesPhoto($obj["server"], $obj["photo"], $obj["hash"]);
				return $rq->response[0]->id;
			}
		}
		
		public function add_audio($audio)
		{			
			$audio = new CURLFile($audio);
			$upload_url = $this->audio_getUploadServer()->response->upload_url;
			if($upload_url != false)
			{
				$ch = curl_init($upload_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array('file' => $audio));
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
				$result = curl_exec($ch);
				curl_close($ch);
				
				$obj = json_decode($result, true);
				$rq = $this->audio_save($obj["server"], $obj["audio"], $obj["hash"]);
				return $rq->response;
			}
		}
		
		protected function curl($url)
		{
			//echo $url;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$resp = curl_exec($ch);
			if( curl_errno( $ch ) )
				echo "Ошибка курлыка!";
			curl_close($ch);
			return $resp;
		}
		
		public function recognize($filename,$apikey,$is_verbose = true,$domain="antigate.com",$rtimeout = 5,$mtimeout = 50,$is_phrase = 0,$is_regsense = 0,$is_numeric = 0,$min_len = 0,$max_len = 0,$is_russian = 0)
		{
			if (!file_exists($filename))
			{
				if ($is_verbose) echo "file $filename not found\n";
				return false;
			}
			$filename = new CURLFile(($filename));
			$postdata = array(
				'method'    => 'post',
				'key'       => $apikey,
				'file'      => $filename,
				'phrase'	=> $is_phrase,
				'regsense'	=> $is_regsense,
				'numeric'	=> $is_numeric,
				'min_len'	=> $min_len,
				'max_len'	=> $max_len,
			'is_russian'	=> $is_russian

			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://$domain/in.php");
			curl_setopt($ch, CURLOPT_TIMEOUT,60);
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
			$result = curl_exec($ch);
			if (curl_errno($ch))
			{
				if ($is_verbose) echo "CURL returned error: ".curl_error($ch)."\n";
				return false;
			}
			curl_close($ch);
			if (strpos($result, "ERROR")!==false)
			{
				if ($is_verbose) echo "server returned error: $result\n";
				return false;
			}
			else
			{
				$ex = explode("|", $result);
				$captcha_id = $ex[1];
				if ($is_verbose) echo "captcha sent, got captcha ID $captcha_id\n";
				$waittime = 0;
				if ($is_verbose) echo "waiting for $rtimeout seconds\n";
				sleep($rtimeout);
				while(true)
				{
					$result = file_get_contents("http://$domain/res.php?key=".$apikey.'&action=get&id='.$captcha_id);
					if (strpos($result, 'ERROR')!==false)
					{
						if ($is_verbose) echo "server returned error: $result\n";
						return false;
					}
					if ($result=="CAPCHA_NOT_READY")
					{
						if ($is_verbose) echo "captcha is not ready yet\n";
						$waittime += $rtimeout;
						if ($waittime>$mtimeout)
						{
							if ($is_verbose) echo "timelimit ($mtimeout) hit\n";
							break;
						}
						if ($is_verbose) echo "waiting for $rtimeout seconds\n";
						sleep($rtimeout);
					}
					else
					{
						$ex = explode('|', $result);
						if (trim($ex[0])=='OK') return trim($ex[1]);
					}
				}

				return false;
			}
		}	
	}
?>



