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
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$access = $_POST['access'];
	$level = $_POST['level'];
	$status = $_POST['status'];
    //continue
	if ( (!empty($id)) && (!empty($username)) && (!empty($firstname)) && (!empty($lastname)) && (!empty($email)) && (!empty($phone)) && (!empty($level)) && (!empty($status)) ) {
		$data = array();
		if (empty($errors)) {
            $sql="UPDATE `users` SET `firstname`='".$firstname."',`lastname`='".$lastname."',`email`='".$email."',`phone`='".$phone."',`access`='".$access."',`level`='".$level."',`status`='".$status."' 
                  WHERE `id`='".$id."' AND `username`='".$username."'";
 
            if($local->query($sql) === false) {
                trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
            } else {
                $data = [
                    "name" => "data",
                    "msg" => "Updated resource id ".$local->insert_id
                ];
                insert_log($user_settings['username'],"warning","Updated the user settings. (".$username.")");
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            }
		} else {
			$errors = array();
            $errors[0] = [
                "name" => "err",
                "errnr" => "1112",
                "error" => "Username ".$username." wasn't updated'."
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
