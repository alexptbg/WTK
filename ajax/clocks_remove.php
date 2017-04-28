<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_POST)){
	$id = $_POST['id'];
	$inv = $_POST['inv'];
	$serialnumber = $_POST['serialnumber'];
    $confirm = $_POST['confirm'];
    
	if ( (!empty($id)) && (!empty($inv)) && (!empty($serialnumber)) && (!empty($confirm)) && ($confirm == "YES") ) {
 
        $sql="DELETE FROM `devices` WHERE `id`='".$id."' AND `inv`='".$inv."' AND `serialnumber`='".$serialnumber."'";
 
        if($local->query($sql) === false) {
            trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
        } else {
            echo "Removed ".$local->affected_rows." resource.";
            insert_log($user_settings['username'],"danger","Removed clock from database. (".$inv.")");
        }
		
	}

} else {
	echo "error-1";
}

?>
