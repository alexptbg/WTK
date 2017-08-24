<?php
defined('start') or die('Direct access not allowed.');

function get_local_settings() {
	global $local_settings;
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT * FROM `settings`";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows ==1) {
            $local_settings = mysqli_fetch_assoc($result);
        }
    }
    return $local_settings;
}
function get_device_info($serial) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT * FROM `devices` WHERE `serialnumber`='".$serial."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows ==1) {
            $device = mysqli_fetch_assoc($result);
        } else {
		    $device = "0";	
		}
    }
    return $device;
}
function check_inv($inv) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `inv` FROM `devices` WHERE `inv`='".$inv."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_id_and_inv($id,$inv) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `id`,`inv` FROM `devices` WHERE `id` NOT LIKE '".$id."' AND `inv`='".$inv."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_serial($serial) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `serialnumber` FROM `devices` WHERE `serialnumber`='".$serial."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_id_and_serial($id,$serial) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `id`,`serialnumber` FROM `devices` WHERE `id` NOT LIKE '".$id."' AND `serialnumber`='".$serial."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_ip($ip) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `ip` FROM `devices` WHERE `ip`='".$ip."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_id_and_ip($id,$ip) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `id`,`ip` FROM `devices` WHERE `id` NOT LIKE '".$id."' AND `ip`='".$ip."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_username($username,$password,$appname) {
	$u = base64_decode($username);
	$p = md5(base64_decode($password));
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql = "SELECT `username` FROM `users` WHERE `username`='".$u."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows == 1) {
            check_password($u,$p,$appname);
        } else {
			//error username not valid
	        $errnr = "1101";
	        $error = "This username is invalid.";
		    $location = "error.php?errnr=".$errnr."&error=".$error;
		    header("location:$location");	
		}
    }
}
function check_password($username,$password,$appname) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql = "SELECT `username`,`password` FROM `users` WHERE `username`='".$username."' AND `password`='".$password."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows == 1) {
            check_status($username,$password,$appname);
        } else {
			//error password not valid
	        $errnr = "1102";
	        $error = "This password is invalid.";
		    $location = "error.php?errnr=".$errnr."&error=".$error;
		    header("location:$location");	
		}
    }
}
function check_status($username,$password,$appname) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql = "SELECT `status` FROM `users` WHERE `username`='".$username."' and `password`='".$password."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows == 1) {
            while($row = $result->fetch_assoc()){
                $status = $row['status'];
            }
            if ($status == "Active") {
			    session_name($appname);
                session_start();
			    $_SESSION[$appname] = $appname;
                $_SESSION[$appname.'_username'] = $username;
			    $location = "success.php";
                header("location:$location");
            } elseif ($status == "Deactivated") {
	            $errnr = "1103";
	            $error = "Your access was deactivated by the system Administrator.";
		        $location = "error.php?errnr=".$errnr."&error=".$error;
		        header("location:$location");	
            } elseif ($status == "Pending") {
	            $errnr = "1103";
	            $error = "Your access is awaiting activation by the system Administrator.";
		        $location = "error.php?errnr=".$errnr."&error=".$error;
		        header("location:$location");	
            } else {
	            $errnr = "1001";
	            $error = "Unknown error.";
		        $location = "error.php?errnr=".$errnr."&error=".$error;
		        header("location:$location");	
		    }
        } else {
	        $errnr = "1001";
	        $error = "Unknown error.";
		    $location = "error.php?errnr=".$errnr."&error=".$error;
		    header("location:$location");	
		}
    }
}
function update_login($username) {
	$updated = date('Y-m-d H:i:s');
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql = "UPDATE `users` SET `lastlogin`='".$updated."' WHERE `username`='".$username."'";
    $result=$local->query($sql);
    if($local->query($sql) === false) {
        trigger_error('Wrong SQL: ' .$sql.' Error: '.$local->error, E_USER_ERROR);
    } else {
        $affected_rows = $local->affected_rows;
    }
	$location = "index.php";
	header("location:$location");
}
function check_login($appname){
    if (session_status() == PHP_SESSION_NONE) {
		session_name($appname);
        session_start();
    }	
    function check_loggedin($appname) {
		if(isset($_SESSION[$appname]) /*&& ($_SESSION[$appname] == $appname)*/) {
			return TRUE;
        } else {
			return FALSE;
		}
        //return isset($_SESSION[$web_dir.'_username']) && ($_SESSION['APP'] == $web_dir);
    }
    if (!check_loggedin($appname)) {
        //session_destroy();
        $_SESSION[$appname] = NULL;
        unset($_COOKIE[$appname]);
		$location = "login.php";
	    header("location:$location");
    }
    else {
        header('Content-Type: text/html; charset=utf-8');
	    $user_settings = get_user_settings($_SESSION[$appname.'_username']);
		$_SESSION[$appname] = $appname;
    }
}
function get_user_settings($user) {
	global $user_settings;
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql = "SELECT * FROM `users` WHERE `username`='".$user."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows ==1) {
            $user_settings = mysqli_fetch_assoc($result);
        }
    }
    return $user_settings;
}
function check_username_before_insert($username) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql="SELECT `username` FROM `users` WHERE `username`='".$username."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $c = $result->num_rows;
    }
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function get_user($id,$username) {
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
    $sql = "SELECT * FROM `users` WHERE `id`='".$id."' AND `username`='".$username."'";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows ==1) {
            $user_settings = mysqli_fetch_assoc($result);
        }
    }
    return $user_settings;
}
function insert_log($username,$filter,$action) {
	$datetime = date("Y-m-d H:i:s");
	$timestamp = time();
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
	$sql = "INSERT INTO `user_logs` (`datetime`, `timestamp`, `username`, `filter`, `action`) 
		    VALUES ('".$datetime."', '".$timestamp."', '".$username."', '".$filter."', '".$action."')";
    if($local->query($sql) === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $last_inserted_id = $local->insert_id;
    }
}
function clock_log($clock,$ip,$filter,$action) {
	$datetime = date("Y-m-d H:i:s");
	$timestamp = time();
	$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$local->set_charset("utf8");
	$sql = "INSERT INTO `clock_logs` (`datetime`, `timestamp`, `device`, `ip`, `filter`, `action`) 
		    VALUES ('".$datetime."', '".$timestamp."', '".$clock."', '".$ip."', '".$filter."', '".$action."')";
    if($local->query($sql) === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        $last_inserted_id = $local->insert_id;
    }
}
function country($code){
    $country = "";
    if($code == "bg") $country = "БЪЛГАРСКИ";
    if($code == "en") $country = "ENGLISH";
    if($code == "fr") $country = "FRANÇAIS";
    if($country == "") $country = $code;
    return $country;
}
function color($code){
    $color = "";
    if($code == "00FFFF") $color = "AQUA";
    if($code == "BBFF02") $color = "GREEN";
    if($code == "FFD700") $color = "GOLD";
    if($code == "EE82EE") $color = "VIOLET";
    if($code == "FFFF00") $color = "YELLOW";
    if($color == "") $color = $code;
    return $color;
}
function array2table($arr) {
    $count = count($arr);
    if($count > 0){
        reset($arr);
        $num = count(current($arr));
        echo "<div class=\"table-responsive\">\n
				<table class=\"table table-bordered table-hover table-striped table-condensed\">\n
					<thead>\n
						<tr>\n";
        foreach(current($arr) as $key => $value){
            echo "<th>";
            echo $key."&nbsp;";
            echo "</th>\n";  
        }  
        echo "</tr>\n</thead>\n<tbody>\n";
        while ($curr_row = current($arr)) {
            echo "<tr>\n";
            $col = 1;
            while (false !== ($curr_field = current($curr_row))) {
                echo "<td>";
                if ($curr_field instanceof DateTime) {
					echo $curr_field->format('Y-m-d H:i:s')."&nbsp;";
				} else {
					echo $curr_field."&nbsp;";
				}
                echo "</td>\n";
                next($curr_row);
                $col++;
            }
            while($col <= $num){
                echo "<td>&nbsp;</td>\n";
                $col++;      
            }
            echo "</tr>\n";
            next($arr);
        }
        echo "</tbody>\n";
        echo "</table>\n";
        echo "</div>\n";
    }
}
?>
