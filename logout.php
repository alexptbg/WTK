<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
session_start();
session_destroy();
$_SESSION[$local_settings['appname']] = NULL;
unset($_COOKIE[$local_settings['appname']]);
$location = "login.php";
header("location:$location");
?>
