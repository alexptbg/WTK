<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!empty($_GET['GRP'])) {
	$GRP = $_GET['GRP'];
    $sql="SELECT * FROM `GROUP_MAPPINGS` WHERE `GRP`='".$GRP."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows >=1) {
		    echo "<option></option>";
		    while($row = $result->fetch_assoc()){
		        echo "<option value=\"".$row['RTU_GRP']."\">".$row['RTU_GRP']."</option>";
	        }
        }
    }
} else {
    $sql="SELECT * FROM `GROUP_MAPPINGS` ORDER BY `RTU_GRP` ASC";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows >=1) {
		    echo "<option></option>";
		    while($row = $result->fetch_assoc()){
		        echo "<option value=\"".$row['RTU_GRP']."\">".$row['RTU_GRP']."</option>";
	        }
        }
    }
}
?>
