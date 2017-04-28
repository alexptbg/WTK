<?php
if(!empty($_GET['ip'])) {
    $ip = $_GET['ip'];
    //remote server
    define('MDB_SERVER',$ip); // set database host
    define('MDB_USER','pi'); // set database user
    define('MDB_PASS','a11543395'); // set database password
    define('MDB_NAME','raspi'); // set database name
    $remote_settings = array();
    $remote = new mysqli(MDB_SERVER,MDB_USER,MDB_PASS,MDB_NAME);
	$remote->set_charset("utf8");
    $sql="SELECT * FROM `device`";
    $result=$remote->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$remote->error,E_USER_ERROR);
    } else {
        if($result->num_rows ==1) {
            $remote_settings = mysqli_fetch_assoc($result);
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($remote_settings);
} else {
    echo "error-1";
}
?>
