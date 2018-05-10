<?php $user = $this->session->userdata('userbapekis');?>

<?php foreach($publications as $pub){?>
	<div style="margin-top: 25px;">
		<div style="margin-right: -10px;" class="right_text">
			<a onclick="show_form_files('<?php echo $modul?>','<?php echo $pub['submodul']?>','',<?=(isset($ownership_id)) ? $ownership_id : 0?>);" class="btn btn-broventh btn-circle btn-first" style="height: 22px; width: 22px; font-size: 12px; padding: 3px 0 0 1px;"><span class="glyphicon glyphicon-plus"></span></a>
		</div>
		<div class="broventh_card" style="padding: 10px 15px 10px 15px; margin-top: -32px; <?=($pub != end($publications)) ? "border-bottom:1px solid #e2e2e2" : ""; ?>">
			<?php if(is_array($submodul)){?>
				<h4 class="news_title"><?= $pub['submodul']?></h4>
			<?php }?>
			<?php $div_id = str_replace(" ", "_", $pub['submodul']); ?>
			<div id="submodul_div_<?=$div_id?>">
				<div class="content_update" style="padding-top:10px;">
					<?php if(!$pub['content']){?>
						<div class="third_font center_text">No File</div>
					<?php }else{?>
							<div class="text_description">
								<?php foreach($pub['content'] as $row){?>
									
									<div class="file_<?=$row->id?>" style="overflow: hidden; <?=($row != end($pub['content']) && !is_array($submodul)) ? "border-bottom:1px solid #e2e2e2; padding-bottom:5px; margin-bottom: 8px;" : "margin-bottom: 8px;"; ?>">
	                                    <div class="row">
	                                        <div class="col-md-2" style="max-width: 35px !important;">
	                                        	<div style="height: 22px;"><img style="height:100%" src="<?php echo base_url()?>assets/img/icon/<?= get_file_ext_office($row->ext)?>"></div>
	                                        </div>
	                                        <div class="col-md-10">
	                                            <div style="overflow: hidden; height: 16px; font-size: 12px" class="condens_font">
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
							<div class="right_text" style="font-size: 10px; margin-top: 10px;">
								<a onclick="see_all_files('<?= $modul?>','<?= $pub['submodul']?>','<?=(isset($ownership_id)) ? $ownership_id : ""?>');">Show All <span class="glyphicon glyphicon-menu-down"></span></a>
							</div>
							
						<?php }?>
				</div>
			</div>
		</div>
	</div>
<?php }?>