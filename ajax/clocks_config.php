<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_POST)){
	$inv = $_POST['inv'];
	$ip = $_POST['ip'];	
	$serialnumber = $_POST['serialnumber'];
	$RTU_GRP = $_POST['RTU_GRP'];
	$GRP = $_POST['GRP'];	
	$lang = $_POST['lang'];
	$color = $_POST['color'];
	$tempfix = $_POST['tempfix'];
	$tempinfix = $_POST['tempinfix'];
	$cpufix = $_POST['cpufix'];
	$building = $_POST['building'];
	$floor = $_POST['floor'];
	$group = $_POST['groupnr'];
	if ( (!empty($inv)) && (!empty($ip)) && (!empty($serialnumber)) && (!empty($lang)) && (!empty($color)) && (!empty($building)) && (!empty($floor)) && (!empty($group)) ) {
        //remote server
        define('MDB_SERVER',$ip); // set database host
        define('MDB_USER','pi'); // set database user
        define('MDB_PASS','a11543395'); // set database password
        define('MDB_NAME','raspi'); // set database name
        $remote = new mysqli(MDB_SERVER,MDB_USER,MDB_PASS,MDB_NAME);
	    $remote->set_charset("utf8");
        $errors = array();
        $i=0;
		$data = array();
        if (empty($errors)) {
            $sql="UPDATE `device` SET `inv`='".$inv."',`ip`='".$ip."',`serialnumber`='".$serialnumber."',`RTU_GRP`='".$RTU_GRP."',`GRP`='".$GRP."',`lang`='".$lang."',`color`='#".$color."',`tempfix`='".$tempfix."',`tempinfix`='".$tempinfix."',`cpufix`='".$cpufix."',`building`='".$building."',`floor`='".$floor."',`groupnr`='".$group."' WHERE `id`='1'";
 
            if($remote->query($sql) === false) {
                trigger_error('Wrong SQL: '.$sql.' Error: '.$remote->error,E_USER_ERROR);
                
            } else {
                $data = [
                    "name" => "data",
                    "msg" => "The remote clock was updated successfully."
                ];
                insert_log($user_settings['username'],"warning","Updated the remote clock settings. (".$inv.")");
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            }
		} else {
            $errors[$i] = [
                "name" => "err",
                "errnr" => "1201",
                "error" => "The remote clock was not updated."
            ];
            $i++;
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($errors);
		}
		
	} else {
	    echo "error-2";
	}
} else {
	echo "error-1";
}
?>
