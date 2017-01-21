<?php

//允许跨域
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,X-Requested-With");

//mysql的相关设定
$mysql_addr = 'localhost';
$mysql_username = MYSQL_USERNAME;
$mysql_password = MYSQL_PASSWORD;
$mysql_dbname = MYSQL_DATABASE;


//数据显示的最小总数目
$count_min = 100;
?>