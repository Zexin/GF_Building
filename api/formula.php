<?php
/*根据公式查找枪的出货记录*/

    error_reporting(E_ALL & ~E_NOTICE);
    require('config.php');

    $con = mysqli_connect($mysql_addr, $mysql_username, $mysql_password, $mysql_dbname);
    if(!$con) die('mysql connect failed.');
    $limit = 100;

    try
    {
        foreach ($_POST as $key => $value) 
            if(!ini_get('magic_quotes_gpc')) $$key=addslashes($value); else $$key=$value;
    
        if(null == $method || !($method == '=' || $method == '>' || $method == '<' || $method == '>=' || $method == '<='))
            $method = '=';
    
        $sql = 'SELECT * FROM `gun_report` WHERE 1';

        if(isset($mp))
        {
            $mp = intval($mp);
            $sql = $sql." AND mp $method $mp";
        }
        
        
        if(isset($ammo))
        {
            $ammo = intval($ammo);
            $sql = $sql." AND ammo $method $ammo";
        }

        if(isset($mre))
        {
            $mre = intval($mre);
            $sql = $sql." AND mre $method $mre";
        }

        if(isset($part))
        {
            $part = intval($part);
            $sql = $sql." AND part $method $part";
        }
        
        
        if(isset($id))
        {
            $id = intval($id);
            $sql = $sql." AND gunid = $id";
        }

        $sql = $sql." LIMIT $limit";

        $res = mysqli_query($con, $sql);

        if(!$res)
            die("ERROR ". mysql_error());
        
        $arr = mysqli_fetch_all($res, MYSQLI_ASSOC);

        echo json_encode($arr);
    }
    catch(Exception $e)
    {
        die('[]');
    }


?>