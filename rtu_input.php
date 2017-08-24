<?php
error_reporting(E_ALL);
define('start',TRUE);
include("inc/db.php");
include("inc/functions.php");
include("inc/config.php");
check_login($local_settings['appname']);
if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'submit') {
        $what = $_POST['what'];
        $value = $_POST['value'];
    } else if($_POST['submit'] == 'search') {
	    $name = $_POST['name'];
    } else if($_POST['submit'] == 'info') {
	    $pin = $_POST['pin'];
    }
} else {
    $what = "";
    $value = "";
    $from = "";
    $name = "";
    $pin = "";
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
			    <li><a href="watch.php" target="_blank"><i class="icon-location"></i><span class="title">Clocks Location</span></a></li>
			    <?php if ($user_settings['level'] > 10): ?>
			    <li class="has-sub active"><a href="javascript:void(0);"><i class="icon-target"></i><span class="title">Tools</span></a>
				    <ul class="nav collapse">
					    <li><a href="rtu_tools.php"><span class="title">RTU Tools</span></a></li>
					    <li class="active"><a href="rtu_input.php"><span class="title">RTU Input</span></a></li>
				    </ul>
			    </li>
			    <li class="has-sub"><a href="javascript:void(0);"><i class="icon-cog"></i><span class="title">Settings</span></a>
				    <ul class="nav collapse">
					    <li><a href="settings_clocks.php"><span class="title">Clocks</span></a></li>
					    <li><a href="settings_users.php"><span class="title">Users</span></a></li>
				    </ul>
			    </li>
                <?php endif; ?>
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
							    <h4 class="panel-title text-uppercase"><i class="fa fa-bullseye" aria-hidden="true"></i>RTU add new input</h4>
						    </div>
						    <div class="panel-body">
                                <form id="forms" class="form-horizontal" method="post" action="">
	                                <div class="form-group"> 
		                                <label class="col-sm-2 control-label">SELECT</label>
		                                <div class="col-sm-2"> 
		                                    <select class="form-control validate[required]" name="what" id="what">
												<?php if((isset($_POST['submit'])) && ($_POST['submit'] == 'submit')): ?>
												<option value="<?php echo $what; ?>"><?php echo $what; ?></option>
												<?php endif; ?>
			                                    <option></option>
			                                    <option value="PIN">PIN</option>
			                                    <option value="CARD_NO">CARD_NO</option>
			                                </select>
	                                    </div>
		                                <div class="col-sm-2">
											<?php if((isset($_POST['submit'])) && ($_POST['submit'] == 'submit')): ?>
											<input type="text" class="form-control validate[required]" name="value" id="value" value="<?php echo $value; ?>" />
											<?php else: ?>
											<input type="text" class="form-control validate[required]" name="value" id="value" value="" /> 
											<?php endif; ?>
		                                </div>
		                                <div class="col-sm-3"> 
                                            <button type="submit" class="btn btn-primary" name="submit" id="submit" value="submit">
												<i class="fa fa-share-square-o" aria-hidden="true"></i>&nbsp;GO</button>
	                                    </div> 
	                                </div>
                                </form>
                                <?php
                                if((isset($_POST['submit'])) && ($_POST['submit'] == 'submit')) {
									$EvWhen = date("Y-m-d H:i:s");
                                    try {
                                        $pdo = new PDO ("dblib:charset=UTF-8;host=$hostname:$port;dbname=$dbname;","$username","$pw");
										$stmt = $pdo->prepare("SELECT * FROM PERSON_ID_MOD WHERE ".$what."='".$value."'");
                                        if ($stmt->execute()) {
											$count = $stmt->rowCount();
											$data = array();
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												if (!empty($row)) {
												    $data[] = $row;
	                                                $CARD_GRP = preg_replace('/\s+/','',$row['CARD_GRP']);
                                                    $CARD_NO = preg_replace('/\s+/','',$row['CARD_NO']);
                                                    $FULL_NAME = $row['FULL_NAME'];
                                                    $EGN = preg_replace('/\s+/','',$row['EGN']);
                                                    $PIN = preg_replace('/\s+/','',$row['PIN']);
                                                    $GRP = preg_replace('/\s+/','',$row['GRP']);
                                                    $GRP_WHERE = preg_replace('/\s+/','',$row['GRP_WHERE']);
                                                    $TYPE_WHERE = preg_replace('/\s+/','',$row['TYPE_WHERE']);
                                                    $RTU_GRP = "285";
                                                    $RTU_NO = "9999";
                                                    $SOURCE = "A";
                                                    $RTU_SERVER = "SERVER_MC";
                                                    if ($GRP_WHERE == "10022") {
                                                        if ($TYPE_WHERE == "E") { $EvType = "I"; }
                                                        if ($TYPE_WHERE == "I") { $EvType = "E"; }
		                                            } else {
			                                            $EvType = "I";
		                                            }
												}
											}
											if (!empty($data)) {
											    array2table($data);
											    //continue
											    echo "
						 <form id=\"forms\" class=\"form-horizontal\" method=\"post\" action=\"\">
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">CARD_GRP</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"CARD_GRP\" value=\"".$CARD_GRP."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">CARD_NO</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"CARD_NO\" value=\"".$CARD_NO."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">FULL_NAME</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"FULL_NAME\" value=\"".$FULL_NAME."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">EGN</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"EGN\" value=\"".$EGN."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">PIN</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"PIN\" value=\"".$PIN."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">GRP</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"GRP\" value=\"".$GRP."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">GRP_WHERE</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"GRP_WHERE\" value=\"".$GRP_WHERE."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">TYPE_WHERE</label> 
								<div class=\"col-sm-10\"> 
									<select class=\"form-control validate[required]\" name=\"EvType\"> 
										<option value=\"".$EvType."\">$EvType</option> 
										<option></option>
										<option value=\"I\">I</option> 
										<option value=\"E\">E</option> 
									</select>
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">RTU_GRP</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"RTU_GRP\" value=\"".$RTU_GRP."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">RTU_NO</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"RTU_NO\" value=\"".$RTU_NO."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">SOURCE</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"SOURCE\" value=\"".$SOURCE."\" readonly=\"true\" /> 
								</div> 
							</div>
						 	<div class=\"form-group\"> 
								<label class=\"col-sm-2 control-label\">RTU_SERVER</label> 
								<div class=\"col-sm-10\"> 
									<input type=\"text\" class=\"form-control validate[required]\" name=\"RTU_SERVER\" value=\"".$RTU_SERVER."\" readonly=\"true\" /> 
								</div> 
							</div>
								<div class=\"form-group\"> 
									<label class=\"col-sm-2 control-label\">EvWhen</label> 
									<div class=\"col-sm-10\"> 
										<div id=\"date-popup\" class=\"input-group date\"> 
											<input type=\"text\" class=\"form-control validate[required]\" name=\"EvWhen\" value=\"".$EvWhen."\"> 
											<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span> 
										</div>
									</div> 
								</div>
							<div class=\"form-group\"> 
		                        <div class=\"col-sm-12\"> 
                                    <button type=\"submit\" class=\"btn btn-primary fr\" name=\"submit\" id=\"submit\" value=\"input\">
									    <i class=\"fa fa-share-square-o\" aria-hidden=\"true\"></i>&nbsp;INSERT</button>
	                            </div>
	                        </div>
						  </form>
											    ";

											} else {
											    echo "
                                                <div id=\"error5\">
                                                    <br/>
                                                    <div class=\"alert alert-danger\" role=\"alert\">
                                                        <strong>ERROR!</strong> PIN nOR CARD_NO is not valid.
                                                    </div>
                                                </div>";	
											}
										} else {
										    echo "error-1";	
										}
									} catch (PDOException $e) {
										echo "Failed to get DB handle: " . $e->getMessage() . "\n";
									}
									unset($stmt);
									unset($pdo); 
								}
								if((isset($_POST['submit'])) && ($_POST['submit'] == 'input')) {
								    $CARD_GRP = $_POST['CARD_GRP'];
								    $CARD_NO = $_POST['CARD_NO'];
								    $FULL_NAME = $_POST['FULL_NAME'];
								    $EGN = $_POST['EGN'];
								    $PIN = $_POST['PIN'];
								    $GRP = $_POST['GRP'];
								    $GRP_WHERE = $_POST['GRP_WHERE'];
								    $EvType = $_POST['EvType'];
								    $RTU_GRP = $_POST['RTU_GRP'];
								    $RTU_NO = $_POST['RTU_NO'];
								    $SOURCE = $_POST['SOURCE'];
								    $RTU_SERVER = $_POST['RTU_SERVER'];
								    $EvWhen = $_POST['EvWhen'];
								    try {
		$pdo = new PDO ("dblib:host=$hostname:$port;dbname=$dbname;","$username","$pw");
		
        $sql2 = "INSERT INTO RTU_RECENT_INFO (EvWhen,EvType,CARD_GRP,CARD_NO,RTU_NO,RTU_GRP,SOURCE,EGN,PIN,RTU_SERVER)
                        VALUES(:EvWhen,:EvType,:CARD_GRP,:CARD_NO,:RTU_NO,:RTU_GRP,:SOURCE,:EGN,:PIN,:RTU_SERVER)";
                                          
        $stmt2 = $pdo->prepare($sql2);
             
        $stmt2->bindParam(':EvWhen', $EvWhen, PDO::PARAM_STR);       
        $stmt2->bindParam(':EvType', $EvType, PDO::PARAM_STR);       
        $stmt2->bindParam(':CARD_GRP', $CARD_GRP, PDO::PARAM_STR);       
        $stmt2->bindParam(':CARD_NO', $CARD_NO, PDO::PARAM_STR);       
        $stmt2->bindParam(':RTU_NO', $RTU_NO, PDO::PARAM_STR);       
        $stmt2->bindParam(':RTU_GRP', $RTU_GRP, PDO::PARAM_STR);       
        $stmt2->bindParam(':SOURCE', $SOURCE, PDO::PARAM_STR);       
        $stmt2->bindParam(':EGN', $EGN, PDO::PARAM_STR);       
        $stmt2->bindParam(':PIN', $PIN, PDO::PARAM_STR);       
        //$stmt2->bindParam(':GRP', $GRP, PDO::PARAM_STR);       
        $stmt2->bindParam(':RTU_SERVER', $RTU_SERVER, PDO::PARAM_STR);              
        //$stmt2->execute();
        
        if ($stmt2->execute()) {
			$count2 = $stmt2->rowCount();
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            unset($stmt2);
        } else {
            echo "\nPDO::errorInfo():\n";
            print_r($pdo->errorInfo());
        }
                                    } catch (PDOException $e) {
	                                    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
								    }
							    }
                                ?>
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
			},60000);
        });
    </script>
    <script type="text/javascript" src="assets/js/loader.js"></script>
</body>
</html>
