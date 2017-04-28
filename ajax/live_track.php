<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$devices = array();
$query="SELECT * FROM `devices` WHERE `track`='1' ORDER BY `inv` ASC";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$devices[] = $row;
		}
    }
}
if(!empty($devices)){
	$x=1;
    foreach($devices as $device) {
        $query="SELECT * FROM `clock_logs` WHERE `datetime` > DATE_SUB(NOW(), INTERVAL 60 SECOND) AND `ip`='".$device['ip']."' ORDER BY `id` DESC";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);	
        } else {
            if($result->num_rows >= 1) {
				if ($x == 1) {
                    echo "<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover table-striped table-condensed track\">
								<thead> 
									<tr>
										<th>DATETIME</th>
										<th>INV NO</th>
										<th>IP ADDRESS</th>
										<th>PROBLEM</th>
									</tr>
								</thead> 
								<tbody>";
				}
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    if (date("Y-m-d") == date("Y-m-d",strtotime($row['datetime']))) {
				        echo "<td class=\"text-danger\">".$row['datetime']."</td>";
			        } else {
				        echo "<td>".$row['datetime']."</td>";
			        }
                    echo "<td>".$row['device']."</td>
                          <td><a id=\"ping\" href=\"modals/clocks_ping.php?ip=".$row['ip']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" data-backdrop=\"static\" tag=\"PING IP ADDRESS\">".$row['ip']."</a></td>
                          <td class=\"text-".$row['filter']."\">".$row['action']."</td>
                      </tr>";
                    $x++;
		        }
			}
		}
	}
    if ($x > 1) {
        echo "                  </tbody>
							    <tfoot>
							        <tr>
										<td>DATETIME</td> 
										<td>INV NO</td>
										<td>IP ADDRESS</td>
										<td>PROBLEM</td> 
							        </tr>
							    </tfoot>
							</table>
						</div>
					</div>
					<!--
					<script type=\"text/javascript\">
                            var audioElement = document.createElement('audio');
                            audioElement.setAttribute('src', 'assets/raw/pager.mp3');
                            audioElement.setAttribute('autoplay', 'autoplay');
                            $.get();
                            audioElement.addEventListener('load', function() {
                                audioElement.play();
                            }, true);
					</script>
					-->
					";
					
	} else {
	    echo "There isn't any alarms listed at the moment.";	
	}
}
?>
