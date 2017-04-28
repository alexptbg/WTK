<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_GET)) {
    $serialnumber = $_GET['serialnumber'];	
    $device = get_device_info($serialnumber);
}
if($device['ip']){
    //remote server
    define('MDB_SERVER',$device['ip']); // set database host
    define('MDB_USER','pi'); // set database user
    define('MDB_PASS','a11543395'); // set database password
    define('MDB_NAME','raspi'); // set database name
    $remote_settings = array();
    $remote = new mysqli(MDB_SERVER,MDB_USER,MDB_PASS,MDB_NAME);
	$remote->set_charset("utf8");
    $sql="SELECT * FROM `device`";
    $result=$remote->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$remote->error,E_USER_ERROR);
    } else {
        if($result->num_rows ==1) {
            $remote_settings = mysqli_fetch_assoc($result);
        }
    }
}
?>
<?php if(!empty($_GET)): ?>
<form id="forms" class="form-horizontal" method="post">
	<div class="form-group"> 
		<label class="col-sm-3 control-label">INVENTORY NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer],min[10000],max[40000],minSize[5],maxSize[5]]" name="inv" id="inv" value="<?php echo $device['inv']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">IP ADDRESS</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[ipv4]]" name="ip" id="ip" value="<?php echo $device['ip']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">SERIAL NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="serialnumber" id="serialnumber" value="<?php echo $device['serialnumber']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">RTU GRP</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" id="RTU_GRP" name="RTU_GRP">
				<option value="<?php echo $device['RTU_GRP']; ?>"><?php echo $device['RTU_GRP']; ?></option>
			</select>
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">GRP</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" id="GRP" name="GRP">
				<option value="<?php echo $device['GRP']; ?>"><?php echo $device['GRP']; ?></option>
			</select>
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">LANGUAGE</label> 
		<div class="col-sm-9"> 
			<select class="form-control validate[required]" id="lang" name="lang">
				<option value="<?php echo $remote_settings['lang']; ?>"><?php echo country($remote_settings['lang']); ?></option>
			    <option></option>
			    <option value="bg">БЪЛГАРСКИ</option>
			    <option value="en">ENGLISH</option>
			    <option value="fr">FRANÇAIS</option>
		    </select>
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">CLOCK TEXT COLOR</label> 
		<div class="col-sm-7"> 
			<select class="form-control validate[required]" id="color" name="color"> 
			    <option value="<?php echo str_replace('#','',$remote_settings['color']); ?>"><?php echo color(str_replace('#','',$remote_settings['color'])); ?></option>
			    <option></option>
			    <option value="00FFFF">AQUA</option>
                <option value="bbff02">GREEN</option>
                <option value="FFD700">GOLD</option>
                <option value="EE82EE">VIOLET</option>
                <option value="FFFF00">YELLOW</option>
		    </select>
		</div>
		<div class="col-sm-2">
			<div id="selcolor"><span class="color"></span></div>
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">TEMP FIX</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[number]]" name="tempfix" id="tempfix" value="<?php echo $remote_settings['tempfix']; ?>" />
		</div>
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">TEMP IN FIX</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[number]]" name="tempinfix" id="tempinfix" value="<?php echo $remote_settings['tempinfix']; ?>" />
		</div>
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">CPU FIX</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[number]]" name="cpufix" id="cpufix" value="<?php echo $remote_settings['cpufix']; ?>" />
		</div>
	</div>
	
	<div class="form-group"> 
		<label class="col-sm-3 control-label">BUILDING</label>
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="building" id="building" value="<?php echo $device['building']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">FLOOR</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer],min[0],max[5],minSize[1],maxSize[1]]" name="floor" id="floor" value="<?php echo $device['floor']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">GROUP</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer]]" name="groupnr" id="groupnr" value="<?php echo $device['groupnr']; ?>" readonly="readonly" />
		</div>
	</div>
	<div class="line-modal"></div>
	<div class="form-group">
	    <div class="col-sm-12">
			<div class="fr">
	            <button data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Cancel</button>
			    <button type="submit" class="btn btn-danger" name="submit" id="submit"><i class="fa fa-share-square-o" aria-hidden="true"></i>&nbsp;Synch data</button>
			</div>
		</div>
	</div>
</form>
<div id="success">
    <div class="alert alert-success" role="alert"><span id="ok"></span></div>
</div>
<div id="error1">
    <div class="alert alert-danger" role="alert"><span id="err1"></span></div>
</div>
<script type="text/javascript">
$(function () {
    var color = $("select#color").val();
    var name = $("select#color option:selected").text();
    $("#selcolor span.color").css("color", "#"+color);
    $("#selcolor span.color").text(name);
    if(jQuery().validationEngine) {
        $("#forms").validationEngine({promptPosition : "bottomLeft:10"});;
    }
    $("select#color").change(function() {
        var color = $("select#color").val();
        var name = $("select#color option:selected").text();
        $("#selcolor span.color").css({"color": "#"+color });
        $("#selcolor span.color").text(name);
    });
    jQuery("#forms").on('click', '#submit', function(e) {
      var valid = jQuery("#forms").validationEngine('validate');
      if (valid == true) {
      	//validated
      	e.preventDefault();
		var inv = jQuery("input[name='inv']").val();
		var ip = jQuery("input[name='ip']").val();
		var serialnumber = jQuery("input[name='serialnumber']").val();
		var RTU_GRP = jQuery("select[name='RTU_GRP']").val();
		var GRP = jQuery("select[name='GRP']").val();
		var lang = $("select#lang").val();
		var color = $("select#color").val();
		var tempfix = jQuery("input[name='tempfix']").val();
		var tempinfix = jQuery("input[name='tempinfix']").val();
		var cpufix = jQuery("input[name='cpufix']").val();
		var building = jQuery("input[name='building']").val();
		var flor = jQuery("input[name='floor']").val();
		var groupnr = jQuery("input[name='groupnr']").val();

        var datastr = 'inv='+inv+'&ip='+ip+'&serialnumber='+serialnumber+'&RTU_GRP='+RTU_GRP+'&GRP='+GRP+'&lang='+lang+'&color='+color+'&tempfix='+tempfix+'&tempinfix='+tempinfix+'&cpufix='+cpufix+'&building='+building+'&floor='+flor+'&groupnr='+groupnr;
        //console.log(datastr);
        send(datastr);
      } else {
      	e.preventDefault();
      }
    });
    function send(data) {
		//console.log(data);
        jQuery.ajax({
            type: "POST",
            url: "ajax/clocks_config.php",
            data: data,
            success: function(data){
				//console.log(data);
				jQuery("#error1").hide();
				if (data[0]) {
				    if(data[0].name == "err") {
					    jQuery("span#err1").html("<strong>Error "+data[0].errnr+"</strong> -> "+data[0].error);
                        jQuery("#error1").show();
                    }
			    }
				if(data.name == "data") {
                    jQuery("#forms").hide();
                    jQuery("span#ok").html("<strong>OK</strong> -> "+data.msg);
                    jQuery("#success").show();
		            setTimeout(function(){
					    jQuery("#modal-2").modal("hide");
				    },1200);
				}
            },
            error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
            },
        });
        return false;
    }
});
</script>
<?php else: ?>
<?php endif; ?>
