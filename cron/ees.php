<?php
//ees server
define('EES_SERVER','192.168.0.210'); // set database host
define('EES_USER','pi'); // set database user
define('EES_PASS','a11543395'); // set database password
define('EES_DB','raspi'); // set database name

$ees = new mysqli(EES_SERVER,EES_USER,EES_PASS,EES_DB);

$sql1="DELETE FROM `status` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL 1 DAY);";
if($ees->query($sql1) === false) {
  trigger_error('Wrong SQL: '.$sql1.' Error: '.$ees->error,E_USER_ERROR);
} else {
  echo "Affected rows ".$ees->affected_rows;
}

?>
