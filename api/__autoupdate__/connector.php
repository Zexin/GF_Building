<?php
	require_once("authcode.php");
	
	class Connector
	{
		var $addr, $sign, $req_id, $uid;
		function __construct($server_addr)
		{
			$this -> addr = $server_addr;
			$this -> req_id = intval(strtotime("now"));
		}
		
		public function Login($token, $openid)
		{
			//androidid=a912a2bbe60cbd85&mac=04%3a02%3a1f%3aca%3aa4%3ad1
			$url = $this -> addr."Index/getDigitalSkyNbUid";
			$data = array(
			'openid' => $openid,
			'access_token' => $token,
			'app_id' => '0002000100021001',
			'channelid' => 'GWGW',
			'idfa' => '',
			'androidid' => 'a912a2bbe60cbd85',
			'mac' => '04:02:1f:ca:a4:d1');
			
			$r = $this -> curl_post($url, $data);

			try
			{
				$json = json_decode(AuthCode::Decode($r, 'yundoudou'));
				$this -> sign = $json -> sign;
				$this -> uid = $json -> uid;
				return True;
			}
			catch(Exception $e)
			{
				return False;
			}

		}
		
		public function GetDevelopLog()
		{
			if(null == $this -> uid || null == $this -> sign) return null;
			
			//RawClientData: uid=33606&signcode=GvS6ZQWSjAWo1hXkB8rL0%2f9cU3N33azrEGMIHkF%2bGkYlHSXGcvMRqKGtJGsToQQ%2fr0n6CHzXw8m2dA%3d%3d&req_id=1477824632
			$url = $this -> addr.'Gun/developLog';
			$data = array(
			'uid' => $this -> uid,
			'signcode' => AuthCode::Encode($this -> sign, $this -> sign));
			
			$data = $this -> curl_post($url, $data);
			$data = AuthCode::Decode($data, $this -> sign);
			return $data;
			
		}
		
		private function curl_post($url, $data)
		{
			$data['req_id'] = strval($this -> req_id);
			$this -> req_id++;
			$headers = array('User-Agent: Dalvik/2.1.0 (Linux; U; Android 6.0.1; HUAWEI RIO-AL00 Build/HuaweiRIO-AL00)', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 'Accept-Encoding: gzip', 'X-Unity-Version: 5.2.5f1');
			$ch = curl_init();
			
			//curl_setopt($ch, CURLOPT_PROXY, 'http://127.0.0.1:8888');
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}

	}
	
	/*
	$con = new Connector('http://s10.gw.gf.ppgame.com/index.php/1010/');
	require("helper.php");
	$info = Helper::Login('15662713915', '990131');

	echo $con -> Login($info['access_token'], $info['openid']);
	echo $con -> GetDevelopLog();
	*/
?>