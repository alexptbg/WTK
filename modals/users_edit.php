<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../inc/db.php");
include("../inc/functions.php");
include("../inc/config.php");
if(!empty($_GET)) {
    $user = get_user($_GET['id'],$_GET['username']);
}
$invs = array();
$local = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$local->set_charset("utf8");
$sql="SELECT `inv` FROM `devices` ORDER BY `inv` ASC";
$result=$local->query($sql);
if($result === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
			$invs[] = $row['inv'];
		}
    }
}
?>
<?php if(!empty($_GET)): ?>
<form id="forms" class="form-horizontal" method="post">
	<div class="form-group"> 
		<label class="col-sm-3 control-label">ID</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="id" id="id" value="<?php echo $user['id']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">USERNAME</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="username" id="username" value="<?php echo $user['username']; ?>" readonly="readonly" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">FIRST NAME</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="firstname" id="firstname" value="<?php echo $user['firstname']; ?>" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">LAST NAME</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="lastname" id="lastname" value="<?php echo $user['lastname']; ?>" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">EMAIL</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="email" id="email" value="<?php echo $user['email']; ?>" /> 
		</div> 
	</div>
	<div class="form-group"> 
		<label class="col-sm-3 control-label">PHONE</label> 
		<div class="col-sm-9"> 
			<input type="text" class="form-control validate[required]" name="phone" id="phone" value="<?php echo $user['phone']; ?>" /> 
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">ACCESS</label> 
		<div class="col-sm-9">
			<?php
			    if ($user['access'] == "0") { $access_name = "VIEW"; }
			    if ($user['access'] == "1") { $access_name = "CHANGE"; }
			?>
		    <select class="form-control validate[required]" id="access" name="access">
				<option value="<?php echo $user['access']; ?>"><?php echo $access_name; ?></option>
				<option></option>
				<?php if($user['username'] == "admin"): ?>
				<option value="1">CHANGE</option>
				<?php else: ?>
				<option value="0">VIEW</option>
				<option value="1">CHANGE</option>
				<?php endif; ?>
			</select>
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">LEVEL</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" id="level" name="level">
				<option value="<?php echo $user['level']; ?>"><?php echo $user['level']; ?></option>
				<option></option>
				<?php if($user['username'] == "admin"): ?>
				<option value="50">50</option>
				<?php else: ?>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<?php endif; ?>
			</select>
		</div> 
	</div>
	<div class="form-group"> 
	    <label class="col-sm-3 control-label">STATUS</label> 
		<div class="col-sm-9"> 
		    <select class="form-control validate[required]" id="status" name="status">
				<option value="<?php echo $user['status']; ?>"><?php echo $user['status']; ?></option>
				<option></option>
				<?php if($user['username'] == "admin"): ?>
				<option value="Active">Active</option>
				<?php else: ?>
				<option value="Active">Active</option>
				<option value="Pending">Pending</option>
				<option value="Deactivated">Deactivated</option>
				<?php endif; ?>
			</select>
		</div> 
	</div>
	
	<div class="line-modal"></div>
	<div class="form-group">
	    <div class="col-sm-12">
			<div class="fr">
	            <button data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;CANCEL</button>
			    <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;UPDATE USER</button>
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
        if(jQuery().validationEngine) {
            $("#forms").validationEngine({promptPosition : "bottomLeft:10"});;
        }
    });
    jQuery("#forms").on('click', '#submit', function(e) {
      var valid = jQuery("#forms").validationEngine('validate');
      if (valid == true) {
      	//validated
      	e.preventDefault();
      	var id = jQuery("input[name='id']").val();
		var username = jQuery("input[name='username']").val();
		var firstname = jQuery("input[name='firstname']").val();
		var lastname = jQuery("input[name='lastname']").val();
		var email = jQuery("input[name='email']").val();
		var phone = jQuery("input[name='phone']").val();
		var access = jQuery("select[name='access']").val();
		var level = jQuery("select[name='level']").val();
		var status = jQuery("select[name='status']").val();

        //build string data
        var datastr = 'id='+id+'&username='+username+'&firstname='+firstname+'&lastname='+lastname+'&email='+email+'&phone='+phone+'&access='+access+'&level='+level+'&status='+status;
        //console.log(datastr);
        send(datastr);
      } else {
      	e.preventDefault();
      }
    });
    function send(data) {
        jQuery.ajax({
            type: "POST",
            url: "ajax/users_edit.php",
            data: data,
            success: function(data){
				console.log(data);
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
<?php endif; ?>
