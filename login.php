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
</head>
<body class="login-page">
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
    <div class="login-container has-particles">
	    <div class="login-branding">
		    <a href="index.php"><?=$local_settings['appname']?><small class="version"><?=$local_settings['version']?></small></a>
	    </div>
	    <div class="login-content">
		    <h2><strong>Welcome</strong>, please login</h2>
		    <form role="form" method="post" action="check.php" id="forms">                        
			    <div class="form-group">
				    <input type="text" placeholder="Username" class="form-control validate[required]" name="username" />
			    </div>                        
			    <div class="form-group">
				    <input type="password" placeholder="Password" class="form-control validate[required]" name="password" />
			    </div>
			    <div class="form-group">
				    <div class="checkbox checkbox-replace">
					    <input type="checkbox" id="remeber" />
					    <label for="remeber">Remeber me</label>
				    </div>
			    </div>
			    <div class="form-group">
				    <button class="btn btn-primary btn-block" name="submit" id="submit">Login</button>
			    </div>                     
		    </form>
	    </div>
    </div>
    <!--JavaScripts-->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="assets/js/functions.js"></script>
    <!--Particles-->
    <script type="text/javascript" src="assets/plugins/particles/js/particles.js"></script>
    <script type="text/javascript" src="assets/plugins/particles/js/particles-script.js"></script>
    <!--Validation-->
	<link rel="stylesheet" type="text/css" href="assets/plugins/validationEngine/jquery.validationEngine.css" />
	<script type="text/javascript" src="assets/plugins/validationEngine/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="assets/plugins/validationEngine/jquery.validationEngine-en.js"></script>
    <script type="text/javascript">
        $(function () {            
            if(jQuery().validationEngine) {
                $("#forms").validationEngine({promptPosition : "bottomLeft:10"});;
            }
        });
    </script>    
    <script type="text/javascript" src="assets/js/loader.js"></script>
</body>
</html>
