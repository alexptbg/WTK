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
    echo "              <div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover table-striped table-condensed\">
								<thead> 
									<tr>
										<th>DATE TIME</th> 
										<th>INV NO</th> 
										<th>SERIAL NO</th>
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
										<th>REV</th>
										<th>CARDS</th>
									</tr> 
								</thead> 
								<tbody>";
	$z=count($devices);
	$c=0;
    foreach($devices as $device) {
        $query="SELECT * FROM `status` WHERE `dtime` > DATE_SUB(NOW(), INTERVAL 61 SECOND) AND `ip`='".$device['ip']."' ORDER BY `id` DESC LIMIT 1";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);	
        } else {
            if($result->num_rows >= 1) {
				while($row = mysqli_fetch_assoc($result)) {
                    echo "          <tr>
										<td>".$row['dtime']."</td>";
										if ($row['inv'] == "10000") {
											echo "<td class=\"text-danger\">".$row['inv']."</td>";
										} else {
										    echo "<td>".$row['inv']."</td>";	
										}
										$check = check_serial($row['serial']);
										if ($check == TRUE) {
										    echo "<td>".strtoupper($row['serial'])."</td>";
										} else {
											echo "<td class=\"text-danger\"><a class=\"danger-link\" id=\"add\" href=\"modals/clocks_add.php?serialnumber=".$row['serial']."&ip=".$row['ip']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" title=\"ADD A NEW CLOCK TO DB\">".$row['serial']."</a></td>";
										}
                                        if ($row['ip'] == $device['ip']) {
                                            echo "<td>".$row['ip']."</td>";
                                        } else {
											echo "<td class=\"text-danger\">".$row['ip']."</td>";
										}
										if($row['ipstatus'] == 0) {
											echo "<td class=\"text-danger\">".$row['ipstatus']."</td>";
										} else {
										    echo "<td>".$row['ipstatus']."</td>";	
										}
										if ($row['cputemp'] > 75) {
											echo "<td class=\"text-danger\">".number_format($row['cputemp'],1)."</td>";
										} elseif (($row['cputemp'] > 65) && ($row['cputemp'] < 76) ){
											echo "<td class=\"text-warning\">".number_format($row['cputemp'],1)."</td>";
										} else {
											echo "<td class=\"text-primary\">".number_format($row['cputemp'],1)."</td>";
										}
										if ((time() - $row['timestamp']) < 65) {
											echo "<td class=\"text-primary\">".$row['timestamp']."</td>";
										} else {
										    echo "<td>".$row['timestamp']."</td>";	
										}
                                        echo "<td>";
										if($row['shelltime'] == 0) {
											echo "<span class=\"text-danger\">".$row['shelltime']."</span>";
										} else {
											echo "<span>".$row['shelltime']."</span>";
										}
										echo " / ";
										if($row['phptime'] == 0) {
											echo "<span class=\"text-danger\">".$row['phptime']."</span>";
										} else {
											echo "<span>".$row['phptime']."</span>";
										}
                                        echo "</td>";
										echo "<td>".number_format($row['tempin'],1)."</td>";
										if($row['tempsensor'] == 0) {
											echo "<td class=\"text-danger\">".$row['tempsensor']."</td>";
										} else {
											echo "<td>".$row['tempsensor']."</td>";
										}
                                        echo "<td>";
										if($row['tty'] == "0") {
											echo "<span class=\"text-danger\">".$row['tty']."</span>";
										} else {
											echo "<span>".$row['tty']."</span>";
										}
										echo " / ";
										if($row['ttydevice'] != 6969) {
											echo "<span class=\"text-danger\">".$row['ttydevice']."</span>";
										} else {
											echo "<span>".$row['ttydevice']."</span>";
										}
                                        echo "</td>";
										if($row['socket'] != 1) {
											echo "<td class=\"text-danger\">".$row['socket']."</td>";
										} else {
											echo "<td>".$row['socket']."</td>";
										}
										if($row['ping'] > 200) {
											echo "<td class=\"text-danger\">".number_format($row['ping'],1)."</td>";
										} else {
											echo "<td>".number_format($row['ping'],1)."</td>";
										}
										echo "
										<td>".$row['revision']."</td>
										<td>".$row['reads']."</td>
									 </tr>";
				    $c+=$row['reads'];
				}
			}
		}
	}
    echo "                      </tbody>
							    <tfoot>
							        <tr>
										<td>DATE TIME</td> 
										<td>INV NO</td> 
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
										<td>REV</td>
										<td>CARDS</td>
							        </tr>
							    </tfoot>
							</table>
							<div class=\"col-sm-6\">
							    <h4 style=\"font-weight:700;margin-left:-10px;\">Clocks: ".$z."</h4>
							</div>
							<div class=\"col-sm-6\">
							    <h4 class=\"fr\" style=\"font-weight:700;margin-right:-10px;\">Total card reads: ".$c."</h4>
							</div>
						</div>
					</div>";
}
?>
