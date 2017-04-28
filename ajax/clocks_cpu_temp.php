<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$online_ips = array();
$limit = 65;
$query="SELECT `ip` FROM `status` WHERE `dtime` > DATE_SUB(NOW(), INTERVAL 1 HOUR) GROUP BY `ip`";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$online_ips[] = $row['ip'];
		}
    }
}
//print_r($online_ips);
if (!empty($online_ips)) {
	$cpu_ips = array();
	$cpu_temps = array();
	$cpu_data = array();
    foreach($online_ips as $cpu_ip) {
        $query1="SELECT `cputemp` FROM `status` WHERE (`dtime` >= DATE_SUB(NOW(), INTERVAL 1 HOUR) AND `cputemp` > '".$limit."') AND `ip`='".$cpu_ip."' ORDER BY `cputemp` DESC LIMIT 1";
        $result1=$local->query($query1);
        if($result1 === false) {
            trigger_error('Wrong SQL: '.$query1.' Error: '.$local->error,E_USER_ERROR);
        } else {
            if($result1->num_rows > 0) {
                while($row1 = mysqli_fetch_assoc($result1)) {
			        $cpu_ips[] = $cpu_ip;
			        $cpu_temps[] = $row1['cputemp'];
		        }
            }
        }	
	}
	//$cpu_data = array_combine($cpu_ips,$cpu_temps);
}
$data = array();
if (!empty($cpu_ips)) {
	$i=0;
    foreach($cpu_ips as $cpu_ip) {
        $data[$i] = array($cpu_ip,$cpu_temps[$i]);
        $i++;
	}
} else {
    $data[] = "0";
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
