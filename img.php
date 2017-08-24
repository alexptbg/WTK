<?php

$serverName = "192.168.0.111";
$uid = "Carlos";
$pwd = "Alen";
$db = "Percent";
$PIN = $_GET['PIN'];
//$PIN = 91756;

$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"$db", "CharacterSet" => "UTF-8");
/*
$conn = sqlsrv_connect($serverName,$connectionInfo);

if($conn) {
     echo "Connection established.<br/>";
} else {
     echo "Connection could not be established.<br/>";
     die( print_r( sqlsrv_errors(), true));
}

$sql = "SELECT PIN,Name from Workers";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo $row['PIN']." - ".$row['Name']."<br />";
}

sqlsrv_free_stmt($stmt);
/* Close the connection. */
//sqlsrv_close( $conn);

//new

/* Connect to the local server using Windows Authentication and
specify the AdventureWorks database as the database in use. */

$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

/* Set up the Transact-SQL query. */
$tsql = "SELECT Photo 
         FROM Workers
         WHERE PIN = ?";

/* Set the parameter values and put them in an array. */

$params = array( $PIN);

/* Execute the query. */
$stmt = sqlsrv_query($conn, $tsql, $params);
if( $stmt === false )
{
     echo "Error in statement execution.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the data.
The return data is retrieved as a binary stream. */
if ( sqlsrv_fetch( $stmt ) )
{
   $image = sqlsrv_get_field( $stmt, 0, 
                      SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY));
   header("Content-Type: image/jpg");
   fpassthru($image);
}
else
{
     echo "Error in retrieving data.</br>";
     die(print_r( sqlsrv_errors(), true));
}

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
?>