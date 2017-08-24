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
    <style>
    .btn {
	    padding:12px;
	    margin:5px;
	    text-align:center;
	    vertical-align:middle;
	}
	.btn:first-child {
		margin-left:0;
	}
	.btn:last-child {
		margin-right:0;
	}
	.controls {
	    width:25%;
	    margin:0 auto;
	    text-align:center;
	    vertical-align:middle;
	}
	.redhotspot {
        border:1px solid #b30000;
        background:#FF0000;	
	}
	.orangehotspot {
        border:1px solid #ff9900;
        background:#ffcc00;
	}
    .greenhotspot {
        border:1px solid #99e600;
        background:#bbff02;	
	}
    .bluehotspot {
        border:1px solid #00cccc;
        background:#00ffff;	
	}
    .blink {
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
        -moz-animation-name: blinker;
        -moz-animation-duration: 1s;
        -moz-animation-timing-function: linear;
        -moz-animation-iteration-count: infinite;
        animation-name: blinker;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }
    @-moz-keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.7; }
        100% { opacity: 1.0; }
    }
    @-webkit-keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.7; }
        100% { opacity: 1.0; }
    }
    @keyframes blinker {  
        0% { opacity: 1.0; }
        50% { opacity: 0.7; }
        100% { opacity: 1.0; }
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
		    <div class="col-sm-12 col-lg-12 col-md-12 col-xm-12">

                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <div class="imagehotspot-container" id="b1" style="position: relative; width: 100%; height: auto; z-index: 101; overflow: hidden">
								<img src="watch/img/b1.jpg" class="boss1" />
                                <div></div>
                            </div>
                        </li>
    
                        <li>
                            <div class="imagehotspot-container" id="b2" style="position: relative; width: 100%; height: auto; z-index: 101; overflow: hidden">
								<img src="watch/img/b2.jpg" class="boss2" />
                                <div></div>
                            </div>
                        </li>

                        <li>
                            <div class="imagehotspot-container" id="s1" style="position: relative; width: 100%; height: auto; z-index: 101; overflow: hidden">
								<img src="watch/img/s1.jpg" class="strellson1" />
                                <div></div>
                            </div>
                        </li>
    
                        <li>
                            <div class="imagehotspot-container" id="s2" style="position: relative; width: 100%; height: auto; z-index: 101; overflow: hidden">
								<img src="watch/img/s2.jpg" class="strellson2" />
                                <div></div>
                            </div>
                        </li>
                        
                        <li>
                            <div class="imagehotspot-container" id="others" style="position: relative; width: 100%; height: auto; z-index: 101; overflow: hidden">
								<img src="watch/img/others.jpg" class="others" />
                                <div></div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="controls">
                    <button class="btn btn-lg btn-primary" type="button" id="prev"><i class="fa fa-backward" aria-hidden="true"></i></button>
                    <button class="btn btn-lg btn-primary" type="button" id="stop"><i class="fa fa-stop" aria-hidden="true"></i></button>
                    <button class="btn btn-lg btn-primary" type="button" id="state"><i class="fa fa-pause" aria-hidden="true"></i></button>
                    <button class="btn btn-lg btn-primary" type="button" id="next"><i class="fa fa-forward" aria-hidden="true"></i></button>
                    <button class="btn btn-lg btn-primary" type="button" id="refresh"><i class="fa fa-refresh" aria-hidden="true"></i></button> 
                </div>

		    </div>			
	    </div>
    </div>

    <!--JavaScripts-->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="watch/js/jquery.easing.1.3.js"></script>

    <link type="text/css" rel="stylesheet" href="watch/css/flexslider.css" />
    <script type="text/javascript" src="watch/js/jquery.flexslider-min.js"></script>

    <link type="text/css" rel="stylesheet" href="watch/css/litetooltip.css" />
    <script type="text/javascript" src="watch/js/tt.js"></script>
    <script>
    $(function () {
		//slider init
        $('.flexslider').flexslider({
            animation: "slide",
            slideshowSpeed: 5000,
            animationSpeed: 1000,
            initDelay: 500,
            touch: true,
            pauseOnHover: false,
            pauseOnAction: false,
            controlNav: false,
            directionNav: false
        });
        //controls
 	    $("#prev").click(function() {
            $('.flexslider').flexslider("prev");
		});
 	    $("#stop").click(function() {
            if($("#state").hasClass("activated")) {
                //do nothing
            } else {      
                $("#state").addClass("activated");
			    $(".flexslider").flexslider("stop");
                $("#state i").removeClass();
                $("#state i").addClass("fa fa-play");
			    //console.log("stop!");
            }
		});
 	    $("#state").click(function() {
            if($("#state").hasClass("activated")) {
				$("#state").removeClass("activated");
			    $(".flexslider").flexslider("play");
                $("#state i").removeClass();
                $("#state i").addClass("fa fa-pause");
			    //console.log("play!");
            } else {      
                $("#state").addClass("activated");
			    $(".flexslider").flexslider("pause");
                $("#state i").removeClass();
                $("#state i").addClass("fa fa-play");
			    //console.log("pause!");
            }
            //console.log($(this).attr("class"));
		});
 	    $("#next").click(function() {
            $('.flexslider').flexslider("next");
		});
        $("#refresh").click(function(x) {
            x.preventDefault();
            window.location.reload(true);
        });
        //get coords
        $(".imagehotspot-container").click(function(e) {
            var percX = e.offsetX/ $(this).width() * 100;
            var percY = e.offsetY/ $(this).height() * 100;
            console.log("X: "+e.offsetX + " | " + percX + " %");
            console.log("Y: "+e.offsetY + " | " + percY + " %");
                $("#state").addClass("activated");
			    $(".flexslider").flexslider("stop");
                $("#state i").removeClass();
                $("#state i").addClass("fa fa-play");
        });
        
        
        $(".imagehotspot-container").on({
            mouseenter: function () {
                //console.log("enter!");
            },
            mouseleave: function () {
                //console.log("leave!");
            }
        });
        
        function blinker() {
            $('.blink').fadeOut(500);
            $('.blink').fadeIn(500);
        }
        setInterval(blinker,1000);
        
        //js templatename //info: HuskyBlue //danger: HotRed //warning: MustardSun //success: PaleMint
        //hotspot classes //info: bluehotspot //danger: redhotspot //warning: orangehotspot //success: greenhotspot
        
        function isEven(value) {
	        if (value%2 == 0) {
		        return true;
	        } else {
		        return false;
		    }
        }
        
        //boss 1
        $.ajax({
            url: "ajax/watch.php?slider_no=1",
            dataType: "json",
            type: "GET",
            contentType: "application/json",
            success: function(data,textStatus,jQxhr){
                var div = "";
                var elements = [];
                var tips = [];
                var templates = [];
                var x = 0;
                //loop
                $.each(data, function (i,res){
                    //console.log(res);
                    div += '<div class="'+res.spotcolor+' blink" id="b1hotspot'+res.id+'" style="position:absolute; z-index:103; width:14px; height:14px; top:'+res.mapy+'%; left:'+res.mapx+'%;"></div>';
                    elements[i] = '#b1hotspot'+res.id;
                    templates[i] = res.template;
                    tips[i] = '<div class="template">' +
                                '<h4><strong>CLOCK '+res.inv+'</strong></h4>' +
                                '<p style="padding:5px; font-size:11px; line-height:16px;"><strong>DATE TIME:</strong> '+res.dtime+'<br/>' +
                                '<strong>SERIAL NO:</strong> '+res.serial+'<br/>' +
                                '<strong>IP ADDRESS:</strong> '+res.ip+'<br/>' +
                                '<strong>IP STATUS:</strong> '+res.ipstatus+'<br/>' +
                                '<strong>CPU TEMP:</strong> '+res.cputemp+'<br/>' +
                                '<strong>TIMESTAMP:</strong> '+res.timestamp+'<br/>' +
                                '<strong>TIME:</strong> '+res.shelltime+' / '+res.phptime+'<br/>' +
                                '<strong>TEMP IN:</strong> '+res.tempin+'<br/>' +
                                '<strong>SENSOR:</strong> '+res.tempsensor+'<br/>' +
                                '<strong>TTY:</strong> '+res.tty+' / '+res.ttydevice+'<br/>' +
                                '<strong>SOCKET:</strong> '+res.socket+'<br/>' +
                                '<strong>PING:</strong> '+res.ping+'<br/>' +
                                '<strong>REVISION:</strong> '+res.revision+'<br/>' +
                                '<strong>CARDS:</strong> '+res.reads+'</p>' +
                            '</div>';
                });
                $("#b1 div").html(div);
                $(elements).each(function(i,element) {
                	var ipos = 'left';
                	if (isEven(i)) {
						ipos = 'left';
					} else {
						ipos = 'right';
					}
                    $(element).LiteTooltip({
                        location: ipos,
                        textalign: 'left',
                        templatename: templates[i],
                        trigger: 'hoverable',
                        padding: 5,
                        title: tips[i]
                    });
                    x++;
                });
            },
            error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
            },
            timeout: 3000,
            cache: false
        });
        
        //boss 2
        $.ajax({
            url: "ajax/watch.php?slider_no=2",
            dataType: "json",
            type: "GET",
            contentType: "application/json",
            success: function(data,textStatus,jQxhr){
                var div = "";
                var elements = [];
                var tips = [];
                var templates = [];
                var x = 0;
                //loop
                $.each(data, function (i,res){
                    //console.log(res);
                    div += '<div class="'+res.spotcolor+' blink" id="b2hotspot'+res.id+'" style="position:absolute; z-index:103; width:14px; height:14px; top:'+res.mapy+'%; left:'+res.mapx+'%;"></div>';
                    elements[i] = '#b2hotspot'+res.id;
                    templates[i] = res.template;
                    tips[i] = '<div class="template">' +
                                '<h4><strong>CLOCK '+res.inv+'</strong></h4>' +
                                '<p style="padding:5px; font-size:11px; line-height:16px;"><strong>DATE TIME:</strong> '+res.dtime+'<br/>' +
                                '<strong>SERIAL NO:</strong> '+res.serial+'<br/>' +
                                '<strong>IP ADDRESS:</strong> '+res.ip+'<br/>' +
                                '<strong>IP STATUS:</strong> '+res.ipstatus+'<br/>' +
                                '<strong>CPU TEMP:</strong> '+res.cputemp+'<br/>' +
                                '<strong>TIMESTAMP:</strong> '+res.timestamp+'<br/>' +
                                '<strong>TIME:</strong> '+res.shelltime+' / '+res.phptime+'<br/>' +
                                '<strong>TEMP IN:</strong> '+res.tempin+'<br/>' +
                                '<strong>SENSOR:</strong> '+res.tempsensor+'<br/>' +
                                '<strong>TTY:</strong> '+res.tty+' / '+res.ttydevice+'<br/>' +
                                '<strong>SOCKET:</strong> '+res.socket+'<br/>' +
                                '<strong>PING:</strong> '+res.ping+'<br/>' +
                                '<strong>REVISION:</strong> '+res.revision+'<br/>' +
                                '<strong>CARDS:</strong> '+res.reads+'</p>' +
                            '</div>';
                });
                $("#b2 div").html(div);
                $(elements).each(function(i,element) {
                	var ipos = 'left';
                	if (isEven(i)) {
						ipos = 'left';
					} else {
						ipos = 'right';
					}
                    $(element).LiteTooltip({
                        location: ipos,
                        textalign: 'left',
                        templatename: templates[i],
                        trigger: 'hoverable',
                        padding: 5,
                        title: tips[i]
                    });
                    x++;
                });
            },
            error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
            },
            timeout: 3000,
            cache: false
        });
        
        //others
        $.ajax({
            url: "ajax/watch.php?slider_no=5",
            dataType: "json",
            type: "GET",
            contentType: "application/json",
            success: function(data,textStatus,jQxhr){
                var div = "";
                var elements = [];
                var tips = [];
                var templates = [];
                var x = 0;
                //loop
                $.each(data, function (i,res){
                    //console.log(res);
                    div += '<div class="'+res.spotcolor+' blink" id="othershotspot'+res.id+'" style="position:absolute; z-index:103; width:14px; height:14px; top:'+res.mapy+'%; left:'+res.mapx+'%;"></div>';
                    elements[i] = '#othershotspot'+res.id;
                    templates[i] = res.template;
                    tips[i] = '<div class="template">' +
                                '<h4><strong>CLOCK '+res.inv+'</strong></h4>' +
                                '<p style="padding:5px; font-size:11px; line-height:16px;"><strong>DATE TIME:</strong> '+res.dtime+'<br/>' +
                                '<strong>SERIAL NO:</strong> '+res.serial+'<br/>' +
                                '<strong>IP ADDRESS:</strong> '+res.ip+'<br/>' +
                                '<strong>IP STATUS:</strong> '+res.ipstatus+'<br/>' +
                                '<strong>CPU TEMP:</strong> '+res.cputemp+'<br/>' +
                                '<strong>TIMESTAMP:</strong> '+res.timestamp+'<br/>' +
                                '<strong>TIME:</strong> '+res.shelltime+' / '+res.phptime+'<br/>' +
                                '<strong>TEMP IN:</strong> '+res.tempin+'<br/>' +
                                '<strong>SENSOR:</strong> '+res.tempsensor+'<br/>' +
                                '<strong>TTY:</strong> '+res.tty+' / '+res.ttydevice+'<br/>' +
                                '<strong>SOCKET:</strong> '+res.socket+'<br/>' +
                                '<strong>PING:</strong> '+res.ping+'<br/>' +
                                '<strong>REVISION:</strong> '+res.revision+'<br/>' +
                                '<strong>CARDS:</strong> '+res.reads+'</p>' +
                            '</div>';
                });
                $("#others div").html(div);
                $(elements).each(function(i,element) {
                	var ipos = 'left';
                	if (isEven(i)) {
						ipos = 'left';
					} else {
						ipos = 'right';
					}
                    $(element).LiteTooltip({
                        location: ipos,
                        textalign: 'left',
                        templatename: templates[i],
                        trigger: 'hoverable',
                        padding: 5,
                        title: tips[i]
                    });
                    x++;
                });
            },
            error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
            },
            timeout: 3000,
            cache: false
        });
        
    });

    </script>
    <script type="text/javascript" src="assets/js/loader.js"></script>
</body>
</html>
