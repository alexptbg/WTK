<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_POST)){
	$inv = $_POST['inv'];
	$place = $_POST['place'];
	$ip = $_POST['ip'];
	$serialnumber = $_POST['serialnumber'];
	$RTU_GRP = $_POST['RTU_GRP'];
	$GRP = $_POST['GRP'];
	$building = $_POST['building'];
	$floor = $_POST['floor'];
	$group = $_POST['groupnr'];
	$art_no = $_POST['art_no'];
	$track = $_POST['track'];
	$mounted = $_POST['mounted'];
	$mapx = $_POST['mapx'];
	$mapy = $_POST['mapy'];
	$check_inv = check_inv($inv);
	$check_serial = check_serial($serialnumber);
	$check_ip = check_ip($ip);	
	if ( (!empty($inv)) && (!empty($ip)) && (!empty($serialnumber)) && (!empty($RTU_GRP)) && (!empty($GRP)) && (!empty($building)) && (!empty($floor)) && (!empty($group)) ) {
		$errors = array();
		$i=0;
		if ($check_inv == TRUE) { 
            $errors[$i] = [
                "name" => "err",
                "errnr" => "1210",
                "error" => "Inventory number ".$inv." already exists in the database."
            ];
            $i++;
		}
		if ($check_ip == TRUE) { 
            $errors[$i] = [
                "name" => "err",
                "errnr" => "1211",
                "error" => "Ip address ".$ip." already exists in the database."
            ];
            $i++;
		}
		if ($check_serial == TRUE) { 
            $errors[$i] = [
                "name" => "err",
                "errnr" => "1212",
                "error" => "Serial number ".$serialnumber." already exists in the database."
            ];
            $i++;
		}
		$data = array();
		if (empty($errors)) {
            $sql="INSERT INTO `devices` (inv,ip,`place`,serialnumber,RTU_GRP,GRP,building,floor,groupnr,art_no,track,mounted,mapx,mapy) 
                  VALUES ('".$inv."','".$ip."','".$place."','".$serialnumber."','".$RTU_GRP."','".$GRP."','".$building."','".$floor."','".$group."','".$art_no."','".$track."','".$mounted."','".$mapx."','".$mapy."')";
 
            if($local->query($sql) === false) {
                trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
            } else {
                $data = [
                    "name" => "data",
                    "msg" => "Inserted resource id ".$local->insert_id
                ];
                insert_log($user_settings['username'],"success","Inserted a new clock in the database. (".$inv.")");
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            }
		} else {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($errors);
		}
	}
} else {
	echo "error-1";
}
?>
