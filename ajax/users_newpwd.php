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
	$password = $_POST['password'];
    $confirm = $_POST['confirm'];
    //continue
	if ( (!empty($id)) && (!empty($username)) && (!empty($password)) && (!empty($confirm)) && ($confirm == "YES") ) {
		$data = array();
		if (empty($errors)) {
            $sql="UPDATE `users` SET `password`='".md5($password)."' WHERE `id`='".$id."' AND `username`='".$username."'";
 
            if($local->query($sql) === false) {
                trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
            } else {
                $data = [
                    "name" => "data",
                    "msg" => "Updated password at resource id ".$local->insert_id
                ];
                insert_log($user_settings['username'],"danger","Changed the users password. (".$username.")");
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            }
		} else {
			$errors = array();
            $errors[0] = [
                "name" => "err",
                "errnr" => "1112",
                "error" => "Password for ".$username." wasn't updated'."
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($errors);
		}
	} else {
	    echo "error-2";	
	}
} else {
	echo "error-1";
}
?>
