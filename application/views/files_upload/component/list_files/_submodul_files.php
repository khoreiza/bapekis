<?php 
	$user = $this->session->userdata('userbapekis');
	$pub = $publications[$submodul];
?>


<div class="content_update" style="padding-top:10px;">
	<?php if(!$pub['content']){?>
		<div class="third_font center_text">No File</div>
	<?php }else{?>
			<div>
				<?php foreach($pub['content'] as $row){?>
					
					<div class="file_<?=$row->id?>" style="overflow: hidden; <?=($row != end($pub['content']) && !is_array($submodul)) ? "border-bottom:1px solid #e2e2e2; padding-bottom:5px; margin-bottom: 8px;" : ""; ?>">
                        <div class="row">
                            <div class="col-md-2" style="max-width: 35px !important;">
                            	<div style="height: 20px;"><img style="height:100%" src="<?php echo base_url()?>assets/img/icon/<?= get_file_ext($row->ext)?> - color.png"></div>
                            </div>
                            <div class="col-md-10">
                                <div style="overflow: hidden; height: 17px;">
                                	<?php if($row->full_url){?>
                                        <a target="_blank" href="<?= base_url()?><?= $row->full_url;?>">
                                    <?php }else{ ?>
									   <a target="_blank" href="<?= base_url()?>assets/uploads/<?=$modul?>/publications/<?= $row->file_name;?>">
                                    <?php } ?>
										<?php long_text(str_replace("_", " ", $row->title),25)?>
									</a>
                                </div>
                                <div style="font-size: 10px;" class="third_font"><?= date("j M y", strtotime($row->created))?></div>
                            </div>
                        </div>
                    </div>
				<?php }?>
			</div>
			<div class="right_text" style="font-size: 12px;">
				<a onclick="see_all_files('<?= $modul?>','<?= $pub['submodul']?>','<?=(isset($ownership_id)) ? $ownership_id : ""?>');">See All ></a>
			</div>
			
		<?php }?>
</div>