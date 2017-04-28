<?php
$CARD = $_GET['CARD'];
define('start',TRUE);
include("../inc/db2.php");
include("../inc/classes.php");
include("../inc/functions.php");
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$data = array();
$errors = array();

$query = "SELECT * FROM `cards_active` WHERE `card`='".$CARD."' ORDER BY `id` DESC LIMIT 1";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0 ) {
  while($rows = mysql_fetch_assoc($result)) {
    $data = $rows;
  }
}

//output
$data = array("PIN" => $PIN, "Name" => $name);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>