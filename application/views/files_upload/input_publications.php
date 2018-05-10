<div id="" class="content_cbic" style="padding-right:40px; padding-bottom:20px;">
	<div class="each_part_cbic bg_part_one">
		<div class="content_each_part_cbic" style="min-width:900px; width:80%;">
			<div>
				<div class="form-signin">
					<h1 style="text-align:center; margin-bottom:20px;">Market Publications</h1>
					<form class="form-horizontal" action="<?php if(isset($publication)){echo base_url()."market/submit_publications/".$publication->id;}else{echo base_url()."market/submit_publications";}?>" method ="post" id="formpublication" role="form" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-sm-2 control-label input-md">File</label>
							<div class="col-sm-10">
								<input type="file" name="userfile" class="btn btn-default">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">File Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="title" name="title" placeholder="File Name" <?php if(isset($publication)){echo "value='".$publication->title."'";}?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label input-md">File Type</label>
							<div class="col-sm-5">
								<select class="form-control" name="file_type">
									<option value="Treasury" <?php if(isset($publication) && $publication->sub_modul == "Treasury"){echo "selected";}?>>Treasury</option>
									<option value="OCE" <?php if(isset($publication) && $publication->sub_modul == "OCE"){echo "selected";}?>>OCE</option>
									<option value="Mansek" <?php if(isset($publication) && $publication->sub_modul == "Mansek"){echo "selected";}?>>Mansek</option>
								</select>
							</div><div style="clear:both"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label input-md">User Allowed</label>
							<?php if(isset($publication)){$arr_user = explode(";",$publication->user_allowed);}?>
							<div class="col-sm-10">
								<label class="checkbox-inline">
									<input name="user_allowed[]" type="checkbox" value="Direksi" <?php if(isset($publication) && in_array("Direksi",$arr_user)){echo "checked";}?>> Direksi
								</label>
								<label class="checkbox-inline">
									<input name="user_allowed[]" type="checkbox" value="Group Head" <?php if(isset($publication) && in_array("Group Head",$arr_user)){echo "checked";}?>> Group Head
								</label>
								<label class="checkbox-inline">
									<input name="user_allowed[]" type="checkbox" value="Department Head" <?php if(isset($publication) && in_array("Department Head",$arr_user)){echo "checked";}?>> Department Head
								</label>
								<label class="checkbox-inline">
									<input name="user_allowed[]" type="checkbox" value="all" <?php if(isset($publication) && in_array("all",$arr_user)){echo "checked";}elseif(!isset($publication)){echo "checked";}?>> Umum
								</label>
							</div><div style="clear:both"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<textarea type="text" class="form-control" name="description">
									<?php if(isset($publication)){echo $publication->description;}else{?>
						
									<?php }?>
								</textarea>
							</div>
						</div>
						<market>
						<button class="btn btn-md btn-primary btn-block" type="submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('input[type=file]').bootstrapFileInput();
	});
	CKEDITOR.replace('description');
</script>