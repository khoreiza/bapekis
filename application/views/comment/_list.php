<?php $user = $this->session->userdata('userbapekis');
if($comments){?>

	<div style="margin: 20px 0 0px">
	<?php foreach($comments as $row){?>
		<div style="padding:10px 0 10px; <?=($row != end($comments) ? "border-bottom: 1px solid #f2f2f2;" : "")?>" id="comment_<?=$row->comment_id?>">
			<div class="row">
				<div class="col-md-1 col-xs-2">
					<div style="overflow:hidden; width: 100%; max-width: 30px; max-height: 30px; border-radius: 5px; overflow: hidden;">
						<?php employee_photo($row)?>
					</div>
				</div>
				<div class="col-md-10 col-xs-9">
					<div style="font-size: 12px;">
						<div><?= $row->full_name?></div>
						<div class="helper_text" style="font-size: 10px;">
							<?php 
								if(date("Y-m-d", strtotime($row->created)) == date("Y-m-d")) echo date("H:i", strtotime($row->created));
								else echo date("j M y", strtotime($row->created));
								$row->created
							?>	
						</div>
					</div>
					<div style="margin-top: 10px;"><?= $row->comment?></div>
				</div>
				<div class="col-xs-1" style="font-size: 10px;">
					<?php if($user['id'] == $row->user_id || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
					<a onclick="delete_comment(<?php echo $row->comment_id?>)">
                        <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                    </a>
                    <?php }?>
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