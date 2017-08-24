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
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link type="text/css" rel="stylesheet" href="assets/css/entypo.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/ka-ex.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/core.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/forms.css" />
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

    <!-- Page container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar">
  		    <!-- Site header  -->
		    <header class="site-header">
		        <div class="site-logo">
			        <a href="index.php"><?=$local_settings['appname']?>
			            <small class="version">1.0</small></a>
		        </div>
		        <div class="sidebar-collapse hidden-xs">
			        <a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
		        <div class="sidebar-mobile-menu visible-xs">
			        <a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
		    </header>
		    <!-- /site header -->
		
		    <!-- Main navigation -->
		    <ul id="side-nav" class="main-menu navbar-collapse collapse">
			    <li class="active"><a href="index.php"><i class="icon-gauge"></i><span class="title">Dashboard</span></a></li>
			    <li class="has-sub"><a href="javascript:void(0);"><i class="icon-cog"></i><span class="title">Settings</span></a>
				    <ul class="nav collapse">
					    <li><a href="#"><span class="title">Clocks</span></a></li>
				    </ul>
			    </li>

		    </ul>
		    <!-- /main navigation -->		
        </div>
        <!-- /page sidebar -->
  
        <!-- Main container -->
        <div class="main-container">
  
	        <!-- Main header -->
            <div class="main-header row">
                <div class="col-sm-6 col-xs-7">
		            <!-- User info -->
                    <ul class="user-info pull-left">          
                        <li class="profile-info dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
								<img width="44" class="img-circle avatar" alt="user" src="assets/img/user.png" />Username <span class="caret"></span>
							</a>
			                <!-- User action menu -->
                            <ul class="dropdown-menu">
                                <li><a href="#/"><i class="icon-user"></i>My profile</a></li>
			                    <li class="divider"></li>
			                    <li><a href="#"><i class="icon-cog"></i>Account settings</a></li>
			                    <li><a href="#"><i class="icon-logout"></i>Logout</a></li>
                            </ul>
			                <!-- /user action menu -->
                        </li>
                    </ul>
		            <!-- /user info -->
                </div>
	  
                <div class="col-sm-6 col-xs-5">
	  	            <div class="pull-right">
			            <!-- User alerts -->
			            <ul class="user-info pull-left">
			                <!-- Notifications -->
			                <li class="notifications dropdown">
				                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#">
									<i class="icon-attention"></i><span class="badge badge-info">2</span>
								</a>
				                <ul class="dropdown-menu pull-right">
					                <li class="first">
						                <div class="small"><a class="pull-right" href="#">Mark all Read</a> You have <strong>2</strong> new notifications.</div>
					                </li>
					                <li>
						                <ul class="dropdown-list">
							                <li class="unread notification-success"><a href="#"><i class="icon-user-add pull-right"></i>
							                    <span class="block-line strong">New user registered</span>
							                        <span class="block-line small">30 seconds ago</span></a>
							                </li>
							                <li class="unread notification-secondary"><a href="#"><i class="icon-heart pull-right"></i>
							                    <span class="block-line strong">Someone special liked this</span>
							                        <span class="block-line small">60 seconds ago</span></a>
							                </li>
						                </ul>
					                </li>
					                <li class="external-last"> <a href="#">View all notifications</a></li>
				                </ul>
			                </li>
			                <!-- /notifications -->			  
			            </ul>
			            <!-- /user alerts -->
		            </div>
                </div>
            </div>
	        <!-- /main header -->
	
	        <!-- Main content -->
	        <div class="main-content">
		        <!--<h1 class="page-title">Page Title</h1>-->
		        <!-- Breadcrumb -->
		        <!--
		        <ol class="breadcrumb breadcrumb-2"> 
			        <li><a href="index.html"><i class="fa fa-home"></i>Home</a></li> 
			        <li><a href="login.html">Various Screens</a></li> 
			        <li class="active"><strong>Blank Page</strong></li> 
		        </ol>
		        -->
		        <div class="row">
			        <div class="col-lg-12">
				        <?php
	                    $local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	                    $local->set_charset("utf8");
                        $sql="SELECT * FROM `devices`";
                        $result=$local->query($sql);
                        if($result === false) {
                            trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
                        } else {
                            if($result->num_rows > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
							        print_r($row);	
							    }
                            }
                        }
				        ?>
			        </div>
		        </div>
		

		
	        </div>
	        <!-- /main content -->
	  
		    <!-- Footer -->
		    <footer class="footer-main"> 
			    &copy; <script type="text/javascript">document.write(new Date().getFullYear())</script> <strong><?=$local_settings['appname']?></strong> by Soares
		    </footer>	
		    <!-- /footer -->
		        
        </div>
        <!-- /main container -->
  
    </div>
    <!-- /page container -->

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="assets/js/functions.js"></script>
    <script type="text/javascript" src="assets/js/loader.js"></script>

</body>
</html>
