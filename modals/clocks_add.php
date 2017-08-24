<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
?>
<form id="forms" class="form-horizontal" method="post">
	<div class="form-group"> 
		<label class="col-sm-3 control-label">INVENTORY NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer],min[10000],max[40000],minSize[5],maxSize[5]]" name="inv" id="inv" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">PLACE</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="place" id="place" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">IP ADDRESS</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[ipv4]]" name="ip" id="ip" value="<?php if(isset($_GET['ip'])) { echo $_GET['ip']; } ?>" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">SERIAL NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="serialnumber" id="serialnumber" value="<?php if(isset($_GET['serialnumber'])) { echo $_GET['serialnumber']; } ?>"/> 
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">RTU GRP</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" id="RTU_GRP" name="RTU_GRP"> 
				<option></option>
			</select>
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">GRP</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" id="GRP" name="GRP"> 
				<option></option>
			</select>
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">BUILDING</label>
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="building" id="building" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">FLOOR</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer],min[0],max[5],minSize[1],maxSize[1]]" name="floor" id="floor" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">GROUP</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer]]" name="groupnr" id="groupnr" />
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">ART NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control" name="art_no" id="art_no" />
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">TRACK</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" name="track" id="track"> 
			    <option></option> 
			    <option value="0">NO</option>
			    <option value="1">YES</option>
			</select>
	    </div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">INSTALL DATE</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control" name="mounted" id="mounted" />
		</div>
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">MAP X</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[number]]" name="mapx" id="mapx" />
		</div>
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">MAP Y</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[number]]" name="mapy" id="mapy" />
		</div>
	</div>
	<div class="line-modal"></div>
	<div class="form-group">
	    <div class="col-sm-12">
			<div class="fr">
	            <button data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Cancel</button>
			    <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save changes</button>
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
<div id="error2">
    <div class="alert alert-danger" role="alert"><span id="err2"></span></div>
</div>
<div id="error3">
    <div class="alert alert-danger" role="alert"><span id="err3"></span></div>
</div>
<script type="text/javascript">
    $(function () {
        jQuery.ajax({
            type: "POST",
            url: "ajax/get_RTU_GRP.php",
            success: function(html){
                jQuery("select#RTU_GRP").html(html);
            }
        });
        jQuery.ajax({
            type: "POST",
            url: "ajax/get_GRP.php",
            success: function(html){
                jQuery("select#GRP").html(html);
            }
        });
        //if(!$("select#GRP").val()) {
        /*
			console.log("empty");
            jQuery("select#RTU_GRP").change(function(){
                var RTU_GRP = $("select#RTU_GRP").val();
                var dataString = "RTU_GRP="+RTU_GRP;
                jQuery.ajax({
                    type: "GET",
                    url: "ajax/get_GRP.php",
                    data: dataString,
                    success: function(html){
                        jQuery("select#GRP").html(html);
                    }
                });
            });
            */
	    //}
        jQuery("select#GRP").change(function(){
            var GRP = $("select#GRP").val();
            var dataString = "GRP="+GRP;
            jQuery.ajax({
                type: "GET",
                url: "ajax/get_RTU_GRP.php",
                data: dataString,
                success: function(html){
                    jQuery("select#RTU_GRP").html(html);
                }
            });
        });
        if(jQuery().validationEngine) {
            $("#forms").validationEngine({promptPosition : "bottomLeft:10"});;
        }
    });
    jQuery("#forms").on('click', '#submit', function(e) {
      var valid = jQuery("#forms").validationEngine('validate');
      if (valid == true) {
      	//validated
      	e.preventDefault();
		var inv = jQuery("input[name='inv']").val();
		var place = jQuery("input[name='place']").val();
		var ip = jQuery("input[name='ip']").val();
		var serialnumber = jQuery("input[name='serialnumber']").val();
		var RTU_GRP = jQuery("select[name='RTU_GRP']").val();
		var GRP = jQuery("select[name='GRP']").val();
		var building = jQuery("input[name='building']").val();
		var flor = jQuery("input[name='floor']").val();
		var groupnr = jQuery("input[name='groupnr']").val();
		var art_no = jQuery("input[name='art_no']").val();
		var track = jQuery("select[name='track']").val();
        var mounted = jQuery("input[name='mounted']").val();
        var mapx = jQuery("input[name='mapx']").val();
        var mapy = jQuery("input[name='mapy']").val();
        //build string data
        var datastr = '&inv='+inv+'&ip='+ip+'&place='+place+'&serialnumber='+serialnumber+'&RTU_GRP='+RTU_GRP+'&GRP='+GRP+'&building='+building+'&floor='+flor+'&groupnr='+groupnr+'&art_no='+art_no+'&track='+track+'&mounted='+mounted+'&mapx='+mapx+'&mapy='+mapy;
        //console.log(datastr);
        send(datastr);
      } else {
      	e.preventDefault();
      }
    });
    function send(data) {
        jQuery.ajax({
            type: "POST",
            url: "ajax/clocks_add.php",
            data: data,
            success: function(data){
				console.log(data);
				jQuery("#error1").hide();
				jQuery("#error2").hide();
				jQuery("#error3").hide();
				if (data[0]) {
				    if(data[0].name == "err") {
					    jQuery("span#err1").html("<strong>Error "+data[0].errnr+"</strong> -> "+data[0].error);
                        jQuery("#error1").show();
                    }
			    }
			    if (data[1]) {
				    if(data[1].name == "err") {
					    jQuery("span#err2").html("<strong>Error "+data[1].errnr+"</strong> -> "+data[1].error);
                        jQuery("#error2").show();
                    }
			    }
			    if (data[2]) {
				    if(data[2].name == "err") {
					    jQuery("span#err3").html("<strong>Error "+data[2].errnr+"</strong> -> "+data[2].error);
                        jQuery("#error3").show();
                    }
			    }
				if(data.name == "data") {
                    jQuery("#forms").hide();
                    jQuery("span#ok").html("<strong>OK</strong> -> "+data.msg);
                    jQuery("#success").show();
		            setTimeout(function(){
					    jQuery("#modal-2").modal("hide");
					    window.location.reload(true);
				    },1000);
				}
            },
            error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
            },
        });
        return false;
    }
</script>
