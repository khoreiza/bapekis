<?php $user = $this->session->userdata('userbapekis');?>
<div class="menu_section_title">
	<div>LATEST MOSQUE NEWS</div>
</div>
<div>
	<div class="row">
		<?php foreach($sharings as $sharing){?>
			<div class="col-md-3">
				<div class="broventh_card">
					<div id="mysharing_<?=$sharing->mysharing_id?>" class="mysharing_member">
	                    <div style="height: 299px; overflow: hidden; ">
	                        
	                        <div style="height: 270px; overflow: hidden;">
	                            <?php if($sharing->full_url){?>
	                                <div style="width: 100%; height: 165px; overflow: hidden; padding: 0px; margin-top: -10p">
	                                    <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
	                                </div>
	                            <?php }?>
	                            <div style="margin-top: 10px;">
	                                <span class="category_label"><?=($sharing->category) ? $sharing->category : "Others"?></span>
	                                <?php if($sharing->full_url){?>
	                                    <h4 class="news_title" style="margin-top: 10px;"><a onclick="show_mysharing_detail(<?php echo $sharing->mysharing_id?>);"><?= get_long_text_real($sharing->title,106)?></a></h4>
	                                <?php }else{?>
	                                    <h3 class="news_title" style="margin-top: 10px;"><a onclick="show_mysharing_detail(<?php echo $sharing->mysharing_id?>);"><?= get_long_text_real($sharing->title,120)?></a></h3>
	                                    <div style="margin-top: 10px">
	                                        <?php echo long_text_real(strip_tags($sharing->description),180)?>
	                                    </div>
	                                <?php }?>
	                            </div>
	                        </div>
	                        <div class="row" style="margin-top: 10px;">
	                            <div class="col-md-10">
	                                <div class="photo_frame_circle" style="width: 20px; height: 20px; margin: 0px 10px 0 0px; float: left;">
	                                    <?=employee_photo_thumb_small($sharing)?>
	                                </div>
	                                <h6 class="news_title" style="float: left; padding-top: 5px;">
	                                    <a onclick="show_user_detail(<?=$sharing->created_by?>)"><?=get_long_text(get_user_nick_name($sharing),100)?></a>
	                                    <?=dot_devider()?>
	                                    <?=($sharing->date != "0000-00-00") ? date('j M y', strtotime($sharing->date)) : date('j M y', strtotime($sharing->created_at))?>
	                                </h6>
	                            </div>
	                            <div class="col-md-2 right_text" style="font-size: 10px;">
	                                <?php if(($user['id'] == $sharing->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
	                                    <a onclick="show_sharing_form(<?=$sharing->mysharing_id?>, <?=$sharing->mosque_id?>);" class="edit_color">
	                                        <span class="glyphicon glyphicon-pencil"></span>
	                                    </a>
	                                    <a onclick="delete_mysharing(<?php echo $sharing->mysharing_id?>,'')">
	                                        <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
	                                    </a>
	                                <?php }?>
	                            </div>
	                        </div>
	                        
	                    </div>
	                </div>
				</div>
			</div>
		<?php }?>
	</div>
</div>