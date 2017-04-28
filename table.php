<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="<?=$local_settings['appname']?>" />
    <meta name="keywords" content="<?=$local_settings['appname']?>" />
    <title><?=$local_settings['appname']?></title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <link type="text/css" rel="stylesheet" href="assets/css/entypo.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/ka-ex.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/core.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/forms.css" />
    <!-- tables -->
    <link type="text/css" rel="stylesheet" href="assets/plugins/datatables/css/jquery.dataTables.css" />
    <link type="text/css" rel="stylesheet" href="assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" />
    <style>
    img.map {
        width: 100% !important;
        height: auto;
    }
	</style>
</head>
<body>
    <!-- Loader Backdrop -->
	<div class="loader-backdrop">           
	    <!-- Loader -->
		<div class="loader">
			<div class="bounce-1"></div>
			<div class="bounce-2"></div>
		</div>
	    <!-- /loader -->
	</div>
    <!-- loader backgrop -->
    
    <div class="container-fluid">

	  <div class="row">
		
		<div class="col-sm-12 col-lg-12 col-md-12 col-xm-12" style="border:1px solid #FF0000;">
        <?php
$buildings = array();
//$query="SELECT * FROM `devices` ORDER BY `building`,`floor` ASC";
$query="SELECT `building` FROM `devices` GROUP BY `building` ORDER BY `building` ASC";
$result=$local->query($query);
if($result === false) {
    trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			/*
			print "<pre>";
			print_r($row);
			print "</pre>";
			*/
			$buildings[] = $row['building'];
		}
    }
}
/*
print "<pre>";
print_r($buildings);
print "</pre>";
*/
if(!empty($buildings)) {
	$floors = array();
    foreach($buildings as $building) {
        $query="SELECT `floor` FROM `devices` WHERE `building`='".$building."' GROUP BY `floor` ORDER BY `floor` ASC";
        $result=$local->query($query);
        if($result === false) {
            trigger_error('Wrong SQL: '.$query.' Error: '.$local->error,E_USER_ERROR);
        } else {
            if($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
			        /*
			        print "<pre>";
			        print_r($row);
			        print "</pre>";
			        */
                    $query3="SELECT * FROM `devices` WHERE `building`='".$building."' AND `floor`='".$row['floor']."' AND `track`='1'";
                    $result3=$local->query($query3);
                    if($result3 === false) {
                        trigger_error('Wrong SQL: '.$query3.' Error: '.$local->error,E_USER_ERROR);
                    } else {
                        if($result3->num_rows > 0) {
                            while($row3 = mysqli_fetch_assoc($result3)) {
			                    /*
			                    print "<pre>";
			                    print_r($row3);
			                    print "</pre>";
			                    */
			        
		                    }
                        }
                    }
			       
		        }
            }
        }
	}	
}        
        ?>

		</div>
			
	  </div>

    </div>

    <!--JavaScripts-->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="assets/js/functions.js"></script>

	<script type="text/javascript" src="watch/js/jquery.easing.1.3.js"></script>

    <script type="text/javascript" src="assets/js/loader.js"></script>
</body>
</html>
