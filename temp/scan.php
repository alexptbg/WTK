<?php
//config
error_reporting(E_ALL);

$pin_min=10000;
$pin_max=70000;
echo date("Y-m-d H:i:s")."<br/>";

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

//DROP table
if (mysqli_query($link,"TRUNCATE TABLE `cards`") === TRUE) {
    printf("Table 'cards' dropped.<br/>");
}

//postgres
$host = "10.1.128.67";
$port = "5432";
$db = "mes";
$user = "mes";
$pwd = "mes";

//sql
$server2 = "192.168.0.111";
$uid2 = "Carlos";
$pwd2 = "Alen";
$db2 = "Percent";
    
$connectionInfo2 = array("UID" => $uid2, "PWD" => $pwd2, "Database"=>"$db2", "CharacterSet" => "UTF-8");
$conn2 = sqlsrv_connect($server2,$connectionInfo2);

if(!$conn2) {
    echo "Connection could not be establishedx.<br/>";
    die(print_r(sqlsrv_errors(),true));
}

$conn = pg_connect("host=".$host." port=".$port." dbname=".$db." user=".$user." password=".$pwd) or die('Could not connect: '.pg_last_error());

if ($conn) { 
    //query
    $result = pg_query($conn,"SELECT card_number,pin FROM card2pin WHERE pin BETWEEN $pin_min AND $pin_max ORDER BY pin");
    //next
    if ($result) {
    	$i=0; $z=0;
    	$last = "";
    	
        while ($row = pg_fetch_assoc($result)) {
        	
        	if ($last != $row['pin'] /*&& ($row['pin']>$pin_min) && ($row['pin']<$pin_max)*/) {
                
                $sql2 = "SELECT Name from Workers WHERE PIN=".$row['pin']."";
                $params2 = array();
                $options2 = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
                $stmt2 = sqlsrv_query($conn2,$sql2,$params2,$options2);
                if($stmt2===false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                $row_count2 = sqlsrv_num_rows($stmt2);
                if($row_count2 == 1) {
                    while($row2 = sqlsrv_fetch_array($stmt2,SQLSRV_FETCH_ASSOC)) {
                	    //print_r($row);
                        //print_r($row2);
                        //print "<br/>";
                        //insert
		                $query3 = "INSERT INTO `cards` (`card`,`pin`,`name`) VALUES ('".$row['card_number']."','".$row['pin']."','".$row2['Name']."')";
                        $result3 = mysqli_query($link,$query3);
                        if (!$result3) {
        	                echo "error 2"; //die;
                        }
                    }
                    $z++;
                }
                $i++;
			}
            
            $last = $row['pin'];
            
        }
        sqlsrv_free_stmt($stmt2);
        sqlsrv_close($conn2);
        $now = date("Y-m-d H:i:s");
        $stamp = time();

        echo $i." Total PIN results.<br/>";
        if (mysqli_query($link,"INSERT INTO `replica` (`datetime`,`timestamp`,`device`,`filter`,`value`) VALUES ('".$now."','".$stamp."','server','success','".$z."')") === TRUE) {
            printf($z." Total Names recorded.<br/>");
        }
        //echo $z." Total Names recorded.<br/>";

        mysqli_close($link);

        header('Location: http://192.168.5.104/replica.php');
    } else {
        echo "An error occurred.\n";
        exit;
    }
} else {
    echo "Can't connect to server pg server.";
}

echo date("Y-m-d H:i:s")."<br/>";
?>
