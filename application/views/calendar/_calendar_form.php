<?php 
	$user = $this->session->userdata('userdb'); $user_disp="";
?>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
    	<div class="modal-body">
			<div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div>
				<div class="form-signin">
					<h1 style="text-align:center; margin-bottom:20px;">Event Corporate Banking</h1>
					<form class="form-horizontal" action="<?php if($calendar){echo base_url()."calendar/submit_calendar/".$calendar->id;}else{echo base_url()."calendar/submit_calendar";}?>" method ="post" id="formcalendar" role="form" enctype="multipart/form-data">
                        <?php /*
                        <div class="form-group">
                            <label class="col-sm-2 control-label input-md">Group</label>
                            <?php if($calendar){$arr_user = explode(";",$calendar->user_allowed);}?>
                            <div class="col-sm-10">
                                <?php for($i=1;$i<=7;$i++){?>
                                <label class="checkbox-inline">
                                    <input name="user_allowed[]" type="checkbox" value="CORPORATE BANKING <?php echo $i?>" <?php if($calendar && in_array("CORPORATE BANKING $i",$arr_user)){echo "checked";}?>> CB<?php echo $i?>
                                </label>
                                <?php } ?>
                                <label class="checkbox-inline">
                                    <input name="user_allowed[]" type="checkbox" value="all" <?php if($calendar && in_array("all",$arr_user)){echo "checked";}elseif(!$calendar){echo "checked";}?>> All
                                </label>
                            </div><div style="clear:both"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label input-md">User Allowed</label>
                            <?php if($calendar){$arr_users = explode(";",$calendar->reader);}?>
                            <div class="col-sm-10">
                                <label class="checkbox-inline">
                                    <input name="reader[]" type="checkbox" value="Direksi" <?php if($calendar && in_array("Direksi",$arr_users)){echo "checked";}?>> Direksi
                                </label>
                                <label class="checkbox-inline">
                                    <input name="reader[]" type="checkbox" value="Group Head" <?php if($calendar && in_array("Group Head",$arr_users)){echo "checked";}?>> Group Head
                                </label>
                                <label class="checkbox-inline">
                                    <input name="reader[]" type="checkbox" value="Department Head" <?php if($calendar && in_array("Department Head",$arr_users)){echo "checked";}?>> Department Head
                                </label>
                                <label class="checkbox-inline">
                                    <input name="reader[]" type="checkbox" value="Officer" <?php if($calendar && in_array("Officer",$arr_users)){echo "checked";}?>> Officer
                                </label>
                                <label class="checkbox-inline">
                                    <input name="reader[]" type="checkbox" value="Sekretaris" <?php if($calendar && in_array("Sekretaris",$arr_users)){echo "checked";}?>> Sekretaris
                                </label>
                                <label class="checkbox-inline">
                                    <input name="reader[]" type="checkbox" value="all" <?php if($calendar && in_array("all",$arr_users)){echo "checked";}elseif(!$calendar){echo "checked";}?>> Umum
                                </label>
                            </div><div style="clear:both"></div>
                        </div>*/ ?>
					 	<div class="form-group">
							<label class="col-sm-2 control-label">Title</label>
							<div class="col-sm-9">
								<input type="text" class="form-control-borderless" id="title" name="title" placeholder="Title" <?php if($calendar){echo "value='".$calendar->title."'";}?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Location</label>
							<div class="col-sm-9">
								<input type="text" class="form-control-borderless" id="location" name="location" placeholder="Location" <?php if($calendar){echo "value='".$calendar->location."'";}?>>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Start Date</label>
							<div class="col-sm-8">
								<?php $start=""; if($calendar){if($calendar->start){$start = date("m/d/Y", strtotime($calendar->start));}}
								elseif($this->uri->segment(4)){$start = $this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6);}
								?>
								<input type="text" class="form-control-borderless" id="start" name="start" placeholder="mm/dd/YYYY" value="<?php echo $start?>">
								<small style="color:grey">format: mm/dd/YYYY</small>
							</div>
							<div class="col-sm-1">
								<?php $start_time="08:00"; if($calendar){if($calendar->start){$start_time = date("h:i", strtotime($calendar->start));}}?>
								<input type="time" class="form-control-borderless" id="start_time" name="start_time" placeholder="hh:mm" value="<?php echo $start_time?>">
								<small style="color:grey">format: hh:mm</small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label input-md">Attachment</label>
							<div class="col-sm-10">
								<input type="file" name="attachment[]" multiple class="btn btn-default">
							</div>
						</div>
						<div class="form-group" style="margin-top:10px;">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea onfocus="actived_summernote('description');" type="text" class="form-control-borderless" name="description" id="description" placeholder="Description"><?php if($calendar){echo $calendar->description;}?></textarea>
                            </div><div style="clear:both"></div>
                        </div>
						<hr>
						<button class="btn btn-link btn-link-primary-cbic btn-block btn-lg" type="submit">Submit</button>
					</form>
				</div>
			</div>
    	</div>
    </div>
  </div>
</div>

<script>  
$(document).ready(function () {	
    $('input[type=file]').bootstrapFileInput();
});
    
<?php if($calendar){?>
	$('#description').summernote();
<?php }?>

$('#start').datepicker({
    autoclose: true,
    todayHighlight: true
});
    
$(document).ready(function(){
	if($('#type_login').val()=='failed'){
		$('#login_failed').removeClass('hide');
	}
	if($('#type_login').val()=='not_login'){
		$('#not_login').removeClass('hide');
	}
        
    $("#formcalendar").validate({
		rules: {
			username: {
				required: true,
			},
			password: {
				//required: true,
				minlength: 5
			},
			verify_password: {
				//required: true,
				equalTo: "#password"
			},
			name: "required",
		},
		messages: {
			username: {
				required: "Please enter an username"
			},
			password_su: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			verify_password: {
				required: "Please provide a password",
				equalTo: "Please enter the same password as above"
			},
			agree: "Please accept our policy"
		}
	});     
});
</script>