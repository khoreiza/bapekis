<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
	$arr_user_allowed = array("Director","Group Head", "Department Head", "Officer", "all");
	$arr_segment_allowed = get_arr_segment_ap();
	$arr_segment_allowed['4'] = "all";
?>

<div class="form-signin">
	<form class="form-horizontal" action="<?php if(isset($publication)){echo base_url()."file/submit_file/".$publication->id;}else{echo base_url()."file/submit_file";}?>" method="post" id="form_file_upload" role="form" enctype="multipart/form-data">
        <input type="hidden" name="modul" value="<?php echo $modul?>">
        <input type="hidden" name="submodul" value="<?php echo $submodul?>">
        <input type="hidden" name="ownership_id" value="<?php echo $ownership_id?>">
        <div class="form-group">
			<label class="col-sm-2 control-label input-md">Attachment</label>
			<div class="col-sm-10">
                <?php if(isset($publication)){?>
                <div style="margin-top:5px; max-width:80%">
                    <div>
                        <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                            <span><img style="height:18px" src="<?php echo base_url()?>assets/img/icon/<?= get_file_ext($publication->ext)?> - color.png"></span>
                            <a href="<?php echo base_url()?><?php echo $publication->full_url;?>">
                                <?php echo $publication->file_name?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php }else{?>
				<input type="file" name="attachment[]" multiple class="btn btn-default">
                <?php } ?>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-2 control-label">File Name</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="title" name="title" placeholder="File Name" <?php if(isset($publication)){echo "value='".$publication->title."'";}?>>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Date</label>
			<div class="col-sm-5">
				<?php $date=""; if(isset($publication) && $publication->created){$date = date("m/d/Y", strtotime($publication->created));}else{$date = date("m/d/Y", strtotime(date("Y-m-d")));}
				?>
				<input type="text" class="form-control" id="created" name="created" placeholder="mm/dd/YYYY" value="<?php echo $date?>">
				<small style="color:grey">format: mm/dd/YYYY</small>
			</div>
		</div>
		<div class="form-group" style="margin-top:10px;">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-9">
                <textarea onfocus="actived_summernote('description');" type="text" class="form-control" name="description" id="description" placeholder="Description">
                    <?php if(isset($publication)){echo $publication->description;}else{?><?php }?></textarea>
            </div>
        </div><hr>
        <div class="form-group">
			<label class="col-sm-2 control-label input-md">User Allowed</label>
			<?php if(isset($publication)){$arr_user = explode(";",$publication->user_allowed);}?>
			<div class="col-sm-10">
				<?php foreach($arr_user_allowed as $user_allowed){?>
					<label class="checkbox-inline">
						<input name="user_allowed[]" type="checkbox" value="<?=$user_allowed?>" <?php if(isset($publication) && in_array($user_allowed,$arr_user)){echo "checked";}elseif(!isset($publication) && $user_allowed == "all"){echo "checked";}?>> <?=long_text($user_allowed,20)?>
					</label>
				<?php }?>
			</div><div style="clear:both"></div>
		</div>

		<?php if($modul == "account plan"){?>
			<div class="form-group">
				<label class="col-sm-2 control-label input-md">Segment Allowed</label>
				<?php if(isset($publication)){$arr_segment = explode(";",$publication->segment_allowed);}?>
				<div class="col-sm-10">
					<?php foreach($arr_segment_allowed as $segment_allowed){?>
						<label class="checkbox-inline">
							<input name="segment_allowed[]" type="checkbox" value="<?=$segment_allowed?>" <?php if(isset($publication) && in_array($segment_allowed,$arr_segment)){echo "checked";}elseif(!isset($publication) && $segment_allowed == "all"){echo "checked";}?>> <?=long_text($segment_allowed,20)?>
						</label>
					<?php }?>
				</div><div style="clear:both"></div>
			</div>
		<?php }?><hr>
		<div class="center_text">
			<button class="btn btn-lg btn-brobot btn-tosca" type="button" onclick="submit_file_upload_form_ajax(this)">SUBMIT FILE</button>
		</div>
	</form>
</div>
				

<script>
	$(document).ready(function () {
		$('input[type=file]').bootstrapFileInput();
	});
	
	<?php if(isset($publication)){?>
		$('#description').summernote();
    <?php }?>
    
    $('#created').datepicker({
		autoclose: true,
		todayHighlight: true
	});

	function submit_file_upload_form_ajax(){
		$("#form_file_upload").ajaxForm({ 
			dataType: 'json',
    		/*beforeSerialize: function(form, options) {
        		var real_amount = $('.amount').unmask();
				$(".amount").val(real_amount);
			},*/
            success: function(resp) 
			{	
				if(resp.status){
					$("#"+resp.result_div).html(resp.html);
					see_all_files('<?=$modul?>','<?=$submodul?>','<?=$ownership_id?>');
				}
				else{
					alert("Failed to Upload File, "+resp.error);
				}
				//location.reload();
            },
		}).submit();
	}
</script>