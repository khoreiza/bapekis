<?php 
	$user = $this->session->userdata('userbapekis');
    $arr_category = array('Acara Rutin','Bapekis Event','Acara Ibu-ibu','Employee Engagement','Meeting','TIB','Others');
?>

<form class="form-horizontal form-borventh" action="<?php if($calendar){echo base_url()."calendar/submit_calendar/".$calendar->id;}else{echo base_url()."calendar/submit_calendar";}?>" method ="post" id="formcalendar" role="form" enctype="multipart/form-data">
    <input type="hidden" name="modul" value="<?=($calendar && $calendar->modul) ? $calendar->modul : $modul?>">
    <input type="hidden" name="ownership_id" value="<?=($calendar && $calendar->ownership_id) ? $calendar->ownership_id : $ownership_id?>">

	<div class="form-group row">
		<div class="col-sm-6 col-sm-offset-1">
			<input type="text" class="form-control-minimalist" id="title" name="title" placeholder="Title" <?php if($calendar){echo "value='".$calendar->title."'";}?>>
		</div>
		<div class="col-sm-4">
			<select id="category" class="selectpicker" name="category" data-live-search="true" data-width="100%">
                <?php foreach($arr_category as $categ){?>
                    <option <?=($calendar && $calendar->category == $categ) ? "selected" : ""?> value="<?=$categ?>"><?=$categ?></option>
                <?php }?>
            </select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-10 col-sm-offset-1">
			<input type="text" class="form-control-minimalist" id="location" name="location" placeholder="Location" <?php if($calendar){echo "value='".$calendar->location."'";}?>>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-2 col-sm-offset-1">
			<input type="file" name="img[]" multiple class="btn btn-default">
		</div>
		<label class="col-sm-2 control-label input-md" style="text-align: left">Photo Banner</label>
	</div>
	<hr>
    <?php /*
    <div class="form-group row">
        <?php if($calendar){$arr_group_res = explode(";",$calendar->group_allowed);}?>
        <div class="col-sm-10 col-sm-offset-1">
            <?php foreach($arr_group as $group){?>
	            <label class="checkbox-inline">
	                <input name="group_allowed[]" type="checkbox" value="<?=$group->id?>" <?php if($calendar && in_array($group->short,$arr_group_res)){echo "checked";}?>> <?=$group->short?>
	            </label>
            <?php } ?>
            <label class="checkbox-inline">
                <input name="group_allowed[]" type="checkbox" value="all" <?php if($calendar && in_array("all",$arr_group_res)){echo "checked";}elseif(!$calendar){echo "checked";}?>> All
            </label>
        </div>
    </div>
    <div class="form-group row">
        <?php if($calendar){$arr_position_res = explode(";",$calendar->position_allowed);}?>
        <div class="col-sm-10 col-sm-offset-1">
            <?php foreach($arr_position as $pos){?>
	            <label class="checkbox-inline">
	                <input name="position_allowed[]" type="checkbox" value="<?=$pos->position?>" <?php if($calendar && in_array($pos->position,$arr_position_res)){echo "checked";}?>> <?=$pos->position?>
	            </label>
            <?php } ?>
            <label class="checkbox-inline">
                <input name="position_allowed[]" type="checkbox" value="all" <?php if($calendar && in_array("all",$arr_position_res)){echo "checked";}elseif(!$calendar){echo "checked";}?>> All
            </label>
        </div>
    </div>
 	<hr>
 	*/ ?>
	<div class="form-group row">
		<div class="col-sm-3 col-sm-offset-1">
			<?php $start=""; if($calendar){if($calendar->start){$start = date("m/d/Y", strtotime($calendar->start));}}
			elseif($this->uri->segment(4)){$start = $this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6);}
			?>
			<input type="text" class="form-control-minimalist" id="start" name="start" placeholder="Start Date" value="<?php echo $start?>">
			<small style="color:grey">format: mm/dd/YYYY</small>
		</div>
		<div class="col-sm-2">
			<?php $start_time="8:00"; if($calendar){if($calendar->start){$start_time = date("h:i", strtotime($calendar->start));}}?>
			<input type="text" class="form-control-minimalist time" id="start_time" name="start_time" placeholder="hh:mm" value="<?php echo $start_time?>">
			<small style="color:grey">format: hh:mm</small>
		</div>
		<div class="col-sm-3">
			<?php $end=""; if($calendar){if($calendar->end){$end = date("m/d/Y", strtotime($calendar->end));}}
			?>
			<input type="text" class="form-control-minimalist" id="end" name="end" placeholder="End Date" value="<?php echo $end?>">
			<small style="color:grey">format: mm/dd/YYYY</small>
		</div>
		<div class="col-sm-2">
			<?php $end_time="17:00"; if($calendar){if($calendar->end){$end_time = date("h:i", strtotime($calendar->end));}}?>
			<input type="text" class="form-control-minimalist time" id="end_time" name="end_time" placeholder="hh:mm" value="<?php echo $end_time?>">
			<small style="color:grey">format: hh:mm</small>
		</div>
	</div>
	<div class="form-group row">
        <div class="col-sm-10 col-sm-offset-1">
            <textarea onfocus="actived_summernote('description');" type="text" class="form-control-minimalist" name="description" id="description" placeholder="Description"><?php if($calendar){echo $calendar->description;}?></textarea>
        </div>
    </div>
	<div class="form-group row">
		<div class="col-sm-2 col-sm-offset-1">
			<input type="file" name="attachment[]" multiple class="btn btn-default">
		</div>
		<label class="col-sm-2 control-label input-md" style="text-align: left">Attachment File</label>
	</div>
	
	<hr>
	<div class="center_text">
        <button class="btn btn-broventh btn-circle btn-first btn-lg" type="submit"><span class="glyphicon glyphicon-save"></span></button>
    </div>
</form>
				
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
$('#end').datepicker({
    autoclose: true,
    todayHighlight: true
});
$('.time').timepicker({
    template: false,
    showInputs: false,
    minuteStep: 30,
    showMeridian: false,
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