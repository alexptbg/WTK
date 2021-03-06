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
?>
<?php if(!empty($_GET)): ?>
<form id="forms" class="form-horizontal" method="post">
	<div class="form-group"> 
		<label class="col-sm-3 control-label">ID</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="id" id="id" value="<?php echo $device['id']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">INVENTORY NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required,custom[onlyNnumbers],custom[integer],min[10000],max[20000],minSize[5],maxSize[5]]" name="inv" id="inv" value="<?php echo $device['inv']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">SERIAL NUMBER</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="serialnumber" id="serialnumber" value="<?php echo $device['serialnumber']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">ARE YOU SHURE???</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" name="confirm" id="confirm"> 
			    <option></option> 
			    <option value="NO">NO</option>
			    <option value="NO">NO</option>
			    <option value="NO">NO</option>
			    <option value="NO">NO</option>
			    <option value="YES">YES</option>
			    <option value="NO">NO</option>
			    <option value="NO">NO</option>
			</select>
	    </div> 
	</div>
	<div class="line-modal"></div>
	<div class="form-group">
	    <div class="col-sm-12">
			<div class="fr">
	            <button data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Cancel</button>
			    <button type="submit" class="btn btn-danger" name="submit" id="submit"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;DELETE</button>
			</div>
		</div>
	</div>
</form>
<div id="success">
    <div class="alert alert-success" role="alert"><strong>Well done!</strong> You successfully did it. </div>
</div>
<div id="error">
    <div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> Change a few things up and try submitting again. </div>
</div>
<script type="text/javascript">
    $(function () {
        if(jQuery().validationEngine) {
            $("#forms").validationEngine({promptPosition : "bottomLeft:10"});;
        }
        $("button#submit").attr("disabled",true);
        $("select#confirm").change(function() {
            if($("select#confirm").val().length > 0 && $("select#confirm").val() == "YES") {
		        $("button#submit").removeAttr("disabled");
            } else {
                $("button#submit").attr("disabled",true);
            }
        });
    });
    jQuery("#forms").on('click', '#submit', function(e) {
      var valid = jQuery("#forms").validationEngine('validate');
      if (valid == true) {
      	//validated
      	e.preventDefault();
      	var id = jQuery("input[name='id']").val();
		var inv = jQuery("input[name='inv']").val();
		var serialnumber = jQuery("input[name='serialnumber']").val();
		var confirm = jQuery("select#confirm").val();

        var datastr = 'id='+id+'&inv='+inv+'&serialnumber='+serialnumber+'&confirm='+confirm;
        //console.log(datastr);
        send(datastr);
      } else {
      	e.preventDefault();
      }
    });
    function send(data) {
        jQuery.ajax({
            type: "POST",
            url: "ajax/clocks_remove.php",
            data: data,
            success: function(){
                jQuery("#forms").hide();
                jQuery("#success").show();
		        setTimeout(function(){
					jQuery("#modal-2").modal("hide");
					window.location.reload(true);
				},1000);
            },
            error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
            },
        });
        return false;
    }
</script>
<?php else: ?>


<?php endif; ?>
