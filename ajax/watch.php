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
    $z=0;
    foreach($devices as $device) {
        $query="SELECT * FROM `status` WHERE `dtime` > DATE_SUB(NOW(), INTERVAL 61 SECOND) AND `ip`='".$device['ip']."' ORDER BY `id` DESC LIMIT 1";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);	
        } else {
            if($result->num_rows >= 1) {

				while($row = mysqli_fetch_assoc($result)) {
                    /*
                    print "<pre>";
                    print_r($row);
                    print "</pre>";
					*/
		            $errors = array();
		            $i=0;
					$inv = "";
                    //serial
					$check = check_serial($row['serial']);
					if ($check == TRUE) {
						$serial = $row['serial'];
					} else {
						$serial = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['serial'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					}
					//ip address
					if ($row['ip'] == $device['ip']) {
					    $ip = $row['ip'];
				    } else {
						$ip = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['ip'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					}
					//ip status
					if($row['ipstatus'] == 0) {
						$ipstatus = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['ipstatus'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$ipstatus = $row['ipstatus'];
					}
					//cpu temp
					if ($row['cputemp'] > 75) {
                        $cputemp = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['cputemp'];
					} elseif (($row['cputemp'] > 65) && ($row['cputemp'] < 76) ){
                        $cputemp = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['cputemp'];
					} else {
                        $cputemp = $row['cputemp'];
					}
                    //timestamp
					if ((time() - $row['timestamp']) < 63) {
                        $timestamp = $row['timestamp'];
					} else {
                        $timestamp = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['timestamp'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					}
					//shelltime
					if($row['shelltime'] == 0) {
						$shelltime = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['shelltime'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$shelltime = $row['shelltime'];
					}
					//phptime
					if($row['phptime'] == 0) {
						$phptime = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['phptime'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$phptime = $row['phptime'];
					}
					//temperature sensor
					if($row['tempsensor'] == 0) {
						$tempsensor = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['tempsensor'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$tempsensor = $row['tempsensor'];
					}
					//tty
					if($row['tty'] == "0") {
						$tty = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['tty'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$tty = $row['tty'];
					}
					//tty device
					if($row['ttydevice'] != 6969) {
						$ttydevice = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['ttydevice'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$ttydevice = $row['ttydevice'];
					}
					//socket
					if($row['socket'] != 1) {
						$socket = "<i class=\"fa fa-exclamation-triangle\"></i> ".$row['socket'];
                        $errors[$i] = [
                            "id" => $i
                        ];
                        $i++;
					} else {
						$socket = $row['socket'];
					}
					//ping
					if($row['ping'] > 200) {
						$ping = "<i class=\"fa fa-exclamation-triangle\"></i> ".number_format($row['ping'],1);
					} else {
						$ping = number_format($row['ping'],1);
					}
					//init
					if ($row['inv'] == "10000") {
						$template = "HuskyBlue";
						$spotcolor = "bluehotspot";
					} else {
					    if (empty($errors)) {
					        $template = "PaleMint";
					        $spotcolor = "greenhotspot";
					    } else {
						    $template = "HotRed";
						    $spotcolor = "redhotspot";
					    }
					}
					if ($device['mapx'] == 0 || $device['mapy'] == 0) {
						$x = $z*3;
						$mapx = $x;
						$mapy = 95;
					} else {
						$mapx = $device['mapx'];
						$mapy = $device['mapy'];
					}
					//construct
                    $data[] = [
                        "id" => $z,
                        "dtime" => $row['dtime'],
                        "inv" => $row['inv'],
                        "serial" => $serial,
                        "ip" => $ip,
                        "ipstatus" => $ipstatus,
                        "cputemp" => $cputemp,
                        "timestamp" => $timestamp,
                        "shelltime" => $shelltime,
                        "phptime" => $phptime,
                        "tempin" => $row['tempin'],
                        "tempsensor" => $tempsensor,
                        "tty" => $tty,
                        "ttydevice" => $ttydevice,
                        "socket" => $socket,
                        "ping" => $ping,
                        "reads" => $row['reads'],
                        "template" => $template,
                        "spotcolor" => $spotcolor,
                        "mapx" => $mapx,
                        "mapy" => $mapy
                    ];
                
				}
			}
		}
        $z++;
	}
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
