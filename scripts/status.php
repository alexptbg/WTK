<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");

$now = date("Y-m-d H:i:s");
$inv = $_GET['inv'];
$serial = $_GET['serial'];
$cputemp = preg_replace('/\,/','.',$_GET['cputemp']);
$timestamp = $_GET['stamp'];
$shelltime = $_GET['shelltime'];
$phptime = $_GET['phptime'];
$tempin = preg_replace('/\,/','.',$_GET['tempin']);
$tempsensor = $_GET['tempsensor'];
$tty = $_GET['tty'];
$ttydevice = $_GET['ttydevice'];
$socket = $_GET['socket'];
$ping = preg_replace('/\,/','.',$_GET['ping']);
$ping = floatval($ping);
$reads = $_GET['reads'];

$device = get_device_info($serial);
if (!empty($device['ip'])) {
    if($device['ip'] == $_SERVER["REMOTE_ADDR"]) {
	    $ipstatus = "1";
    } else {
	    $ipstatus = "0";
    }
} else {
	$ipstatus = "0";
}

$sql="INSERT INTO `status` (`dtime`,`inv`,`serial`,`ip`,`ipstatus`,`cputemp`,`timestamp`,`shelltime`,`phptime`,`tempin`,`tempsensor`,`tty`,`ttydevice`,`socket`,`ping`,`reads`) 
                    VALUES ('".$now."','".$inv."','".$serial."','".$_SERVER["REMOTE_ADDR"]."','".$ipstatus."','".$cputemp."','".$timestamp."','".$shelltime."','".$phptime."','".$tempin."','".$tempsensor."','".$tty."','".$ttydevice."','".$socket."','".$ping."','".$reads."')";
$result=$local->query($sql);
if($result === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
} else {
    //$last_inserted_id = $local->insert_id;
    //$affected_rows = $local->affected_rows;
    echo "Inserted resource id ".$local->insert_id;
}

?>
