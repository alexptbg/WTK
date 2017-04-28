<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
$sql1="DELETE FROM `status` WHERE `dtime` < DATE_SUB(NOW(), INTERVAL 7 DAY);";
if($local->query($sql1) === false) {
  trigger_error('Wrong SQL: '.$sql1.' Error: '.$local->error,E_USER_ERROR);
} else {
  $affected_rows = $local->affected_rows;
}
$sql2="DELETE FROM `clock_logs` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL 7 DAY);";
if($local->query($sql2) === false) {
  trigger_error('Wrong SQL: '.$sql2.' Error: '.$local->error,E_USER_ERROR);
} else {
  $affected_rows = $local->affected_rows;
}
$now = date("Y-m-d H:i:s");
$devices = array();
$query3="SELECT * FROM `devices` WHERE `track`='1' ORDER BY `inv` ASC";
$result3=$local->query($query3);
if($result3 === false) {
    trigger_error('Wrong SQL: '.$query3.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result3->num_rows > 0) {
        while($row3 = mysqli_fetch_assoc($result3)) {
			$devices[] = $row3;
		}
    }
}
if(!empty($devices)){
    foreach($devices as $device) {
        $query="SELECT * FROM `status` WHERE `ip`='".$device['ip']."' ORDER BY `id` DESC LIMIT 1";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);	
        } else {
            if($result->num_rows >= 1) {
				while($row = mysqli_fetch_assoc($result)) {
					$sql4="INSERT INTO `counters` (`clock`,`datetime`,`value`) 
                           VALUES ('".$row['inv']."','".$now."','".$row['reads']."')";
                    $result4=$local->query($sql4);
                    if($result4 === false) {
                        trigger_error('Wrong SQL: '.$sql4.' Error: '.$local->error,E_USER_ERROR);
                    } else {
                        echo "Inserted resource id ".$local->insert_id."<br/>";
                    }
					
				}
			}
		}
	}	
}
echo "Done.";
?>
