<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$status = array();
$query="SELECT * FROM `status` ORDER BY `id` DESC LIMIT 25";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$status[] = $row;
		}
    }
}
$ips = array();
$query="SELECT `ip` FROM `devices`";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$ips[] = $row['ip'];
		}
    }
}
if(!empty($status)){
    echo "              <div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover table-striped table-condensed\">
								<thead> 
									<tr> 
										<th>DATE TIME</th> 
										<th>INV</th> 
										<th>SERIAL N0</th>
										<th>IP ADDRESS</th>
										<th>IP STATUS</th>
										<th>CPU TEMP</th>
										<th>TIMESTAMP</th>
										<th>TIME</th>
										<th>TEMP IN</th>
										<th>SENSOR</th>
										<th>TTY</th>
										<th>SOCKET</th>
										<th>PING</th>
										<th>CARDS</th>
									</tr> 
								</thead> 
								<tbody>";
    foreach($status as $single) {
        echo "                      <tr> 
										<td>".$single['dtime']."</td>";
										if ($single['inv'] == "10000") {
											echo "<td class=\"text-danger\">".$single['inv']."</td>";
										} else {
										    echo "<td>".$single['inv']."</td>";	
										}
										$check = check_serial($single['serial']);
										if ($check == TRUE) {
										    echo "<td>".strtoupper($single['serial'])."</td>";
										} else {
											echo "<td class=\"text-danger\"><a class=\"danger-link\" id=\"add\" href=\"modals/clocks_add.php?serialnumber=".$single['serial']."&ip=".$single['ip']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" title=\"ADD A NEW CLOCK TO DB\">".$single['serial']."</a></td>";
										}
                                        if (in_array($single['ip'],$ips)) {
                                            echo "<td>".$single['ip']."</td>";
                                        } else {
											echo "<td class=\"text-danger\">".$single['ip']."</td>";
										}
										if($single['ipstatus'] == 0) {
											echo "<td class=\"text-danger\">".$single['ipstatus']."</td>";
										} else {
										    echo "<td>".$single['ipstatus']."</td>";	
										}
										if ($single['cputemp'] > 75) {
											echo "<td class=\"text-danger\">".number_format($single['cputemp'],1)."</td>";
										} elseif (($single['cputemp'] > 65) && ($single['cputemp'] < 76) ){
											echo "<td class=\"text-warning\">".number_format($single['cputemp'],1)."</td>";
										} else {
											echo "<td class=\"text-primary\">".number_format($single['cputemp'],1)."</td>";
										}
										if ((time() - $single['timestamp']) < 65) {
											echo "<td class=\"text-primary\">".$single['timestamp']."</td>";
										} else {
										    echo "<td>".$single['timestamp']."</td>";	
										}
                                        echo "<td>";
										if($single['shelltime'] == 0) {
											echo "<span class=\"text-danger\">".$single['shelltime']."</span>";
										} else {
											echo "<span>".$single['shelltime']."</span>";
										}
										echo " / ";
										if($single['phptime'] == 0) {
											echo "<span class=\"text-danger\">".$single['phptime']."</span>";
										} else {
											echo "<span>".$single['phptime']."</span>";
										}
                                        echo "</td>";
										echo "<td>".number_format($single['tempin'],1)."</td>";
										if($single['tempsensor'] == 0) {
											echo "<td class=\"text-danger\">".$single['tempsensor']."</td>";
										} else {
											echo "<td>".$single['tempsensor']."</td>";
										}
                                        echo "<td>";
										if($single['tty'] == "0") {
											echo "<span class=\"text-danger\">".$single['tty']."</span>";
										} else {
											echo "<span>".$single['tty']."</span>";
										}
										echo " / ";
										if($single['ttydevice'] != 6969) {
											echo "<span class=\"text-danger\">".$single['ttydevice']."</span>";
										} else {
											echo "<span>".$single['ttydevice']."</span>";
										}
                                        echo "</td>";
										if($single['socket'] != 1) {
											echo "<td class=\"text-danger\">".$single['socket']."</td>";
										} else {
											echo "<td>".$single['socket']."</td>";
										}
										if($single['ping'] > 200) {
											echo "<td class=\"text-danger\">".number_format($single['ping'],1)."</td>";
										} else {
											echo "<td>".number_format($single['ping'],1)."</td>";
										}
										echo "
										<td>".$single['reads']."</td>
									 </tr>";
    }
    echo "                      </tbody>
							    <tfoot>
							        <tr>
										<td>DATE TIME</td> 
										<td>INV</td> 
										<td>SERIAL NO</td>
										<td>IP ADDRESS</td>
										<td>IP STATUS</td>
										<td>CPU TEMP</td>
										<td>TIMESTAMP</td>
										<td>TIME</td>
										<td>TEMP IN</td>
										<td>SENSOR</td>
										<td>TTY</td>
										<td>SOCKET</td>
										<td>PING</td>
										<td>CARDS</td>
							        </tr>
							    </tfoot>
							</table>
						</div>
					</div>";
}
?>
