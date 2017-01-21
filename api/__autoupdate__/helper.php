<?php
	
	class Helper
	{
		public static function Login($username, $password)//return token
		{
			//http://gf.ppgame.com/interfaces
			$data = array('method' => 'findByEn', 'ifs_en' => 'account_login', 'login_identify' => $username, 'login_pwd' => md5($password), 'app_id' => '0002000100021001', 'encrypt_mode' => 'md5', 'openid' => '', 'sign' => '', 'client_ip' => '');
			$headers = array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 'Accept: application/json, text/javascript, */*; q=0.01', 'Connection: keep-alive');
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, 'http://gf.ppgame.com/interfaces');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$output = curl_exec($ch);
			curl_close($ch);
			
			$output = json_decode($output);
			if(isset($output -> access_token) && isset($output -> openid))
			{
				$result = array('access_token' => $output -> access_token, 'openid' => $output -> openid);
				return $result;
			}
			else
			{
				return null;
			}

			
		}
		
		public static function if_s()
		{
				include('config.php');
				return (time() >= $s_begin) && (time() <= $s_end);
		}

	}

?>