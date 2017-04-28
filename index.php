<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
check_login($local_settings['appname']);
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
			            <small class="version"><?=$local_settings['version']?></small></a>
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
			    <li class="has-sub"><a href="javascript:void(0);"><i class="icon-target"></i><span class="title">Tools</span></a>
				    <ul class="nav collapse">
					    <li><a href="rtu_tools.php"><span class="title">RTU Tools</span></a></li>
				    </ul>
			    </li>
			    <li class="has-sub"><a href="javascript:void(0);"><i class="icon-cog"></i><span class="title">Settings</span></a>
				    <ul class="nav collapse">
					    <li><a href="settings_clocks.php"><span class="title">Clocks</span></a></li>
					    <li><a href="settings_users.php"><span class="title">Users</span></a></li>
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
								<img width="44" class="img-circle avatar" alt="user" src="assets/img/user.png" /><?php echo $user_settings['username']; ?>
								<small class="level">[<?php echo $user_settings['level']; ?>]</small><span class="caret"></span>
							</a>
			                <!-- User action menu -->
                            <ul class="dropdown-menu">
                                <li><a href="#/"><i class="icon-user"></i>My profile</a></li>
			                    <li class="divider"></li>
			                    <li><a href="#"><i class="icon-cog"></i>Account settings</a></li>
			                    <li><a href="logout.php"><i class="icon-logout"></i>Logout</a></li>
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
			                <li class="notifications dropdown" id="offline-clocks">
				                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#" id="not-online" title="OFFLINE CLOCKS">
									<i class="icon-attention"></i><span class="badge badge-danger">0</span>
								</a>
				                <ul class="dropdown-menu pull-right">
					                <li class="first">
						                <div class="small">OFFLINE CLOCKS<span class="pull-right">YOU HAVE <strong>0</strong> NOTIFICATIONS</span></div>
					                </li>
					                <li>
						                <ul class="dropdown-list" id="clocks-not-online"></ul>
					                </li>
					                <li class="external-last"> <a href="#">VIEW ALL LAST NOTIFICATIONS</a></li>
				                </ul>
			                </li>
			                <!-- /notifications -->
			                <!-- Notifications -->
			                <li class="notifications dropdown" id="cpu-clocks">
				                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#" id="cpu-warn" title="CPU TEMPS">
									<i class="icon-thermometer"></i><span class="badge badge-danger">0</span>
								</a>
				                <ul class="dropdown-menu pull-right">
					                <li class="first">
						                <div class="small">CPU TEMPS WARN<span class="pull-right">YOU HAVE <strong>0</strong> NOTIFICATIONS</span></div>
					                </li>
					                <li>
						                <ul class="dropdown-list" id="clocks-temp"></ul>
					                </li>
					                <li class="external-last"> <a href="#">VIEW ALL LAST NOTIFICATIONS</a></li>
				                </ul>
			                </li>
			                <!-- /notifications -->
			                <!-- Notifications -->
			                <li class="notifications dropdown" id="unconfigured-clocks">
				                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#" id="not-configured" title="UNCONFIGURED CLOCKS">
									<i class="icon-info-circled"></i><span class="badge badge-danger">0</span>
								</a>
				                <ul class="dropdown-menu pull-right">
					                <li class="first">
						                <div class="small">UNCONFIGURED CLOCKS<span class="pull-right">YOU HAVE <strong>0</strong> NOTIFICATIONS</span></div>
					                </li>
					                <li>
						                <ul class="dropdown-list" id="clocks-not-configured"></ul>
					                </li>
					                <li class="external-last"> <a href="#">VIEW ALL LAST NOTIFICATIONS</a></li>
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

		        <!-- row -->
		        <div class="row">
			        <div class="col-lg-12">
					    <div class="panel panel-primary">
						    <div class="panel-heading clearfix">
							    <h4 class="panel-title text-uppercase"><i class="fa fa-clock-o" aria-hidden="true"></i>Clocks Status</h4>
							    <ul class="panel-tool-options"> 
								    <li><a data-rel="reload" id="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
							    </ul>
						    </div>
						    <div class="panel-body">
								<div class="data" id="status"></div>
							</div>
						</div>
			        </div>
		        </div>
		        <!-- /row -->
		        <!-- row -->
		        <div class="row">
			        <div class="col-lg-12">
					    <div class="panel panel-primary">
						    <div class="panel-heading clearfix">
							    <h4 class="panel-title text-uppercase"><i class="fa fa-clock-o" aria-hidden="true"></i>Clock alarms</h4>
							    <ul class="panel-tool-options"> 
								    <li><a data-rel="reload" id="reload2" href="#"><i class="icon-arrows-ccw"></i></a></li>
							    </ul>
						    </div>
						    <div class="panel-body">
								<div class="data" id="track"></div>
							</div>
						</div>
			        </div>
		        </div>
		        <!-- /row -->
		
		
	        </div>
	        <!-- /main content -->
	  
		    <!-- Footer -->
		    <footer class="footer-main"> 
			    &copy; <script type="text/javascript">document.write(new Date().getFullYear())</script> <strong><?=$local_settings['appname']?></strong> by Soares
		    </footer>	
		    <!-- /footer -->
		        
            <!--Dynamic Modal-->
            <div id="modal-2" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
            <!--End Dynamic Modal-->
            
        </div>
        <!-- /main container -->
  
    </div>
    <!-- /page container -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="assets/js/functions.js"></script>
    
    <script type="text/javascript" src="assets/plugins/blockui-master/js/jquery-ui.js"></script>
    <script type="text/javascript" src="assets/plugins/blockui-master/js/jquery.blockUI.js"></script>
    
	<link rel="stylesheet" type="text/css" href="assets/plugins/validationEngine/jquery.validationEngine.css" />
	<script type="text/javascript" src="assets/plugins/validationEngine/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="assets/plugins/validationEngine/jquery.validationEngine-en.js"></script>
	
    <script type="text/javascript">
        $(function () {
 	        $("#status").load("ajax/live_dashboard.php?x="+ Math.random());

 	        $("#reload").click(function() {
				$("#status").load("ajax/live_dashboard.php?x="+ Math.random());
			});
			
 	        $("#track").load("ajax/live_track.php?x="+ Math.random());

 	        $("#reload2").click(function() {
				$("#track").load("ajax/live_track.php?x="+ Math.random());
			});
			
            $("#modal-2").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-body").load(link.attr("href"));
                $(this).find("h4.modal-title").text(link.attr("tag"));
            });
			
            $.ajax({
                url: "ajax/clocks_not_online.php",
                dataType: "json",
                type: "GET",
                contentType: "application/json",
                success: function(data,textStatus,jQxhr){
                    //console.log(data);
                    if(data[0] == "0") {
					    //console.log("empty");
					    $(".user-info #offline-clocks").hide();
					} else {
						var count = data.length;
						$(".user-info #offline-clocks").show();
						$("#offline-clocks a#not-online span").text(count);
						$("#offline-clocks li.first strong").text(count);
						$("#offline-clocks #clocks-not-online").empty();
                        $.each(data,function(key,value) {
                            //console.log( key + ": " + value );
                            $("#offline-clocks #clocks-not-online").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-chain-broken pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                        });
					}
                },
                error: function(jqXhr,textStatus,errorThrown){
                    console.log(errorThrown);
                },
                timeout: 3000,
                cache: false
            });
            $.ajax({
                url: "ajax/clocks_cpu_temp.php",
                dataType: "json",
                type: "GET",
                contentType: "application/json",
                success: function(data,textStatus,jQxhr){
                    if(data[0] == "0") {
					    //console.log("empty");
					    $(".user-info #cpu-clocks").hide();
					} else {
						var count = data.length;
						var cl = "tt-warning";
						$(".user-info #cpu-clocks").show();
						$("#cpu-clocks a#cpu-warn span").text(count);
						$("#cpu-clocks li.first strong").text(count);
						$("#cpu-clocks #clocks-temp").empty();
                        $.each(data,function(index,value) {
                            //console.log(index+":"+value[0]);
                            if (value[1] > 65) {
							    cl = "tt-danger";
							} else {
								cl = "tt-warning";
							}
                            $("#cpu-clocks #clocks-temp").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-thermometer-full pull-right"></i><span class="block-line strong">'+value[0]+'</span><span class="block-line '+cl+' small">'+value[1]+' &deg;C</span></a></li>');
                        });
					}
                },
                error: function(jqXhr,textStatus,errorThrown){
                    console.log(errorThrown);
                },
                timeout: 3000,
                cache: false
            });
            $.ajax({
                url: "ajax/clocks_not_configured.php",
                dataType: "json",
                type: "GET",
                contentType: "application/json",
                success: function(data,textStatus,jQxhr){
                    //console.log(data);
                    if(data[0] == "0") {
					    //console.log("empty");
					    $(".user-info #unconfigured-clocks").hide();
					} else {
						var count = data.length;
						$(".user-info #unconfigured-clocks").show();
						$("#unconfigured-clocks a#not-configured span").text(count);
						$("#unconfigured-clocks li.first strong").text(count);
						$("#unconfigured-clocks #clocks-not-configured").empty();
                        $.each(data,function(key,value) {
                            //console.log( key + ": " + value );
                            $("#unconfigured-clocks #clocks-not-configured").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-cog pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                        });
					}
                },
                error: function(jqXhr,textStatus,errorThrown){
                    console.log(errorThrown);
                },
                timeout: 3000,
                cache: false
            });
			
            //TIMERS
 	        setInterval(function(){
				$("#status").load("ajax/live_dashboard.php?x="+ Math.random());
                $("#track").load("ajax/live_track.php?x="+ Math.random());
			},15000);
			
 	        setInterval(function(){
                $.ajax({
                    url: "ajax/clocks_not_online.php",
                    dataType: "json",
                    type: "GET",
                    contentType: "application/json",
                    success: function(data,textStatus,jQxhr){
                        //console.log(data);
                        if(data[0] == "0") {
					        //console.log("empty");
					        $(".user-info #offline-clocks").hide();
					    } else {
						    var count = data.length;
						    $(".user-info #offline-clocks").show();
						    $("#offline-clocks a#not-online span").text(count);
						    $("#offline-clocks li.first strong").text(count);
						    $("#offline-clocks #clocks-not-online").empty();
                            $.each(data,function(key,value) {
                                //console.log( key + ": " + value );
                                $("#offline-clocks #clocks-not-online").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-chain-broken pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                            });
                            //test audio alarm
                            /*
                            var audioElement = document.createElement('audio');
                            audioElement.setAttribute('src', 'assets/raw/pager.mp3');
                            audioElement.setAttribute('autoplay', 'autoplay');
                            $.get();
                            audioElement.addEventListener("load", function() {
                                audioElement.play();
                            }, true);
                            */
					    }
                    },
                    error: function(jqXhr,textStatus,errorThrown){
                        console.log(errorThrown);
                    },
                    timeout: 3000,
                    cache: false
                });
                $.ajax({
                    url: "ajax/clocks_cpu_temp.php",
                    dataType: "json",
                    type: "GET",
                    contentType: "application/json",
                    success: function(data,textStatus,jQxhr){
                        if(data[0] == "0") {
					        //console.log("empty");
					        $(".user-info #cpu-clocks").hide();
					    } else {
						    var count = data.length;
						    var cl = "tt-warning";
						    $(".user-info #cpu-clocks").show();
						    $("#cpu-clocks a#cpu-warn span").text(count);
						    $("#cpu-clocks li.first strong").text(count);
						    $("#cpu-clocks #clocks-temp").empty();
                            $.each(data,function(index,value) {
                                //console.log(index+":"+value[0]);
                                if (value[1] > 65) {
							        cl = "tt-danger";
							    } else {
								    cl = "tt-warning";
							    }
                                $("#cpu-clocks #clocks-temp").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-thermometer-full pull-right"></i><span class="block-line strong">'+value[0]+'</span><span class="block-line '+cl+' small">'+value[1]+' &deg;C</span></a></li>');
                            });
					    }
                    },
                    error: function(jqXhr,textStatus,errorThrown){
                        console.log(errorThrown);
                    },
                    timeout: 3000,
                    cache: false
                });
                $.ajax({
                    url: "ajax/clocks_not_configured.php",
                    dataType: "json",
                    type: "GET",
                    contentType: "application/json",
                    success: function(data,textStatus,jQxhr){
                        //console.log(data);
                        if(data[0] == "0") {
					        //console.log("empty");
					        $(".user-info #unconfigured-clocks").hide();
					    } else {
						    var count = data.length;
						    $(".user-info #unconfigured-clocks").show();
						    $("#unconfigured-clocks a#not-configured span").text(count);
						    $("#unconfigured-clocks li.first strong").text(count);
						    $("#unconfigured-clocks #clocks-not-configured").empty();
                            $.each(data,function(key,value) {
                                //console.log( key + ": " + value );
                                $("#unconfigured-clocks #clocks-not-configured").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-cog pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                            });
					    }
                    },
                    error: function(jqXhr,textStatus,errorThrown){
                        console.log(errorThrown);
                    },
                    timeout: 3000,
                    cache: false
                });
			},60000);
        });
        //user-agent
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
        if(isAndroid) {
        	//TOAST
        	/*
            var f = function(){
                showNotification("Title,\r\nThis is a notification message!");
            }
            setInterval(f,10000);
            
            //NOTIFY
            setTimeout(function(){ showNotification("Title,\r\nThis is a notification message!"); },3000);
            */
        } else {
        	//do nothing for now
        	/*
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', 'assets/raw/pager.mp3');
            audioElement.setAttribute('autoplay', 'autoplay');
            //audioElement.load()
            $.get();
            audioElement.addEventListener("load", function() {
                audioElement.play();
            }, true);
			*/
		}
    </script>
    <script type="text/javascript" src="assets/js/loader.js"></script>

</body>
</html>
