<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$devices = array();
$query="SELECT * FROM `devices` WHERE `track`='1' ORDER BY `inv` ASC";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$devices[] = $row;
		}
    }
}
if(!empty($devices)){
	$clocks_not_online = array();
    foreach($devices as $device) {
        $query="SELECT * FROM `clock_logs` WHERE `datetime` > DATE_SUB(NOW(), INTERVAL 60 SECOND) AND `ip`='".$device['ip']."' AND `action`='Device is not working.'
        ORDER BY `id` DESC";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);	
        } else {
            if($result->num_rows >= 1) {
                while($row = mysqli_fetch_assoc($result)) {
                    $clocks_not_online[] = $row['ip'];
		        }
			}
		}
	}

}
$data = array();
if (!empty($clocks_not_online)) {
    foreach($clocks_not_online as $not_online) {
	    $data[] = $not_online;
	}
} else {
    $data[] = "0";	
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
