<?php

//postgres
$host = "10.1.128.67";
$port = "5432";
$db = "mes";
$user = "mes";
$pwd = "mes";

$conn = pg_connect("host=".$host." port=".$port." dbname=".$db." user=".$user." password=".$pwd) or die('Could not connect: '.pg_last_error());
$x = "createdAt";
$z = base64_encode($x);
if ($conn) { 
    //query
    /*
    $result = pg_query($conn,
        "SELECT * FROM task WHERE employee_id=13152 AND 'createdAt' BETWEEN '2017-02-01' AND '2017-02-28'" 
    );
    */
    $result = pg_query($conn,
        "SELECT * FROM task WHERE employee_id=13152 AND \"createdAt\" >= '2017-02-23' AND \"createdAt\" <= '2017-02-28'"
    );
    
    /*
    $result = pg_query($conn,
        "SELECT * FROM task WHERE employee_id=13152 AND 'createdAt' >= '2017-02-27 00:00' AND 'createdAt' <= '2017-02-28 00:00'" 
    );
    */
    
    //next
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            print "<pre>";
            print_r($row);
            print "</pre>";
        }
    }
}


?>
