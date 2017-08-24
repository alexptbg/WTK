<?php

$url = "http://192.168.2.204/raspi_status.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
if (curl_errno($ch)) { 
   print curl_error($ch); 
} 
curl_close($ch);
//var_dump(json_decode($result,true));
print_r($result);

?>
