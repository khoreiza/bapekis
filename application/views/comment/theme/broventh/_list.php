<?php $user = $this->session->userdata('userdb'); 
if($comments){?>

	<div style="margin: 20px 0 0px">
	<?php foreach($comments as $row){?>
		<div style="padding:10px 0 10px; <?=($row != end($comments) ? "border-bottom: 1px solid #f2f2f2;" : "")?>" id="comment_<?=$row->comment_id?>">
			<div class="row">
				<?php
				$uri = $this->uri->segment(3);
				if ((isset($uri) && $uri == 'General') || (isset($role) && $role == 'General')) { ?>
					<div class="col-xs-12">
						<div style="font-size: 12px;">
							<div>
								<?= $row->comment?>
							</div>
							<div class="third_font" style="font-size: 10px; margin-top: 5px;">
								<?php 
									if(date("Y-m-d", strtotime($row->created)) == date("Y-m-d")) echo date("H:i", strtotime($row->created));
									else echo date("j M y", strtotime($row->created));
									$row->created
								?> · 
								<?php if($user['id'] == $row->user_id || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
									<a class="third_font condens_font" onclick="delete_comment(<?php echo $row->comment_id?>)">Delete
									</a>
								<?php }?>
							</div>
						</div>
						<div style="margin-top: 10px;"></div>
					</div>
				<?php } else { ?>
					<div class="col-xs-2" style="max-width: 60px;">
						<div class="photo_frame_circle" style="width: 30px; height: 30px;">
							<?php employee_photo($row)?>
						</div>
					</div>
					<div class="col-xs-10">
						<div style="font-size: 12px;">
							<div>
								<a style="margin-right: 5px;" onclick="show_user_detail(<?=$row->user_id?>)"><?= get_user_nick_name($row)?></a> <?= $row->comment?>
							</div>
							<div class="third_font" style="font-size: 10px; margin-top: 5px;">
								<?php 
									if(date("Y-m-d", strtotime($row->created)) == date("Y-m-d")) echo date("H:i", strtotime($row->created));
									else echo date("j M y", strtotime($row->created));
									$row->created
								?> · 
								<?php if($user['id'] == $row->user_id || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
									<a class="third_font condens_font" onclick="delete_comment(<?php echo $row->comment_id?>)">Delete
									</a>
								<?php }?>
							</div>
						</div>
						<div style="margin-top: 10px;"></div>
					</div>
				<?php } ?>
				<div class="col-xs-1" style="font-size: 10px;">
					
				</div>
			</div>
		</div>
	<?php }?>
	</div>
<?php }else{?><h4 class="helper_text center_text">No Comment</h4><?php }?>

<script type="text/javascript">
	function delete_comment(id){
	    $.confirm({
			title: 'Apa anda yakin?',
			content: '',
			confirmButton: 'Ya',
			confirm: function(){  
			  $.ajax({
				type: "GET",
				url: config.base+"comment/delete",
				data: {id:id},
				dataType: 'json',
				cache: false,
				success: function(resp){
				  console.log(resp);
				  if(resp.status==true){
	                $('#comment_'+id).animate({'opacity':'toggle'});
				  }else{
					  console.log('action after failed');
				  }
				}
			  });
			},
		});
	}
</script>