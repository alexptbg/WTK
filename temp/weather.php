<?php
  $json_string = file_get_contents("http://api.wunderground.com/api/fbe9e4e3bfe170c7/geolookup/conditions/q/zmw:00000.2.15712.json");
  //$json_string = file_get_contents("http://api.wunderground.com/api/fbe9e4e3bfe170c7/forecast/q/zmw:00000.2.15712.json");

  $parsed_json = json_decode($json_string);
  print "<pre>";
  print_r($parsed_json);
  print "</pre>";
?>
