<style type="text/css">
    .mysharing_member{
        margin-bottom: 0px;
    }
</style>
<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
?>
<div>
    <?php if($sharings){?>
        <div class="row">
            <?php if(isset($first_time) && $first_time){ $sharing = $sharings[0]?>
                <div class="col-md-9 mysharing_member" id="<?=$sharing->mysharing_id?>" style="padding: 10px 20px 5px 20px;">
                    <div style="height: 242px; overflow: hidden;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-10">
                                <div class="photo_frame_circle" style="width: 20px; height: 20px; margin: 0px 10px 0 0px; float: left;">
                                    <?=employee_photo_thumb_small($sharing)?>
                                </div>
                                <h5 class="news_title" style="float: left; padding-top: 5px;">
                                    <a onclick="show_user_detail(<?=$sharing->created_by?>)"><?=get_long_text($sharing->full_name,100)?></a>
                                    <?=dot_devider()?>
                                    <?=date('j M y', strtotime($sharing->date))?>
                                </h5>
                            </div>
                            <div class="col-md-2 right_text" style="font-size: 10px; padding-top: 5px;">
                                <?php if(($user['id'] == $sharing->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                    <a onclick="show_sharing_form(<?php echo $sharing->mysharing_id?>,'internal');" class="edit_color">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <a onclick="delete_mysharing(<?php echo $sharing->mysharing_id?>,'')">
                                        <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                    </a>
                                <?php }?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div style="width: 100%; height: 325px; overflow: hidden; padding: 0px;" id="<?=$sharing->id?>_banner_sharing_parent">
                                    <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
                                </div>
                                <script type="text/javascript">
                                    //or however you get a handle to the IMG
                                    //adjust_img_size('<?=$sharing->id?>_banner_sharing');
                                </script>
                            </div>
                            <div class="col-md-6" style="margin-top: 0px;">
                                <span class="category_label"><?=($sharing->category) ? $sharing->category : "OTHERS"?></span>
                                <h3 style="margin-top: 10px;" class="news_title">
                                    <a onclick="show_mysharing_detail(<?=$sharing->mysharing_id?>);"><?=get_long_text_real($sharing->title,90)?></a>
                                </h3>
                                <div style="margin-top: 10px">
                                    <?php echo long_text_real(strip_tags($sharing->description),290)?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php unset($sharings[0]);}?>

            <?php foreach ($sharings as $sharing) {?>
                <div id="mysharing_<?=$sharing->mysharing_id?>" class="col-md-3 mysharing_member" style="padding: 10px 20px 5px 20px; margin-bottom: 10px;">
                    <div style="height: 255px; overflow: hidden; ">
                        <div class="row" style="margin-bottom: 10px;">
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
                                    <a onclick="show_sharing_form(<?php echo $sharing->mysharing_id?>,'internal');" class="edit_color">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <a onclick="delete_mysharing(<?php echo $sharing->mysharing_id?>,'')">
                                        <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                        <div>
                            <?php if($sharing->full_url){?>
                                <div style="width: 100%; height: 125px; overflow: hidden; padding: 0px;">
                                    <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
                                </div>
                            <?php }?>
                            <div style="margin-top: 10px;">
                                <span class="category_label"><?=($sharing->category) ? $sharing->category : "Others"?></span>
                                <?php if($sharing->full_url){?>
                                    <h5 class="news_title" style="margin-top: 10px;"><a onclick="show_mysharing_detail(<?php echo $sharing->mysharing_id?>);"><?= get_long_text_real($sharing->title,120)?></a></h5>
                                <?php }else{?>
                                    <h4 class="news_title" style="margin-top: 10px;"><a onclick="show_mysharing_detail(<?php echo $sharing->mysharing_id?>);"><?= get_long_text_real($sharing->title,90)?></a></h4>
                                    <div style="margin-top: 10px">
                                        <?php echo long_text_real(strip_tags($sharing->description),180)?>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }else{?>
        <h3 class="helper_text center_text" style="margin-top: 40px;">No Content Yet</h3>
    <?php }?>
</div>