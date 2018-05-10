<?php $user = $this->session->userdata('userbapekis');?>
<div class="component_part">
	<div style="margin-bottom:0px;">
		<?php echo component_title("Files Upload")?>
	</div>
	<?php foreach($publications as $pub){?>
		<div style="margin-bottom:15px;">
			<div class="header_update">
				<?php echo $pub['submodul']?>
                <div class="pull-right">
                    <?php //if(is_user_role($user,"SYSTEM ADMINISTRATOR") ||is_user_role($user,"POLICY ADMINISTRATOR")){ ?>
                    <a onclick="show_form_files('<?php echo $modul?>','<?php echo $pub['submodul']?>','');"><?php plus_icon()?></a>
                    <?php //} ?>
                </div>
			</div>
			<div class="content_update" style="padding-top:10px;">
				<?php if(!$pub['content']){?><div style="color:#c5c5c5; font-size:14px;display:block;">No Files</div><?php }else{?>
						<?php foreach($pub['content'] as $row){?>
							<div style="margin-bottom:10px" class="file_<?php echo $row->id?>">
								<div style="float:left; width:80%">
                                    <?php if($row->full_url){?>
                                        <a href="<?php echo base_url()?><?php echo $row->full_url;?>">
                                    <?php }else{ ?>
									   <a href="<?php echo base_url()?>assets/uploads/<?=$modul?>/publications/<?php echo $row->file_name;?>">
                                    <?php } ?>
										<div style="height:20px; overflow:hidden"><span title="<?php echo $row->title?>"><?=long_text_real($row->title,20);?></span></div>
									</a>
									<div style="color:#c5c5c5; font-size:12px; float:left;"></div>
									<div style="color:#a3a3a3; font-size:12px; float:left;"><?=date("d F y",strtotime($row->created));?></div>
								</div>
								<div style="text-align:right; padding-right:10px; float:left; width:20%; font-size:12px;">
									<?php if(($user['id'] == $row->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR") || is_user_role($user,"POLICY ADMINISTRATOR")){?>
										<!--<a onclick="delete_files_upload(<?php echo $row->id?>)">
                                            <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                        </a>-->
									<?php }?>
								</div><div style="clear:both"></div>
							</div>
						<?php }?>
						<a onclick="see_all_files('<?= $modul?>','<?= $pub['submodul']?>');"><div class="pull-right">See All ></div></a><div style="clear:both"></div>
					<?php }?>
			</div>
		</div>
	<?php }?>
</div>
<script type="text/javascript">
</script>