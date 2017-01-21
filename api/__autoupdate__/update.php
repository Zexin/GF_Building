<?php
	include('config.php');
	include('database.php');
	include('connector.php');
	include_once('helper.php');
	
	echo "开始更新...</br>";
	if(Helper::if_s()) echo "录入生煎特别数据库</br>";
	$time = time();
	$last_time = last_update(-1);
	$gun_c = gun_count(-1);
	
	if($time - $last_time <= $min_wait && !isset($_GET['force'])) die('间隔时间过短，更新停止 '.($time - $last_time));
	foreach($accounts as $server => $account)
	{
		$arr = explode(',', $account);
	    $logindata = Helper::Login($arr[0], $arr[1]);
		
		if(null == $logindata){
			echo "$arr[0]登录失败.</br>";
			continue;
		}
		$con = new Connector($server);
		$con -> Login($logindata['access_token'], $logindata['openid']);
		$j = json_decode($con -> GetDevelopLog());
		
		$count = 0;
		foreach($j -> log_list as $info)
		{
			if(intval($info -> dev_time) > $last_time)
			{
				gun_uploaddata(intval($info -> mp), intval($info -> ammo), intval($info -> mre), intval($info -> part), intval($info -> gun_id));
				$count++;
			}
		}
		
		$gun_c = $gun_c + $count;
		gun_count($gun_c);
		echo '更新成功，共更新'.$count.'条.</br>';
		
	}
	last_update(time());
	


?>