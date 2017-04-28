<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$devices = array();
$query="SELECT * FROM `devices` WHERE `track`='1'";
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
    foreach($devices as $device) {
        $query="SELECT * FROM `status` WHERE `dtime` > DATE_SUB(NOW(), INTERVAL 62 SECOND) AND `ip`='".$device['ip']."' ORDER BY `id` DESC";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);	
        } else {
            if($result->num_rows >= 1) {
				//dtime 	inv 	serial 	ip 	ipstatus 	cputemp 	timestamp 	shelltime 	phptime 	tempin 	tempsensor 	tty 	ttydevice 	socket 	ping
                while($row = mysqli_fetch_assoc($result)) {
                    //inv
                    if($row['inv'] == "10000") {
						clock_log($row['inv'],$row['ip'],"danger","Inventory number is not valid nor unconfigured."); 
					}
                    if($row['inv'] != $device['inv']) {
						clock_log($row['inv'],$row['ip'],"danger","Inventory number doesnt match."); 
					}
                    //serial
                    if($device['serialnumber'] != $row['serial']) {
						clock_log($row['inv'],$row['ip'],"danger","Serial number doesnt match.");
					}
                    //ip
                    if($device['ip'] != $row['ip']) {
						clock_log($row['inv'],$row['ip'],"danger","Device ip doesnt match.");
					}
					//ipstatus
                    if($row['ipstatus'] == "0") {
						clock_log($row['inv'],$row['ip'],"danger","Remote device ip doesnt match.");
					}
                    //cpu
					if ($row['cputemp'] > 75) {
                        clock_log($row['inv'],$row['ip'],"danger","Very high temperature detected.");
					} elseif (($row['cputemp'] > 65) && ($row['cputemp'] < 76)){
                        clock_log($row['inv'],$row['ip'],"warning","High temperature detected.");
					}
					//timestamp
					if( (time()-$row['timestamp']) > 65) {
						clock_log($row['inv'],$row['ip'],"danger","Timestamp doesnt match.");
					}
					//shelltime
                    if($row['shelltime'] == "0") {
						clock_log($row['inv'],$row['ip'],"danger","Debian shell time is invalid.");
					}
					//phptime
                    if($row['phptime'] == "0") {
						clock_log($row['inv'],$row['ip'],"danger","PHP time is invalid.");
					}
					//tempsensor
                    if($row['tempsensor'] == "0") {
						clock_log($row['inv'],$row['ip'],"danger","Temperature sensor is not working.");
					}
					//tty
                    if($row['tty'] != "ttyUSB0") {
						clock_log($row['inv'],$row['ip'],"danger","TTYUSB0 is not present.");
					}
					//ttydevice
                    if($row['ttydevice'] != "6969") {
						clock_log($row['inv'],$row['ip'],"danger","RFID is not working.");
					}
					//socket
                    if($row['socket'] == "0") {
						clock_log($row['inv'],$row['ip'],"danger","Socket is invalid.");
					}
					//ping
					if($row['ping'] > 300) {
					    clock_log($row['inv'],$row['ip'],"danger","Very high latency detected.");	
					} else if (($row['ping'] > 100) && ($row['ping'] < 301)){
					    clock_log($row['inv'],$row['ip'],"danger","High latency detected.");	
					}
		        }
            } else {
				//clock is not online
			    clock_log($device['inv'],$device['ip'],"danger","Device is not working.");	
			}
        }
    }
}
?>
