<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
	$arr_file_type = "";
	if($page=='compliance') $arr_file_type = array("External", "Internal", "Legal", "File Format");
	elseif($page == 'market') $arr_file_type = array("Treasury", "OCE", "Mansek", "Corporate Secretary");
	elseif($page == 'hr') $arr_file_type = array("Database Pegawai", "Policy & Update News", "File Template");
	elseif($page == 'account plan') $arr_file_type = array("General News", "Wholesale News", "Value Chain News", "Subsidiaries News");

	$arr_user_allowed = array("Director","Group Head", "Department Head", "Officer", "all");
	$arr_segment_allowed = get_arr_segment_ap();
	$arr_segment_allowed['4'] = "all";
?>

<form class="form-horizontal form-borventh" 
	action="<?=base_url()?>file/submit/<?=(isset($news) && $news->id) ? $news->id : ''?>"
	method="post" id="form-news" role="form" enctype="multipart/form-data" style="padding: 10px;">

	<div class="form_group_part_div" id="form_group_part_div_1" style="display: block;">
	    <div class="form_group_part_description">Category, Date, News Title, News Content, Photo Banner, Attachment, and User Allowed</div>
        <div class="form_group_part_title">News Information</div>

        <input type="hidden" name="ownership_id" value="<?=(isset($news) && $news->ownership_id) ? $news->ownership_id : $ownership_id?>">

	    <?php if(!isset($submodul) || $submodul == ''){?>
	        <?php if($arr_file_type){?>
		        <div class="form-group row">
					<div class="col-sm-4 col-sm-offset-1">
						
						<select class="form-control-borderless selectpicker" name="sub_modul">
								<option value="" disabled <?=(isset($news) && $news->sub_modul == $file_type) ? "" : "selected"; ?>>Type</option>
							<?php foreach($arr_file_type as $file_type){?>
								<option value="<?=$file_type?>" <?=(isset($news) && $news->sub_modul == $file_type) ? "selected" : ""; ?>><?=$file_type?></option>
							<?php }?>
						</select>
					</div>
				</div>
		<?php }}else{?>
			<input type="hidden" name="sub_modul" value="<?=(isset($news)) ? $news->sub_modul : $submodul?>">
		<?php }?>
		<?php if(isset($custgroup_name) && $custgroup_name){?>
	    <div class="form-group">
			<label class="col-sm-2 control-label input-md">Anchor</label>
			<div class="col-sm-5">
				<input type="hidden" name="file_type" value="<?=$custgroup_name?>">
				<label class="control-label"><?=$custgroup_name?></label>
			</div>
		</div>
		<?php }?>

		<input type="hidden" name="page" value="<?php echo $page?>">

	    <div class="form-group row">
			<div class="col-sm-4 col-sm-offset-1">
	            <?php $date=""; if(isset($news) && $news->created){$date = date("j M Y", strtotime($news->created));}else{$date = date("j M Y", strtotime(date("Y-m-d")));}
				?>
				<input type="text" class="form-control-minimalist" id="created" name="created" placeholder="mm/dd/YYYY" value="<?php echo $date?>">
	        </div>
			<?php if(isset($categories)){?>
				<div class="col-sm-6">
	                <select class="selectpicker" name="category_id" data-width="100%">
	                    <option value="0">Uncategorized</option>
	                    <?php foreach($categories as $categ){?>
	                        <option value="<?=$categ->id?>" <?=(isset($news) && $news->category_id == $categ->id) ? "selected" : ""; ?>><?=$categ->category?></option>
	                    <?php }?>
	                </select>
	            </div>
	        <?php }?>
		</div>
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-1">
				<input type="text" class="form-control-minimalist" id="title" name="title" placeholder="Title" value="<?=(isset($news)) ? $news->title : ''?>">
			</div>
		</div>
		<div class="form-group row" style="margin-top:10px;">
	        <div class="col-sm-10 col-sm-offset-1">
	            <textarea onfocus="actived_summernote('description');" type="text" class="form-control-minimalist" name="description" id="description" placeholder="Description"><?php if(isset($news)){echo $news->description;}?></textarea>
	        </div><div style="clear:both"></div>
	    </div>
	    <div class="form-group row">
			<div class="col-sm-10 col-sm-offset-1">
				<input type="file" name="img" id="img" class="btn btn-default">
	            <p class="help-block helper_text" style="margin-bottom: 0px; font-size: 12px;">Photo Banner for your news</p>
	            <?php if(isset($photo) && $photo){?>
	            	<div style="margin-top: 10px;" class="file_<?php echo $photo->id?>">
	            	<span><img style="height:100px" src="<?php echo base_url().$photo->full_url?>"></span>
	            	<?php if(($user['id'] == $photo->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
	            	<a onclick="delete_files_upload(<?php echo $photo->id?>,'file_form')">
	                    <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
	                </a>
	                <?php }?>
	                </div>
	            <?php }?>
			</div>
		</div>
	    <hr>
		<div class="form-group">
			<label class="col-sm-2 control-label input-md">Attachment</label>
			<div class="col-sm-10">
				<input type="file" name="attachment[]" multiple class="btn btn-default">
	            <?php if(isset($attach)){?>
	                <div style="margin-top:20px; max-width:80%">
	                    <?php foreach($attach as $file){?>
	                        <div class="row file_<?php echo $file->id?>">
	                            <div class="col-xs-1" style="">
	                                <span><img style="height:18px" src="<?= get_ext_icon($file->ext)?>"></span>
	                            </div>
	                            <div class="col-xs-9" style="">
	                            	<a href="<?=base_url().$file->full_url?>" target="_blank"><?php long_text($file->title,30)?></a>
	                            </div>
	                            <div class="col-xs-2" style="">
	                                <?php if(($user['id'] == $file->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
	                                    <a onclick="delete_files_upload(<?php echo $file->id?>,'file')">
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
		<div class="form-group">
			<label class="col-sm-2 control-label input-md">Photo Gallery</label>
			<div class="col-sm-10">
				<input type="file" name="photo[]" multiple class="btn btn-default">
				<?php if(isset($galleries)){?>
	                <div style="margin-top:20px; max-width:80%">
	                    <?php foreach($galleries as $file){?>
	                        <div class="row file_<?php echo $file->id?>">
	                            <div class="col-xs-1" style="">
	                                <span><img style="height:20px" src="<?= get_thumbnail_src(base_url().$file->full_url)?>"></span>
	                            </div>
	                            <div class="col-xs-9" style="">
	                            	<a href="<?=base_url().$file->full_url?>" target="_blank"><?php long_text($file->title,30)?></a>
	                            </div>
	                            <div class="col-xs-2" style="">
	                                <?php if(($user['id'] == $file->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
	                                    <a onclick="delete_files_upload(<?php echo $file->id?>,'file')">
	                                        <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
	                                    </a>
	                                <?php }?>
	                            </div><div style="clear:both"></div>
	                        </div>
	                    <?php }?>
	                </div>
	            <?php }?>
			</div>
		</div><hr>
		<?php /*<div class="form-group">
			<label class="col-sm-2 control-label input-md">User Allowed</label>
			<?php if(isset($news)){$arr_user = explode(";",$news->user_allowed);}?>
			<div class="col-sm-10">
				<?php foreach($arr_user_allowed as $user_allowed){?>
					<label class="checkbox-inline">
						<input name="user_allowed[]" type="checkbox" value="<?=$user_allowed?>" <?php if(isset($news) && in_array($user_allowed,$arr_user)){echo "checked";}elseif(!isset($news) && $user_allowed == "all"){echo "checked";}?>> <?=long_text($user_allowed,20)?>
					</label>
				<?php }?>
			</div><div style="clear:both"></div>
		</div>

		<?php if($page == "account plan" || $page == "anchor update"){?>
			<div class="form-group">
				<label class="col-sm-2 control-label input-md">Segment Allowed</label>
				<?php if(isset($news)){$arr_segment = explode(";",$news->segment_allowed);}?>
				<div class="col-sm-10">
					<?php foreach($arr_segment_allowed as $segment_allowed){?>
						<label class="checkbox-inline">
							<input name="segment_allowed[]" type="checkbox" value="<?=$segment_allowed?>" <?php if(isset($news) && in_array($segment_allowed,$arr_segment)){echo "checked";}elseif(!isset($news) && $segment_allowed == "all"){echo "checked";}?>> <?=long_text($segment_allowed,20)?>
						</label>
					<?php }?>
				</div><div style="clear:both"></div>
			</div>
		<?php }?>
		<hr>*/ ?>
		<div class="center_text">
			<button class="btn btn-broventh btn-circle btn-first btn-lg" type="submit"><span class="glyphicon glyphicon-save"></span></button>
		</div>
	</div>
</form>
			
<script>
	$('#created').datepicker({
		autoclose: true,
        todayHighlight: true,
        format: 'd M yyyy',
        dateFormat:"mm/dd/yy"
	});

	$(document).ready(function () {
		$('input[type=file]').bootstrapFileInput();
	});
	<?php if(isset($news)){?>
	$('#description').summernote();
    <?php }?>
    
    function delete_photo_market(id,div){
    $.confirm({
		title: 'Apa anda yakin?',
		content: '',
		confirmButton: 'Ya',
		confirm: function(){  
		  $.ajax({
			type: "GET",
			url: config.base+"file/delete_photo_market",
			data: {id: id},
			dataType: 'json',
			cache: false,
			success: function(resp){
			  console.log(resp);
			  if(resp.status==true){
				$('#'+div+"_"+resp.file_id).animate({'opacity':'toggle'});
			  }else{
				  console.log('action after failed');
			  }
			}
		  });
		},
	});
    }
</script>