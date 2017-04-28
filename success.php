<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
ini_set("session.gc_maxlifetime","14400");
session_name($local_settings['appname']);
session_start();
if(isset($_SESSION[$local_settings['appname'].'_username']) && ($_SESSION[$local_settings['appname']] == $local_settings['appname'])) {
    $username = $_SESSION[$local_settings['appname'].'_username'];
	//setcookie($local_settings['appname'], $local_settings['appname'], time()+14400);
	setcookie($local_settings['appname'], "localhost", time()+14400, "/", "localhost", 0, true);
    update_login($username);
} else {
	//session_destroy();
	$_SESSION[$local_settings['appname']] = NULL;
	$location = "login.php";
	header("location:$location");
}
?>
