<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
?>
<div>
    <?php if($sharings){foreach ($sharings as $data) {?>
        <div id="mysharing_<?php echo $data['mysharing']->mysharing_id?>" class="row shadow_box mysharing_member">
            <div class="col-md-1 col-xs-3">
                <div style="overflow:hidden; width: 100%; max-width: 40px; height: 40px; border-radius: 10px;">
                    <?php employee_photo($data['mysharing'])?>
                </div>
            </div>
            <div class="col-md-11 col-xs-9" style="padding-right:0px;">
                <div class="sharing_header" style="margin-left:0px;">
                    <div style="margin-bottom: 10px;">
                        <div style="width:100%; font-size:12px;" class="second_font">
                            <span><?php echo $data['mysharing']->full_name?></span> &bull;
                            <span><?php echo date("M, d Y",strtotime($data['mysharing']->created_at));?></span>

                            <div style="float: right">
                            <?php if(($user['id'] == $data['mysharing']->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                <a onclick="show_sharing_form(<?php echo $data['mysharing']->mysharing_id?>,'internal');" class="btn btn-link btn-link-edit">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a onclick="delete_mysharing(<?php echo $data['mysharing']->mysharing_id?>,'')">
                                    <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                </a>
                            <?php }?>
                            </div>
                        </div>
                        <h4><a onclick="show_mysharing_detail(<?php echo $data['mysharing']->mysharing_id?>);"><?php echo $data['mysharing']->title?></a></h4>
                    </div>
                    <div>
                        <?php echo long_text_real(strip_tags($data['mysharing']->description),200)?>
                    </div>
                    <?php if(is_dir("assets/uploads/mysharing/".$data['mysharing']->mysharing_id."/thumb/")){?>
                    <div><a onclick="show_detail(<?php echo $data['mysharing']->mysharing_id?>);">
                        <?php $j=0; foreach($data['img'] as $files){?>
                            <?php if($j<4){ $arr_video = array(".mp4");?>
                                <?php if(!in_array($files->ext, $arr_video)){?>
                                    <div style="width:24%; height:80px; overflow:hidden; float:left; padding:2px;">
                                        <img style="width:100%;" src="<?php echo base_url()?><?php echo get_thumbnail_src($files->full_url)?>">
                                    </div>
                                <?php }else{?>
                                    <video width="50%" controls>
                                        <source src="<?php echo base_url().$files->full_url?>">
                                    </video>
                                <?php }?>
                        <?php }$j++;}?><div style="clear:both"></div>
                    </a></div>
                    <?php }?>
                    
                </div>
            </div>
        </div>
    <?php }}else{?>
        <h3 class="helper_text center_text" style="margin-top: 40px;">No Content Yet</h3>
    <?php }?>
</div>