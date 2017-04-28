<?php
if(!empty($_GET)) {
    $ip = $_GET['ip'];
    //$ip = "192.168.0.210";
    $ping = shell_exec("ping -c 1 -w 1 $ip | awk 'FNR == 2 { print $(NF-1) }' | cut -d'=' -f2");
    $retry = shell_exec("ping -c 1 -w 1 $ip");
    if (empty($ping)) {
        echo "<div id=\"errorx\"><div class=\"alert alert-danger\" role=\"alert\"><strong>ERROR:</strong> Destination Host Unreachable</div></div>";
    } else {
        print "<pre>";
        print_r($retry);
        print "</pre>";	
	}
}
?>
