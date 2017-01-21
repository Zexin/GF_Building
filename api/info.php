<?php
	chdir('__autoupdate__');
	include('database.php');
	include('config.php');
	
    $con = mysqli_connect($mysql_addr, $mysql_username, $mysql_password, $mysql_dbname);
    if(!$con) die('mysql connect failed.');
	
	echo '{"last_update": '.last_update(-1).', "total_count": '.gun_count(-1).'}';
	
?>