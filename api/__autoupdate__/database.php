<?php


function last_update($set)
{
	include('config.php');
	
	$con = mysqli_connect($mysql_addr, $mysql_username, $mysql_password, $mysql_dbname);
    if(!$con) return False;
	
	if($set < 0)
		$sql = "SELECT valuei FROM `info` WHERE `key` = 'last_update';";
	else
		$sql = "UPDATE info SET valuei = $set WHERE `key` = 'last_update';";
	
	$r = mysqli_query($con, $sql);
	
	if(!$r)
        return mysqli_error($con);
	
	if($set >= 0) return True;
	
	$arr = mysqli_fetch_all($r, MYSQLI_ASSOC);
	
	return intval($arr[0]['valuei']);
}

function gun_count($set)
{
	include('config.php');
	include_once('helper.php');
	
	$gc = Helper::if_s() ? $gun_count_s : $gun_count;
	
	$con = mysqli_connect($mysql_addr, $mysql_username, $mysql_password, $mysql_dbname);
    if(!$con) return False;
	
	if($set < 0)
		$sql = "SELECT valuei FROM `info` WHERE `key` = '".$gc."';";
	else
		$sql = "UPDATE info SET valuei = $set WHERE `key` = '".$gc."';";
	
	$r = mysqli_query($con, $sql);
	
	if(!$r)
        return mysqli_error($con);
	
	if($set >= 0) return True;
	
	$arr = mysqli_fetch_all($r, MYSQLI_ASSOC);
	
	return intval($arr[0]['valuei']);
}

function gun_uploaddata($mp, $ammo, $mre, $part, $gunid)
{
    //error_reporting(E_ALL & ~E_NOTICE);
	include('config.php');
	include_once('helper.php');
	
	$gr = Helper::if_s() ? $gun_report_s_db : $gun_report_db;
	$gf = Helper::if_s() ? $gun_formula_s_db : $gun_formula_db;

    $con = mysqli_connect($mysql_addr, $mysql_username, $mysql_password, $mysql_dbname);
    if(!$con) return False;
	
    try
    {

        if(null == $mp || null == $mre || null == $ammo || null == $part || null == $gunid)    
            throw new Exception();//参数检查
        
        
        //检查资源是否合理
        if(!(($mp >= 30 && $mp <= 999) && ($mre >= 30 && $mre <= 999) && ($ammo >= 30 && $ammo <= 999) && ($part >= 30 && $part <= 999))) throw new Exception();

        $sql = "INSERT INTO $gr(
                    mp,
                    ammo,
                    mre,
                    part,
					gunid,
                    count
                ) VALUES ( 
                    $mp,
                    $ammo,
                    $mre,
                    $part,
					$gunid,
                    1
                ) ON DUPLICATE KEY UPDATE count = count + 1";
        
        if(!mysqli_query($con, $sql))
            return False;
        
		$sql = "INSERT INTO $gf(
                    mp,
                    ammo,
                    mre,
                    part,
                    count
                ) VALUES ( 
                    $mp,
                    $ammo,
                    $mre,
                    $part,
                    1
                ) ON DUPLICATE KEY UPDATE count = count + 1";
        
        if(!mysqli_query($con, $sql))
            return False;
			//die("ERROR4 ". mysqli_error($con));
        
        return True;
            
    }
    catch(Exception $e)
    {
        return False;
    }
}
?>