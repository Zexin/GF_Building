<?php

    error_reporting(E_ALL & ~E_NOTICE);
    require('config.php');

    $con = mysqli_connect($mysql_addr, $mysql_username, $mysql_password, $mysql_dbname);
    if(!$con) die('mysql connect failed.');
    
    foreach ($_GET as $key => $value) 
        if(!ini_get('magic_quotes_gpc')) $$key=addslashes($value); else $$key=$value;
        
    try
    {
        if(!isset($id)) throw new Exception();
        
        $id = intval($id);
        
		/*
        $sql = "SELECT mp, ammo, mre, part, count FROM `gun_report`
                WHERE gunid = $id
                ORDER BY count DESC;";
                    
        $res = mysqli_query($con, $sql);
        if(!$res)
            die("ERROR ". mysqli_error($con));
        
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $total = 0;
        
        if(!is_array($data)) $data = array();
        
		$r = array();
        foreach($data as $row)
        {
            $total += intval($row['count']);    
            $sql = "SELECT count FROM `gun_formula`
                    WHERE mp = ".$row['mp']."
                    AND ammo = ".$row['ammo']."
                    AND mre = ".$row['mre']."
                    AND part = ".$row['part'].";";
            $res = mysqli_query($con, $sql);
            if(!$res)
                die("ERROR ". mysqli_error($con));
			$count = mysqli_fetch_array($res)['count'];
			if($count < $count_min) continue;
            $row['total'] = $count;
			$r[] = $row;
        }
        
		
        $result = array('total' => strval($total), 'res' => $r);
		*/
		
		$sql = "SELECT a.mp, a.ammo, a.mre, a.part, a.count, b.count AS total FROM gun_report AS a, gun_formula AS b 
				WHERE gunid = $id 
				AND a.mp = b.mp AND a.ammo = b.ammo AND a.mre = b.mre AND a.part = b.part 
				AND b.count >= $count_min 
				ORDER BY a.count DESC;";
				
		$res = mysqli_query($con, $sql);
        if(!$res)
            die("ERROR ". mysqli_error($con));
        
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        
        if(!is_array($data)) $data = array();
		
		$result = array('res' => $data);
        echo json_encode($result);
        
    }
    catch(Exception $e)
    {
        die('{"total" : "0", []}');
    }

?>