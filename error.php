<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
if(!empty($_GET)) {
	$errnr = $_GET['errnr'];
	$error = $_GET['error'];
} else {
	$errnr = "1001";
	$error = "Unknown error";
}
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
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link type="text/css" rel="stylesheet" href="assets/css/entypo.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/ka-ex.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/core.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/forms.css" />
    <!-- tables -->
    <link type="text/css" rel="stylesheet" href="assets/plugins/datatables/css/jquery.dataTables.css" />
    <link type="text/css" rel="stylesheet" href="assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" />
</head>
<body class="page-error">
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
    <!-- Particles -->
    <div id="particles-js"></div>
    <!-- /particles -->
    <div class="page-error-container has-particles">
	    <div class="login-branding">
		    <a href="index.php"><?=$local_settings['appname']?><small class="version"><?=$local_settings['version']?></small></a>
	    </div>
	    <div class="page-error-content">
		    <div class="error-code"><?php echo $errnr; ?></div>
		    <h3 class="text-center text-white"><?php echo $error; ?></h3>
		    <p class="text-center"><a href="index.php" class="btn btn-primary"> Go to dashboard</a></p>
	    </div>
    </div>

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="assets/js/functions.js"></script>
    <!--Particles-->
    <script type="text/javascript" src="assets/plugins/particles/js/particles.js"></script>
    <script type="text/javascript" src="assets/plugins/particles/js/particles-script.js"></script>
    <!--Loader Js-->
    <script src="assets/js/loader.js"></script>
</body>
</html>
