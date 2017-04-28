<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
$query="SELECT * FROM `clock_logs` ORDER BY `id` DESC LIMIT 25";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        echo "          <div class=\"table-responsive\">
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
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            if (date("Y-m-d") == date("Y-m-d",strtotime($row['datetime']))) {
				echo "<td class=\"text-danger\">".$row['datetime']."</td>";
			} else {
				echo "<td>".$row['datetime']."</td>";
			}
            echo "
                                        <td>".$row['device']."</td>
                                        <td>".$row['ip']."</td>
                                        <td class=\"text-".$row['filter']."\">".$row['action']."</td>
                                    </tr>";
		}
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
					</div>";
    }
}
?>
