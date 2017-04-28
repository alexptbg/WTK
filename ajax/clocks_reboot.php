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
	$ip = $_POST['ip'];
    $confirm = $_POST['confirm'];
    
	if ( (!empty($id)) && (!empty($inv)) && (!empty($ip)) && (!empty($confirm)) && ($confirm == "YES") ) {
        $url = "http://".$ip."/scripts/reboot.php";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($result,true);
        //header('Content-Type: application/json; charset=utf-8');
        insert_log($user_settings['username'],"danger","Restarted the clock. (".$inv.")");
        echo json_encode($resp);
	}

} else {
	echo "error-1";
}

?>
