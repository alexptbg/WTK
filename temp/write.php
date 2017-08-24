<?php
//config
error_reporting(E_ALL);
$now = date("Y-m-d H:i:s");
//OBDC
try {
    //$hostname = "192.168.0.168";
    $hostname = "mssql";
    $port = 1433;
    $dbname = "PIRINTEXDB";
    $username = "Alex";
    $pw = "11543395";
    $dbh = new PDO ("dblib:host=$hostname:$port;dbname=$dbname;","$username","$pw");
} catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
}

//test vars
$EvWhen = date("Y-m-d H:i:s",strtotime("-2 hours"));
//$EvWhen = $now;
$EvType = "I";
$CARD_GRP = "34";
$CARD_NO = "8633102";
$RTU_NO = "13001";
$RTU_GRP = "2";
$SOURCE = "A";
$EGN = "9210276582";
$PIN = "20084";
$GRP = "10022";
$RTU_SERVER = "SERVER_MC";

$stmt = $dbh->prepare("INSERT INTO RTU_RECENT_INFO (EvWhen,EvType,CARD_GRP,CARD_NO,RTU_NO,RTU_GRP,SOURCE,EGN,PIN,GRP,RTU_SERVER)
                       VALUES(:EvWhen,:EvType,:CARD_GRP,:CARD_NO,:RTU_NO,:RTU_GRP,:SOURCE,:EGN,:PIN,:GRP,:RTU_SERVER)");
$stmt->execute(array(
    "EvWhen" => $EvWhen,
    "EvType" => $EvType,
    "CARD_GRP" => $CARD_GRP,
    "CARD_NO" => $CARD_NO,
    "RTU_NO" => $RTU_NO,
    "RTU_GRP" => $RTU_GRP,
    "SOURCE" => $SOURCE,
    "EGN" => $EGN,
    "PIN" => $PIN,
    "GRP" => $GRP,
    "RTU_SERVER" => $RTU_SERVER
));
	                   
unset($dbh); 
unset($stmt);

?>
