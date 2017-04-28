<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
check_login($local_settings['appname']);
$devices = array();
$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$local->set_charset("utf8");
$sql="SELECT * FROM `devices`";
$result=$local->query($sql);
if($result === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$devices[] = $row;
		}
    }
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
			    <li><a href="index.php"><i class="icon-gauge"></i><span class="title">Dashboard</span></a></li>
			    <li class="has-sub"><a href="javascript:void(0);"><i class="icon-target"></i><span class="title">Tools</span></a>
				    <ul class="nav collapse">
					    <li><a href="rtu_tools.php"><span class="title">RTU Tools</span></a></li>
				    </ul>
			    </li>
			    <li class="has-sub active"><a href="javascript:void(0);"><i class="icon-cog"></i><span class="title">Settings</span></a>
				    <ul class="nav collapse">
					    <li class="active"><a href="settings_clocks.php"><span class="title">Clocks</span></a></li>
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
		        <h1 class="page-title">Settings > Clocks</h1>
		        <!-- Breadcrumb -->
		        <ol class="breadcrumb breadcrumb-2"> 
			        <li><a href="index.php"><i class="fa fa-home"></i>Home</a></li> 
			        <li>Settings</li> 
			        <li class="active"><strong>Clocks</strong></li> 
		        </ol>
                
                <?php if(!empty($devices)): ?>
                <!-- row -->
		        <div class="row">
				    <div class="col-lg-12">
					    <div class="panel panel-primary">
						    <div class="panel-heading clearfix">
							    <h4 class="panel-title text-uppercase"><i class="fa fa-clock-o" aria-hidden="true"></i>Clocks configured</h4>
							    <ul class="panel-tool-options">
									<?php if ($user_settings['level'] >= 50): ?>
									<li data-toggle="tooltip" data-placement="bottom" title="ADD A NEW CLOCK TO DB">
										<a id="add" href="modals/clocks_add.php" data-remote="true" data-toggle="modal" data-target="#modal-2" data-backdrop="static" tag="ADD A NEW CLOCK TO DB"><i class="icon-plus"></i></a>
									</li>
									<li data-toggle="tooltip" data-placement="bottom" title="REBOOT ALL CLOCKS">
										<a id="rebull" href="modals/clocks_reboot_all.php?reboot=all" data-remote="true" data-toggle="modal" data-backdrop="static" data-target="#modal-2" tag="REBOOT ALL CLOCKS"><i class="icon-retweet"></i></a>
									</li>
									<?php elseif ($user_settings['level'] >= 20): ?>
									<li data-toggle="tooltip" data-placement="bottom" title="ADD A NEW CLOCK TO DB">
										<a id="add" href="modals/clocks_add.php" data-remote="true" data-toggle="modal" data-target="#modal-2" data-backdrop="static" tag="ADD A NEW CLOCK TO DB"><i class="icon-plus"></i></a>
									</li>
									<?php endif; ?>
							    </ul>
						    </div>
						    <div class="panel-body">
							    <div class="table-responsive">
								    <table class="table table-striped table-bordered table-hover table-condensed clocks">
									    <thead>
										    <tr>
											    <th>INV</th>
											    <th>IP ADDRESS</th>
											    <th>SERIAL NO</th>
											    <th>RTU</th>
											    <th>GRP</th>
											    <th>BUILDING</th>
											    <th>FLOOR</th>
											    <th>GROUP</th>
											    <th>ART NO</th>
											    <th>TRACK</th>
											    <th>CONTROLS</th>
										    </tr>
									    </thead>
									    <tbody>
                                        <?php 
                                        foreach($devices as $clock) {
											echo "
										    <tr class=\"gradeX\">
											    <td>".$clock['inv']."</td>
											    <td>".$clock['ip']."</td>
											    <td>".strtoupper($clock['serialnumber'])."</td>
											    <td>".$clock['RTU_GRP']."</td>
											    <td>".$clock['GRP']."</td>
											    <td>".$clock['building']."</td>
											    <td>".$clock['floor']."</td>
											    <td>".$clock['groupnr']."</td>
											    <td>".$clock['art_no']."</td>";
											    if ($clock['track'] == "0") { echo "<td><span class=\"label label-danger\">NO</span></td>"; }
											    if ($clock['track'] == "1") { echo "<td><span class=\"label label-success\">YES</span></td>"; }
											    if ($user_settings['level'] >= 50) {
												    echo "
											    <td>
											    	<a id=\"edit\" href=\"modals/clocks_edit.php?serialnumber=".$clock['serialnumber']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" data-backdrop=\"static\" tag=\"EDIT CLOCK ".$clock['inv']."\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"EDIT CLOCK ".$clock['inv']."\"></i></a>

											    	<a id=\"synch\" href=\"modals/clocks_config.php?serialnumber=".$clock['serialnumber']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" data-backdrop=\"static\" tag=\"REMOTE CONFIGURE CLOCK ".$clock['inv']."\" class=\"btn btn-info btn-sm\"><i class=\"fa fa-cog\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REMOTE CONFIGURE CLOCK ".$clock['inv']."\"></i></a>
											    	
											    	<a id=\"remove\" href=\"modals/clocks_remove.php?serialnumber=".$clock['serialnumber']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" data-backdrop=\"static\" tag=\"REMOVE CLOCK ".$clock['inv']." FROM DATABASE\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-trash\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REMOVE CLOCK ".$clock['inv']." FROM DATABASE\"></i></a>
											    	
											    	<a id=\"reboot\" href=\"modals/clocks_reboot.php?serialnumber=".$clock['serialnumber']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" data-backdrop=\"static\" tag=\"REBOOT CLOCK ".$clock['inv']."\" class=\"btn btn-blue btn-sm\"><i class=\"fa fa-retweet\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REBOOT CLOCK ".$clock['inv']."\"></i></a>
											    </td>";
												} elseif ($user_settings['level'] >= 20) {
													echo "
												<td>
											    	<a id=\"edit\" href=\"modals/clocks_edit.php?serialnumber=".$clock['serialnumber']."\" data-remote=\"true\" data-toggle=\"modal\" data-target=\"#modal-2\" data-backdrop=\"static\" tag=\"EDIT CLOCK ".$clock['inv']."\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"EDIT CLOCK ".$clock['inv']."\"></i></a>

											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REMOTE CONFIGURE CLOCK ".$clock['inv']."\" class=\"btn btn-info btn-sm\" disabled=\"disabled\"><i class=\"fa fa-cog\"></i></button>
											    	
											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REMOVE CLOCK ".$clock['inv']." FROM DATABASE\" class=\"btn btn-danger btn-sm\" disabled=\"disabled\"><i class=\"fa fa-trash\"></i></button>
											    	
											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REBOOT CLOCK ".$clock['inv']."\" class=\"btn btn-blue btn-sm\" disabled=\"disabled\"><i class=\"fa fa-retweet\"></i></button>
											    </td>";
												} else {
													echo "
											    <td>
											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"EDIT CLOCK ".$clock['inv']."\" class=\"btn btn-warning btn-sm\" disabled=\"disabled\"><i class=\"fa fa-edit\"></i></button>
											    	
											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REMOTE CONFIGURE CLOCK ".$clock['inv']."\" class=\"btn btn-info btn-sm\" disabled=\"disabled\"><i class=\"fa fa-cog\"></i></button>
											    	
											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REMOVE CLOCK ".$clock['inv']." FROM DATABASE\" class=\"btn btn-danger btn-sm\" disabled=\"disabled\"><i class=\"fa fa-trash\"></i></button>
											    	
											    	<button data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"REBOOT CLOCK ".$clock['inv']."\" class=\"btn btn-blue btn-sm\" disabled=\"disabled\"><i class=\"fa fa-retweet\"></i></button>
											    </td>
													";
												}

											    echo "
										    </tr>
											";
										}
                                        ?>
									    </tbody>
									    <tfoot>
										    <tr>
											    <td>INV</td>
											    <td>IP ADDRESS</td>
											    <td>SERIAL NO</td>
											    <td>RTU</td>
											    <td>GRP</td>
											    <td>BUILDING</td>
											    <td>FLOOR</td>
											    <td>GROUP</td>
											    <td>ART NO</td>
											    <td>TRACK</td>
											    <td>CONTROLS</td>
										    </tr>
									    </tfoot>
								    </table>
							    </div>
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
							    <h4 class="panel-title text-uppercase"><i class="fa fa-clock-o" aria-hidden="true"></i>Clocks status</h4>
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
					    <div class="panel panel-danger">
						    <div class="panel-heading clearfix">
							    <h4 class="panel-title text-uppercase"><i class="fa fa-clock-o" aria-hidden="true"></i>Clock logs</h4>
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
                <!-- row -->
		        <div class="row">

				    <div class="col-md-6"> 
					    <div class="panel panel-danger">
						    <div class="panel-heading clearfix"> 
							    <h4 class="panel-title text-uppercase">UNCONFIGURED CLOCKS</h4>  
						    </div> 
						    <!-- panel body --> 
						    <div class="panel-body"> 
                                <div class="clocks-not-configured"></div>
						    </div> 
					    </div> 
				    </div> 
					
				    <div class="col-md-6"> 
					    <div class="panel panel-danger">
						    <div class="panel-heading clearfix"> 
							    <h4 class="panel-title text-uppercase">OFFLINE CLOCKS <small>(LAST HOUR)</small></h4>  
						    </div> 
						    <!-- panel body --> 
						    <div class="panel-body"> 
                                <div class="clocks-not-online"></div>
						    </div> 
					    </div> 
				    </div> 
		        </div>
		        <!-- /row -->
		        <?php else: ?>
                <!-- row -->
		        <div class="row">
			        <div class="col-lg-12">
                        <p>empty</p>
			        </div>
		        </div>
		        <!-- /row -->
		        <?php endif; ?>
		        
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
    <!-- tables -->
    <script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
    
	<link rel="stylesheet" type="text/css" href="assets/plugins/validationEngine/jquery.validationEngine.css" />
	<script type="text/javascript" src="assets/plugins/validationEngine/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="assets/plugins/validationEngine/jquery.validationEngine-en.js"></script>
		
    <script type="text/javascript">
        $(function () {
		
            if(jQuery().dataTable) {
                if($(".clocks").length > 0) { 
	                $(".clocks").DataTable({
		                dom: '<"html5buttons" B>lTfgitp',
		                buttons: [
			            {
				            extend: 'copyHtml5',
				            exportOptions: {
					            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
				            }
			            },
			            {
				            extend: 'excelHtml5',
				            exportOptions: {
					            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
				            }
			            },
			            {
				            extend: 'pdfHtml5',
				            exportOptions: {
					            columns: [ 0, 1, 2, 3, 4, 5, 6 ,7 ,8, 9 ]
				            },
                            customize: function(doc) {
                                doc.defaultStyle.fontSize = 8;
                            },
                            title: '<?=$local_settings['appname']?> - Clocks'
			            },
			            'colvis'
		                ],
                        "aoColumns": [
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": true },
				            { "bSearchable": true, "bSortable": false },
				            { "bSearchable": false, "bSortable": false },
				            { "bSearchable": false, "bSortable": false } 
                        ],
		                "aaSorting": [[ 0, "desc" ]],
				        "iDisplayLength": 25,
				        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "ALL"]]
                    });
                }
            }
 	        $("#status").load("ajax/live_status.php?x="+ Math.random());

 	        $("#reload").click(function() {
				$("#status").load("ajax/live_status.php?x="+ Math.random());
			});

 	        $("#track").load("ajax/live_clock_logs.php?x="+ Math.random());

 	        $("#reload2").click(function() {
				$("#track").load("ajax/live_clock_logs.php?x="+ Math.random());
			});
			
            $("#modal-2").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-body").load(link.attr("href"));
                $(this).find("h4.modal-title").text(link.attr("tag"));
            });
            
            if(jQuery().validationEngine) {
                $("#forms").validationEngine({promptPosition : "bottomLeft:10"});;
            }
            $.ajax({
                url: "ajax/clocks_not_online.php",
                dataType: "json",
                type: "GET",
                contentType: "application/json",
                success: function(data,textStatus,jQxhr){
                    //console.log(data);
                    if(data[0] == "0") {
					    //console.log("empty");
					    $(".clocks-not-online").append("0");
					    $(".user-info #offline-clocks").hide();
					} else {
						var count = data.length;
						$(".user-info #offline-clocks").show();
						$("#offline-clocks a#not-online span").text(count);
						$("#offline-clocks li.first strong").text(count);
						$(".clocks-not-online").empty();
						$("#offline-clocks #clocks-not-online").empty();
                        $.each(data,function(key,value) {
                            //console.log( key + ": " + value );
                            $("#offline-clocks #clocks-not-online").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-chain-broken pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                            $(".clocks-not-online").append("<p>"+value+"</p>");
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
					    $(".clocks-not-configured").append("0");
					    $(".user-info #unconfigured-clocks").hide();
					} else {
						var count = data.length;
						$(".user-info #unconfigured-clocks").show();
						$("#unconfigured-clocks a#not-configured span").text(count);
						$("#unconfigured-clocks li.first strong").text(count);
						$(".clocks-not-configured").empty();
						$("#unconfigured-clocks #clocks-not-configured").empty();
                        $.each(data,function(key,value) {
                            //console.log( key + ": " + value );
                            $("#unconfigured-clocks #clocks-not-configured").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-cog pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                            $(".clocks-not-configured").append("<p>"+value+"</p>");
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
				$("#status").load("ajax/live_status.php?x="+ Math.random());
                $("#track").load("ajax/live_clock_logs.php?x="+ Math.random());
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
						    $(".clocks-not-online").empty();
						    $("#offline-clocks #clocks-not-online").empty();
                            $.each(data,function(key,value) {
                                //console.log( key + ": " + value );
                                $("#offline-clocks #clocks-not-online").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-chain-broken pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                                $(".clocks-not-online").append("<p>"+value+"</p>");
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
						    $(".clocks-not-configured").empty();
						    $("#unconfigured-clocks #clocks-not-configured").empty();
                            $.each(data,function(key,value) {
                                //console.log( key + ": " + value );
                                $("#unconfigured-clocks #clocks-not-configured").append('<li class="unread notification-danger"><a href="#"><i class="fa fa-cog pull-right"></i><span class="block-line strong">'+value+'</span><span class="block-line small">CLOCK IS NOT ONLINE</span></a></li>');
                                $(".clocks-not-configured").append("<p>"+value+"</p>");
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
    </script>
    <script type="text/javascript" src="assets/js/loader.js"></script>
</body>
</html>
