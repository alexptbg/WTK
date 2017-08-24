<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_POST)){
	$id = $_POST['id'];
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
	$check_inv = check_id_and_inv($id,$inv);
	$check_ip = check_id_and_ip($id,$ip);
	$check_serial = check_id_and_serial($id,$serialnumber);
	if ( (!empty($inv)) && (!empty($ip)) && (!empty($serialnumber)) && (!empty($building)) && (!empty($floor)) && (!empty($group)) ) {
        $errors = array();
		$i=0;
		if ($check_inv == TRUE) { 
            $errors[$i] = [
                "name" => "err",
                "errnr" => "1210",
                "error" => "Inventory number ".$inv." is already in use."
            ];
            $i++;
		}
		if ($check_ip == TRUE) { 
            $errors[$i] = [
                "name" => "err",
                "errnr" => "1211",
                "error" => "Ip address ".$ip." is already in use."
            ];
            $i++;
		}
		$data = array();
		if (empty($errors)) {
            $sql="UPDATE `devices` SET `inv`='".$inv."',`ip`='".$ip."',`place`='".$place."',`RTU_GRP`='".$RTU_GRP."',`GRP`='".$GRP."',`building`='".$building."',`floor`='".$floor."',`groupnr`='".$group."',`art_no`='".$art_no."',`track`='".$track."',`mounted`='".$mounted."',`mapx`='".$mapx."',`mapy`='".$mapy."' 
                  WHERE `id`='".$id."' AND `serialnumber`='".$serialnumber."'";
 
            if($local->query($sql) === false) {
                trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
            } else {
                $data = [
                    "name" => "data",
                    "msg" => "Updated ".$local->affected_rows." resource."
                ];
                insert_log($user_settings['username'],"warning","Updated the clock settings. (".$inv.")");
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
