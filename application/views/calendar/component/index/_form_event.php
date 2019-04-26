<?php 
	$user = $this->session->userdata('userbapekis');
    $arr_category = array('Acara Rutin','Bapekis Event','Acara Ibu-ibu','Employee Engagement','Meeting','TIB','Others');
?>

<form class="form-horizontal form-borventh" action="<?php if($calendar){echo base_url()."calendar/submit_calendar/".$calendar->id;}else{echo base_url()."calendar/submit_calendar";}?>" method ="post" id="formcalendar" role="form" enctype="multipart/form-data">
    <input type="hidden" name="modul" value="<?=($calendar && $calendar->modul) ? $calendar->modul : $modul?>">
    <input type="hidden" name="ownership_id" value="<?=($calendar && $calendar->ownership_id) ? $calendar->ownership_id : $ownership_id?>">

    <div>
		<div class="form_group_part_description">Event Title, Event Location, Event Banner</div>
        <div class="form_group_part_title">Event Data</div>
		<div class="form-group row">
			<div class="col-sm-4 col-sm-offset-1">
				<select id="category" class="selectpicker" name="category_id" data-live-search="true" data-width="100%">
	                <?php foreach($categories as $categ){?>
	                    <option <?=($calendar && $calendar->category == $categ->category) ? "selected" : ""?> value="<?=$categ->id?>"><?=$categ->category?></option>
	                <?php }?>
	            </select>
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control-minimalist" id="title" name="title" placeholder="Title" <?php if($calendar){echo "value='".$calendar->title."'";}?>>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-1">
				<?php 
					$loc = "";
					if($calendar){ $loc = $calendar->location;}
					elseif(isset($mosque)){$loc = $mosque->name;} 
				?>
				<input type="text" class="form-control-minimalist" id="location" name="location" placeholder="Location" value="<?=$loc;?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 col-sm-offset-1">
				<input type="file" name="img[]" multiple class="btn btn-default">
			</div>
			<label class="col-sm-2 control-label input-md" style="text-align: left">Photo Banner</label>
		</div>
		<hr>
	</div> 
	<div>
		<div class="form_group_part_description">Event Date, Event Time, Event Description</div>
        <div class="form_group_part_title">Event Time</div>
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
	</div>
	<hr>
	<div>
		<div class="form_group_part_description">Event Date, Event Time, Event Description</div>
        <div class="form_group_part_title">Pengisi Acara</div>
		<div class="form-group row">
			<div class="col-sm-4 col-sm-offset-1">
				<small style="color:grey">Nama Imam</small>
				<input type="text" class="form-control-minimalist" id="imam" name="imam" placeholder="Imam" value="">
			</div>
			<div class="col-sm-4">
				<small style="color:grey">Nama Muadzin</small>
				<input type="text" class="form-control-minimalist" id="muadzin" name="muadzin" placeholder="Muadzin" value="">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4 col-sm-offset-1">
				<input type="text" class="form-control-minimalist" id="penceramah" name="penceramah" placeholder="Penceramah" value="">
				<small style="color:grey">Penceramah</small>
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control-minimalist" name="judul_ceramah" placeholder="Judul Ceramah" value="">
				<small style="color:grey">Judul Ceramah</small>
			</div>
		</div>
	</div>
	<hr>
    <div>
        <div class="form_group_part_description">Attachment Files, Photo Gallery</div>
        <div class="form_group_part_title">Event Attachment</div>

        <div>
            <div class="form-group row">
                <label class="col-sm-2 control-label input-md">Attachment</label>
                <div class="col-sm-10">
                    <input type="file" name="attachment[]" id="attachment" multiple class="btn btn-default">
                    <?php if(isset($mysharing['attachment'])){?>
                    <div style="margin-top:20px; max-width:80%">
                        <?php foreach($mysharing['attachment'] as $file){?>
                            <div class="file_<?php echo $file->id?>">
                                <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                    <span><img style="height:18px" src="<?=get_ext_office($file->ext)?>"></span>
                                    <a href="<?php echo base_url()?><?php echo $file->full_url;?>"><?= $file->title?></a>
                                </div>
                                <div style="float:right; padding-right:10px;">
                                    <?php if(($user['id'] == $file->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                        <a onclick="delete_files_upload(<?php echo $file->id?>,'file_form')">
                                            <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                        </a>
                                    <?php }?>
                                </div><div style="clear:both"></div>
                            </div>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label input-md">Photo Gallery</label>
                <div class="col-sm-10">
                    <input type="file" name="photo[]" id="photo" multiple class="btn btn-default">
                    <?php if(isset($mysharing['img'])){?>
                    <div style="margin-top:20px; max-width:80%">
                        <?php foreach($mysharing['img'] as $file){?>
                            <div class="file_<?php echo $file->id?>">
                                <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                    <span><img style="height:18px" src="<?php echo base_url().$file->full_url ?>"></span>
                                    <?php echo $file->title?>
                                </div>
                                <div style="float:right; padding-right:10px;">
                                    <?php if(($user['id'] == $file->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                        <a onclick="delete_files_upload(<?php echo $file->id?>,'file_form')">
                                            <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                        </a>
                                    <?php }?>
                                </div><div style="clear:both"></div>
                            </div>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
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