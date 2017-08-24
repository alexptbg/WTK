<?php
//config
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
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
$stmt = $dbh->prepare("SELECT * FROM GROUP_MAPPINGS WHERE RTU_SERVER='SERVER_MC' ORDER BY GRP ASC");
$stmt->execute();
$i = 1;
while ($row = $stmt->fetch()) {
	/*
    print "<pre>";
    print_r($row);
    print "</pre>";
    */
    echo $i." "."\t"."RTU_GRP: ".$row['RTU_GRP']." GRP: ".$row['GRP']."<br/>";
    $i++;

            $sql="INSERT INTO `GROUP_MAPPINGS` (RTU_GRP,GRP) 
                  VALUES ('".preg_replace('/\s+/','',$row['RTU_GRP'])."','".preg_replace('/\s+/','',$row['GRP'])."')";
 
            if($local->query($sql) === false) {
                trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
            } else {
                $data = [
                    "name" => "data",
                    "msg" => "Inserted resource id ".$local->insert_id
                ];
                //header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            }
}

unset($dbh); 
unset($stmt);

?>
