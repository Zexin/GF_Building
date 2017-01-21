<?php
	date_default_timezone_set('Etc/GMT-8'); 
	ini_set('default_charset', 'UTF-8');
	
	class AuthCode{
		/*0 --- Encode
		  1 --- Decode
		*/
		
		private static function smethod_0($string_0, $int_0, $int_1)
{
			if($int_0 >= 0)
{
				if($int_0 < 0)
{
					$int_1 *= -1;
					if($int_0 - $int_1 < 0)
{
						$int_1 = $int_0;
						$int_0 = 0;
					}
					else{
						$int_0 -= $int_1;
					}
				}
			    if($int_0 > strlen($string_0))
					return "";
			}
			else{
				if($int_1 < 0 || ($int_1 + $int_0 <= 0)) return "";
				$int_1 += $int_0;
				$int_0 = 0;
			}
			
			if(strlen($string_0) - $int_0 < $int_1)
				$int_1 = strlen($string_0) - $int_0;
			
			return substr($string_0, $int_0, $int_1);
		}
		
		private static function smethod_1($string_0, $int_0)
{
			return AuthCode::smethod_0($string_0, $int_0, strlen($string_0));
		}
		
		private static function smethod_2($byte_0, $int_0)
{
			$array = array();
			
			for($num = 0;$num < $int_0;$num++)
{
				$array[$num] = $num;
			}
			
			$num2 = 0;
			
			for($num3 = 0;$num3 < $int_0;$num3++)
			{
				$num2 = ($num2 + $array[$num3] + $byte_0[$num3 % count($byte_0)]) % $int_0;
				$b = $array[$num3];
				$array[$num3] = $array[$num2];
				$array[$num2] = $b;
			}
			
			return $array;
		}
		
		private static function smethod_3($int_0)
{
			$array = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
			$num = count($array);//62
			$text = "";
			
			for($i = 0;$i < $int_0;$i++)
				$text .= $array[rand(0, $num - 1)];
			
			return $text;
		}
		
		public static function Encode($source, $key)
{
			return AuthCode::smethod_4($source, $key, 0, 3600);
		}
		
		public static function Decode($source, $key)
{
			return AuthCode::smethod_4($source, $key, 1, 3600);
		}

		private static function getBytes($string)
		{
			$result = array();
			for($i = 0;$i < strlen($string);$i++)
				$result[$i] = ord($string[$i]);
			return $result;
		}
		
		private static function smethod_4($string_0, $string_1, $mode, $int_0)
		{
			if(is_null($string_0) || is_null($string_1)) return "";
			$int_ = 0;
			$string_1 = md5($string_1);
			
			$text = md5(AuthCode::smethod_0($string_1, 16, 16));
			$text2 = md5(AuthCode::smethod_0($string_1, 0, 16));
					
			$empty = '';
			$string_2 = $text.md5($text.$empty);
			if($mode != 1)
{
				$string_0 = (($int_0 != 0) ? strval($int_0 + AuthCode::UnixTimestamp()) : "0000000000").AuthCode::smethod_0(md5($string_0.$text2), 0, 16).$string_0;
				$array = AuthCode::smethod_5(AuthCode::getBytes($string_0), $string_2);
				return $empty.base64_encode(AuthCode::ToStr($array));
			}

			
			try
			{
				$byte_ = AuthCode::GetBytes(base64_decode(AuthCode::smethod_1($string_0, $int_)));
			}
			catch(Exception $e)
			{
				try
				{
					$byte_ = AuthCode::GetBytes(base64_decode(AuthCode::smethod_1($string_0.'=', $int_)));
				}
				catch(Exception $e)
				{
					try
					{
						$byte_ = AuthCode::GetBytes(base64_decode(AuthCode::smethod_1($string_0.'==', $int_)));
					}
					catch(Exception $e)
					{
						return '';
					}
					
				}
				return '';
			}
			
			
			$_string = AuthCode::ToStr(AuthCode::smethod_5($byte_, $string_2));
			
			$num = intval(AuthCode::smethod_0($_string, 0, 10));
			if(($num == 0 || $num - AuthCode::UnixTimestamp() > 0) && AuthCode::smethod_0($_string, 10, 16) == AuthCode::smethod_0(md5(AuthCode::smethod_1($_string, 26).$text2), 0, 16));
			{
				return AuthCode::smethod_1($_string, 26);
			}
			
			return '';
			
		}
		
		private static function smethod_5($byte_0, $string_0)
		{
			if(null != $byte_0 && null != $string_0)
			{
				$array2 = AuthCode::smethod_2(AuthCode::GetBytes($string_0), 256);
				$num = 0;
				$num2 = 0;
				for($num3 = 0;$num3 < count($byte_0);$num3++)
				{
					$num = ($num + 1) % count($array2);
					$num2 = ($num2 + $array2[$num]) % count($array2);
					
					$b = $array2[$num];
					$array2[$num] = $array2[$num2];
					$array2[$num2] = $b;
					$b2 = $byte_0[$num3];
					$b3 = $array2[($array2[$num] + $array2[$num2]) % count($array2)];
					$array[$num3] = ($b2 ^ $b3);
			}
				
				return $array;
			}
			
			return null;
			
		}
		
		public static function UnixTimestamp()
		{
			return time();
		}
		
		private static function ToStr($bytes) 
		{ ;
			$str = ''; 
			foreach($bytes as $ch) { 
				$str .= chr($ch); 
			} 
  
           return $str; 
		} 
	}
	
	?>