<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_POST)){
	$id = $_POST['id'];
	$username = $_POST['username'];
    $confirm = $_POST['confirm'];
    
	if ( (!empty($id)) && (!empty($username)) && (!empty($confirm)) && ($confirm == "YES") ) {
 
        $sql="DELETE FROM `users` WHERE `id`='".$id."' AND `username`='".$username."'";
 
        if($local->query($sql) === false) {
            trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
        } else {
            echo "Removed ".$local->affected_rows." resource.";
            insert_log($user_settings['username'],"danger","Removed user ".$username." from database.");
        }
		
	}

} else {
	echo "error-1";
}

?>
