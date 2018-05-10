<div>
	<?php 
		$user = $this->session->userdata('userbapekis');
		if(($user['id'] == $news->user_id) || $user['role']=="SYSTEM ADMINISTRATOR"){?>	
			<div style="float:right;">
				<a href="<?php echo base_url()?>compliance/add_news/<?php echo $news->id?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="<?php echo base_url()?>compliance/delete_news/<?php echo $news->id?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
			</div><div style="clear:both"></div>
	<?php }?>
	<div style="margin-top:30px">
		<h3><b><?php echo $news->title;?></b></h3>
		<div style="font-size:14px; color:#a2a3a2; margin:0 0 10px 0;">
			<?php echo date("M, d Y",strtotime($news->created));?> | 
			<?php echo $news->sub_modul;?>
		</div>
		<p style="margin-top:10px; font-size:16px;"><?php echo $news->description;?> </p>
		<?php if($attachments){?>
		<hr>
		<b>Attachment</b>
		<div style="margin-top:20px; max-width:80%">
			<?php foreach($attachments as $file){?>
				<?php 
					if($file->ext == ".doc" || $file->ext == ".docx"){$img = "word";}
					elseif($file->ext == ".xls" || $file->ext == ".xlsx"){$img = "xlx";}
					elseif($file->ext == ".ppt" || $file->ext == ".pptx"){$img = "ppt";}
					else{$img = "pdf";}
				?>
				<div>
					<div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
						<span><img style="height:18px" src="<?php echo base_url()?>assets/img/icon/<?php echo $img?> - color.png"></span>
						<?php echo $file->title?>
					</div>
					<div style="float:right; padding-right:10px;">
						<a href="<?php echo base_url()?>assets/uploads/compliance/publications/<?php echo $file->file_name;?>">
							<span class="glyphicon glyphicon glyphicon-cloud-download" aria-hidden="true" style="color:#007aff"></span>
						</a>
						<?php if(($user['id'] == $file->user_id) || $user['role']=="SYSTEM ADMINISTRATOR"){?>	
							<a href="<?php echo base_url()?>compliance/add_publication/<?php echo $file->id?>">
								<span class="glyphicon glyphicon-pencil" style="color:#f0ad4e"></span>
							</a>
							<a href="<?php echo base_url()?>compliance/delete_publication/<?php echo $file->id?>">
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