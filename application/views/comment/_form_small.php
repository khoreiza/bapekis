<?php 
	$user = $this->session->userdata('userbapekis');
	$modul_val=""; $sub_modul_val="";
	if(isset($modul)) $modul_val = $modul;
	if(isset($sub_modul)) $sub_modul_val = $sub_modul;
?>
<style type="text/css">
	.comment_box{padding: 10px 0 0px 0;}	
</style>

<div class="comment_box">
	<div class="row" id="comment_form">
		<div class="col-xs-12">
			<div style="position: relative; z-index: 9;" id="comment_textarea">
				<textarea <?=(isset($is_rich_text) && $is_rich_text) ? 'onfocus="actived_summernote(\'comment\');"' : '' ?> id="comment" class="form-control" style="height:50px; font-size: 12px; resize: none;" placeholder="Discussion"></textarea>
			</div>
			<div style="padding: 6px 6px 6px 6px; " class="right_text">
				<a onclick="submit_comment('<?=$id?>','<?=$ownership?>','<?=$kind?>','<?=$modul_val?>','<?=$sub_modul_val?>','<?=(isset($is_rich_text) && $is_rich_text) ? "true" : ""?>')" class="btn btn-brobot btn-gray btn-full btn-xs">POST</a>
			</div>
			<input type="hidden" id="view_comment" value="">
		</div>
	</div><hr style="margin:5px 0 5px 0;">
	<div style="margin-top: 20px" id="comment_list">
		<?php if($comments){echo $comment_list;}else{?>
		<h4 class="helper_text center_text">No Comment</h4>
		<?php }?>
	</div>
</div>

