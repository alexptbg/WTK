<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_POST)){
    $reboot = $_POST['reboot'];
    $confirm = $_POST['confirm'];
	if ( (!empty($reboot)) && ($reboot == "all")  && ($confirm == "YES") ) {
        $query="SELECT `ip` FROM `devices` GROUP BY `ip`";
        $result=$local->query($query);
        $devices_ips = array();
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
        } else {
            if($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
		            $devices_ips[] = $row['ip'];
		        }
            }
        }
        if (!empty($devices_ips)) {
	        foreach($devices_ips as $device_ip){
                $url = "http://".$device_ip."/scripts/reboot.php";
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_URL,$url);
                $result=curl_exec($ch);
                curl_close($ch);
                $resp = json_decode($result,true);
                echo json_encode($resp);
                insert_log($user_settings['username'],"danger","Restarted all the clocks. (DANGER)");
		    }
	    }
	}
} else {
	echo "error-1";
}
?>
