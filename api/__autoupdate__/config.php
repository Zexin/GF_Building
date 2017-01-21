<?php
	//配置文件
	//SQL相关
	include('../config.php');
	
	//账户(服务器地址，用户名,密码)
	$accounts = array(
	'http://s10.gw.gf.ppgame.com/index.php/1010/' => '15662713915,990131',
	'http://s5.gw.gf.ppgame.com/index.php/1005/' => '15016900021,ns987987',
	'http://s2.gw.gf.ppgame.com/index.php/1002/' => '15920299733,bb837837',
	'http://s3.gw.gf.ppgame.com/index.php/1003/' => '18303658463,in807807',
	'http://s4.gw.gf.ppgame.com/index.php/1004/' => '15184238915,uv379379',
	'http://s7.gw.gf.ppgame.com/index.php/1007/' => '1092252114@qq.com,jkjknn',
	'http://s5.ios.gf.ppgame.com/index.php/3005/' => '15662713915,990131'
	);
	
	//最小等待时间
	$min_wait = 15*60;
	
	//数据库设置
	$gun_count = 'gun_count';
	$gun_formula_db = 'gun_formula';
	$gun_report_db = 'gun_report';
	
	$gun_formula_s_db = $gun_formula_db.'_s';
	$gun_report_s_db = $gun_report_db.'_s';
	$gun_count_s = $gun_count.'_s';
	
	//生煎时间
	$s_begin = 1480132800;
	$s_end = 1480305600;
	
	
	
?>