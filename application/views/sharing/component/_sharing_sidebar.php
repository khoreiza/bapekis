<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
?>

<?php if(!$this->uri->segment(2)){?>
<div class="flat_box">
    <div class="flat_box_header">
        <div class="fbh_logo">
            <span class="glyphicon glyphicon-heart"></span>
        </div>
        <div class="fbh_title">
            Recommended Sharing for You
        </div>
        <div style="clear: both"></div>
    </div>
    <div class="flat_box_content">
        <div class="third_font center_text" style="padding: 20px;"><h4>Under Development</h4></div>
    </div>
</div>
<?php }?>

<?php if($my_sharings){?>
<div class="flat_box">
    <div class="flat_box_header">
        <div class="fbh_logo">
            <span class="glyphicon glyphicon-user"></span>
        </div>
        <div class="fbh_title">
            Your Own Sharing
        </div>
        <div style="clear: both"></div>
    </div>
    <div class="flat_box_content">
        <?php $i=1; foreach ($my_sharings as $data) {?>
            <div id="mysharing_<?php echo $data['mysharing']->mysharing_id?>" class="fbc_content <?php if($i>5){echo "fbc_content_hidden";}?>" style="<?php if($i>5){echo "display: none";}?>">
                <div class="" style="padding-right:0px;">
                    <div class="sharing_header" style="margin-left:0px;">
                        <div style="margin-bottom: 5px;">
                            <div style="width:100%; font-size:12px;" class="second_font">
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
                            <h4><a onclick="show_detail(<?php echo $data['mysharing']->mysharing_id?>);"><?php echo $data['mysharing']->title?></a></h4>
                        </div>
                        <div>
                            <?php echo long_text_real(strip_tags($data['mysharing']->description),100)?>
                        </div>
                    </div>
                </div>
            </div>
        <?php $i++;}?>
        <?php if(count($my_sharings) > 5){?>
            <div style="margin-top: 5px; padding: 10px;" class="center_text">
                <a class="btn btn-brobot btn-tosca" onclick="toggle_visibility_class('fbc_content_hidden')">See All</a>
            </div>
        <?php }?>
    </div>
</div>
<?php }?>