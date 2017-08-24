<?php
//config
error_reporting(E_ALL);

echo date("Y-m-d H:i:s")."<br/>";

define('DB_SERVER','127.0.0.1'); // set database host
define('DB_USER','pi'); // set database user
define('DB_PASS','a11543395'); // set database password
define('DB_NAME','raspi'); // set database name

$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

if ($local->connect_error) {
  trigger_error('Database connection failed: '.$local->connect_error,E_USER_ERROR);
}

$local->set_charset("utf8");

if($local->query("TRUNCATE TABLE `cards`") === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
} else {
	printf("Table 'cards' dropped.<br/>");
}

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
$stmt = $dbh->prepare("SELECT * FROM PERSON_ID_MOD ORDER BY PIN ASC");
$stmt->execute();
$i=1;
$last = "";
while ($row = $stmt->fetch()) {
    if ($last != $row['PIN']) {
        $sql = "INSERT INTO `cards` (`card`,`card_grp`,`pin`,`name`,`egn`,`grp`) 
	            VALUES ('".$row['CARD_NO']."', '".$row['CARD_GRP']."', '".$row['PIN']."', '".$row['FULL_NAME']."', '".$row['EGN']."', '".$row['GRP']."')";
        if($local->query($sql) === false) {
            trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
        } else {
            //do nothing
        }
        /*
        print "<pre>";
        print_r($row);
        print "</pre>";
        */
        $i++;
    }
    $last = $row['PIN'];
}
unset($dbh); 
unset($stmt);
echo "Total: ".$i." pins";
$now = date("Y-m-d H:i:s");
$stamp = time();
if($local->query("INSERT INTO `replica` (`datetime`,`timestamp`,`device`,`filter`,`value`) VALUES ('".$now."','".$stamp."','server','success','".$i."')") === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
} else {
	header('Location: http://192.168.5.104/replica.php');
}
?>
