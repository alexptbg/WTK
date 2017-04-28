<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$online_ips = array();
$online_serials = array();
$query="SELECT `ip`,`serial` FROM `status` WHERE `dtime` > DATE_SUB(NOW(), INTERVAL 5 MINUTE) GROUP BY `ip`,`serial`";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$online_ips[] = $row['ip'];
			$online_serials[] = $row['serial'];
		}
    }
}
//print_r($online_serials);
if (!empty($online_ips)) {
    $configured_ips = array();
    $i=0;
	foreach($online_ips as $online_ip){
        $query="SELECT `ip` FROM `devices` WHERE `ip`='".$online_ip."' AND NOT `serialnumber`='".$online_serials[$i]."'";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
        } else {
            if($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
			        $configured_ips[] = $row['ip'];
		        }
            }
        }
        $i++;
	}
	//print_r($configured_ips);
	$clocks_not_configured = array_diff($configured_ips,$online_ips);
}
$data = array();
if (!empty($clocks_not_configured)) {
    foreach($clocks_not_configured as $not_configured) {
	    $data[] = $not_configured;
	}
} else {
    $data[] = "0";
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
