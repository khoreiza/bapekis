<?php 
	$user = $this->session->userdata('userdb');
	$modul_val=""; $sub_modul_val="";
	if(isset($modul_comment)) $modul_val = $modul_comment;
	if(isset($sub_modul_comment)) $sub_modul_val = $sub_modul_comment;

	$comment_box_id = "comment"; $comment_list_id = "comment_list";
	if($kind == "id"){
		$comment_box_id = "comment_".$id;
		$comment_list_id = "comment_list_".$id;
	} 
?>
<style type="text/css">
	.comment_box{padding: 10px;}	
</style>

<div class="comment_box">
	<div class="row" id="comment_form">
		<div class="col-xs-2">
			<div style="width: 100%; max-width: 30px; border-radius:6px; overflow: hidden;">
			<?php my_photo($user)?>
			</div>
		</div>
		<div class="col-xs-10">
			<div style="position: relative; z-index: 9;" id="comment_textarea">
				<textarea <?=(isset($is_rich_text) && $is_rich_text) ? 'onfocus="actived_summernote(\'comment\');"' : '' ?> id="<?=$comment_box_id?>" class="form-control" style="height:50px; font-size: 12px; resize: none; border-bottom-right-radius: 0; border-bottom-left-radius: 0;" placeholder="<?php if(substr($ownership, 0, 3) == 'hbd'){echo 'Write a birthday wish...';} else {echo 'Post your comment...';} ?>"></textarea>
			</div>
			<div style="padding: 14px 6px 6px 6px; border:1px solid #d3d3d3; margin-top: -9px; background-color: #fafafa; border-radius: 5px;" class="right_text">
				<a onclick="submit_comment('<?=$id?>','<?=$ownership?>','<?=$kind?>','<?=$modul_val?>','<?=$sub_modul_val?>','<?=(isset($is_rich_text) && $is_rich_text) ? "true" : ""?>')" class="btn btn-brobot btn-tosca btn-full btn-xs">POST</a>
			</div>
		</div>
		<input type="hidden" id="view_comment" value="">
	</div>
	<div style="margin-top: 20px" id="<?=$comment_list_id?>">
		<?php if($comments){echo $comment_list;} else {
			if(substr($ownership, 0, 3) == 'hbd') { ?>
				<h6 class="helper_text center_text">No Comment</h6>
			<?php } else { ?>
				<h4 class="helper_text center_text">No Comment</h4>
		<?php } } ?>
	</div>
</div>

