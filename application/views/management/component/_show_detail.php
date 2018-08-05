<style>
    .modal_detail > .modal-dialog {
        width:60% !important;
    }
    .lg-backdrop{
        z-index: 1060 !important;
    }
    .lg-outer{
        z-index: 1065 !important;
    }
</style>
<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp=""; $data = $sharings[0];
?>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
    	<div class="modal-body">
            <div>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="pop_up_content_brobot">
                <div class="row" style=" margin-bottom:20px; padding-bottom: 5px; border-bottom: 1px solid #c3c3c3">
                    <div class="col-sm-2" style="height: 40px; overflow: hidden;">
                        <img class="right_text" style="height: 80px;" src="<?=base_url()?>assets/img/general/brobot-owl.png">
                    </div>
                    <div class="col-sm-10 right_text" style="margin-top: 15px;">
                        <h3><?="Internal Sharing";?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 column">
                        <div class="shadow_box">
                            <div class="first_font center_text">
                                <h3><b><?php echo $data['mysharing']->title?></b></h3>
                            </div>
                            <div style="margin-top:30px; font-size:16px;"><p><?php echo $data['mysharing']->description?></p></div>
                            <div id="lightgallery">
                                <?php $arr_video = array(".mp4"); foreach($data['img'] as $files){?>
                                    <?php if(!in_array($files->ext, $arr_video)){?>
                                    <?php 
                                        if(is_dir("assets/uploads/mysharing/".$id."/thumb/")){
                                            $img = base_url().get_thumbnail_src($files->full_url);
                                        }else{
                                            $img = base_url().$files->full_url;
                                        }?>
                                    <div style="width:24%; height:130px; overflow:hidden; float:left; padding:2px;">
                                        <a class="item" href="<?php echo base_url()?><?php echo $files->full_url?>" >
                                            <img style="width:100%;" src="<?=$img?>">
                                        </a>
                                    </div>
                                    <?php }else{?>
                                        <video width="50%" controls>
                                            <source src="<?php echo base_url().$files->full_url?>">
                                        </video>
                                    <?php }?>
                                <?php }?>
                            </div><div style="clear:both"></div>
                            <?php if($data['attachment']){?>
                            <hr>
                            <b>Attachment</b>
                            <div style="margin-top:10px; max-width:80%">
                                <?php foreach($data['attachment'] as $file){?>
                                    <div class="file_<?php echo $file->id?>">
                                        <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                            <a href="<?php echo base_url()?><?php echo $file->full_url;?>">
                                                <span><img style="height:18px" src="<?= get_ext_icon($file->ext)?>"></span>
                                                <?php echo $file->title?>
                                            </a>
                                        </div>
                                        <div style="float:right; padding-right:10px;">
                                            <?php if(($user['id'] == $file->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                                <a onclick="delete_files_upload(<?php echo $file->id?>)">
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
                    <div class="col-md-4 column">
                        <div style="padding-left: 40px;">
                            <div class="header_side row">
                                <div class="col-md-2 col-xs-3">
                                    <div style="overflow:hidden; width: 100%; max-width: 40px; height: 40px; border-radius: 10px;">
                                        <?php employee_photo($data['mysharing'])?>
                                    </div>
                                </div>
                                <div class="col-md-10 col-xs-9" style="padding-right:0px;">
                                    <div style="margin-bottom: 10px;">
                                        <div style="width:100%;">
                                            <h4><?php echo $data['mysharing']->full_name?></h4>
                                            <div class="second_font">
                                                <span><?php echo date("M, d Y",strtotime($data['mysharing']->mysharing_show_date));?></span>
                                                <?php if(count($views) > 0){?>
                                                     &bull; 
                                                    Seen by     
                                                    <?php 
                                                        if(count($views) > 1){ 
                                                        
                                                        $title="";foreach($views as $view){
                                                        if($title){$title.=", ".$view->full_name;}else{$title = $view->full_name;}}
                                                    ?>
                                                        <a class="second_font" title="<?=$title?>" data-toggle="tooltip" data-placement="bottom"><?= count($views)." Users";?></a>
                                                    <?php }else{echo $views[0]->full_name;}?>
                                                    
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr style="margin:5px 0 5px">
                            <div style="margin-top: 20px;">
                                <?=$comment_view?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
        $("#lightgallery").lightGallery({
        	selector: '.item'
        }); 
    });
</script>