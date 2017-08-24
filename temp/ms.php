<?php
//works

  try {
    $hostname = "192.168.0.168";
    $port = 1433;
    $dbname = "PIRINTEXDB";
    $username = "Alex";
    $pw = "11543395";
    $dbh = new PDO("dblib:host=mssql:$port;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
  $stmt = $dbh->prepare("select * from PERSON_ID_MOD where pin='16979'");
  $stmt->execute();
  while ($row = $stmt->fetch()) {
	print "<pre>";
    print_r($row);
    print "</pre>";
  }
  unset($dbh); 
  unset($stmt);

?>
