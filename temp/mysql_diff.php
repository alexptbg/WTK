<?php
//mysql
define("DB_SERVER", "192.168.1.190");
define("DB_NAME", "workers");
define("DB_USER", "replication");
define("DB_PASS", "slavex");

$link = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if (!mysqli_set_charset($link, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    exit();
}



?>
