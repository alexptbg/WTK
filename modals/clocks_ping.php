<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
check_login($local_settings['appname']);
if(!empty($_GET)) {
    $ip = $_GET['ip'];
}
?>
<?php if(!empty($_GET)): ?>
<form id="forms" class="form-horizontal" method="post">
	<div class="form-group"> 
		<label class="col-sm-3 control-label">IP ADDRESS</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="ip" id="ip" value="<?php echo $ip; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="line-modal"></div>
	<div class="form-group">
	    <div class="col-sm-12">
			<div class="fr">
	            <button data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;CLOSE</button>
			    <button type="submit" class="btn btn-danger" name="submit" id="submit"><i class="fa fa-share-square-o" aria-hidden="true"></i>&nbsp;PING</button>
			</div>
		</div>
	</div>
</form>
<div id="response"></div>
<script type="text/javascript">
    jQuery("#forms").on('click', '#submit', function(e) {
      var valid = jQuery("#forms").validationEngine('validate');
      if (valid == true) {
      	//validated
      	e.preventDefault();
		var ip = jQuery("input[name='ip']").val();
        var datastr = 'ip='+ip;
        send(datastr);
      } else {
      	e.preventDefault();
      }
    });
    function send(data) {
        jQuery.ajax({
            type: "GET",
            url: "ajax/clocks_ping.php?"+data,
            //data: data,
            success: function(data){
				console.log(data);
                //jQuery("#forms").hide();
                jQuery("#response").html(data);
                jQuery("#response").show();
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
