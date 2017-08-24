<?php
//config
error_reporting(E_ALL);

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
$stmt = $dbh->prepare("SELECT * FROM RTU_RECENT_INFO WHERE PIN='70656'");
$stmt->execute();

while ($row = $stmt->fetch()) {
    print "<pre>";
    print_r($row);
    print "</pre>";
}

unset($dbh); 
unset($stmt);

?>
