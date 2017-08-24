<?php
error_reporting(E_ALL);

$now = date("Y-m-d H:i:s");
echo $now."<br/>";
//cards offset by day
$offset = 25;

//mysql
$link = mysqli_connect("127.0.0.1","replication","slavex","raspi");

if (!$link) {
    echo "Error: Unable to connect to MySQL.<br/>";
    //echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: ".mysqli_connect_error()."<br/>";
    exit;
}

/* change character set to utf8 */
if (!mysqli_set_charset($link,"utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    exit();
}

$result = mysqli_query($link,"SELECT * FROM `replica` ORDER BY `datetime` DESC LIMIT 1");
$num_rows = mysqli_num_rows($result);
if($num_rows == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        $last_time = $row['timestamp'];
        $last_filter = $row['filter'];
        $last_value = $row['value'];
    }
}
mysqli_free_result($result);

$resultx = mysqli_query($link,"SELECT * FROM `cards_active`");
$cards_active = mysqli_num_rows($resultx);
mysqli_free_result($resultx);

$resultz = mysqli_query($link,"SELECT * FROM `cards`");
$cards = mysqli_num_rows($resultz);
mysqli_free_result($resultz);

$cards_offset = $cards-$offset;

if (($cards > $cards_offset) && ( (time()-$last_time) < (5*60) ) ) {
    $resulty = mysqli_query($link,"TRUNCATE TABLE `cards_active`");
    if($resulty) {
        $resultw = mysqli_query($link,"INSERT INTO `cards_active` SELECT * from `cards`");
        if($resultw) {
            echo "Replication done.<br/>";
        }
    }
} else {
    echo "ne";
}

echo date("Y-m-d H:i:s")."<br/>";
?>
