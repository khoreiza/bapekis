<?php 
	$user = $this->session->userdata('userbapekis');
	$modul_val=""; $sub_modul_val="";
	if(isset($modul_comment)) $modul_val = $modul_comment;
	if(isset($sub_modul_comment)) $sub_modul_val = $sub_modul_comment;

	$comment_box_id = "comment"; $comment_list_id = "comment_list";
	if($kind == "id"){
		$comment_box_id = "comment_".$id;
		$comment_list_id = "comment_list_".$id;
	}
	$uri = $this->uri->segment(3);
	if ($uri == 'General') {
		$text = '<b>To </b>: <br /><b>Message </b>: <br />';
		$role = 'General';
	} else {
		$text = '';
		$role = 'other';
	}
?>
<style type="text/css">
	.comment_box{padding: 10px;}	
</style>

<div class="comment_box">
	<div class="row" style="margin-top: 0px;">
		<div class="col-md-11">
			<input type="hidden" name="chat_to_dept" value="<?=(isset($chat_to_dept) && $chat_to_dept) ? $chat_to_dept : ''?>">
			<div style="position: relative; z-index: 9;" id="comment_textarea">
				<textarea <?=(isset($is_rich_text) && $is_rich_text) ? 'onfocus="actived_summernote(\'comment\');"' : '' ?> id="<?=$comment_box_id?>" class="form-control" style="height:65px; font-size: 14px; resize: none; border-radius: 0;" placeholder="Leave a comment"><?=$text?></textarea>
			</div>
		</div>
		<div class="col-md-1" style="padding-top: 15px;">
			<a onclick="submit_comment('<?=$id?>','<?=$ownership?>','<?=$kind?>','<?=$modul_val?>','<?=$sub_modul_val?>','<?=(isset($is_rich_text) && $is_rich_text) ? "true" : ""?>')" class="btn btn-broventh btn-circle btn-first" style="padding-right: 3px;">
				<span class="glyphicon glyphicon-send"></span>
			</a>
		</div>
		<input type="hidden" id="view_comment" value="broventh">
		<input type="hidden" id="role" value="<?=$role?>">
	</div>
	<div style="margin-top: 20px" id="<?=$comment_list_id?>">
		<?php if($comments){echo $comment_list;}else{?>
		<h4 class="helper_text center_text">No Comment</h4>
		<?php }?>
	</div>
</div>

