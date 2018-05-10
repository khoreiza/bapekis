<?php 
	$user = $this->session->userdata('userbapekis');
?>
<div class="row">
    <div class="col-md-8 column">
        <div class="shadow_box">
            <div class="right_text" style="font-size: 12px;">
				<a onclick="show_input_form('<?php echo $news->id?>','<?=$news->modul?>');" class="edit_color"><span class="glyphicon glyphicon-pencil"></span></a>
                <a onclick="delete_news('<?php echo $news->id?>','<?=$news->modul?>');" class="delete_color"><span class="glyphicon glyphicon-trash"></span></a>
			</div>
            <div class="first_font center_text">
                <h4 class="third_font" style="margin-bottom: 5px;">
                    <?php if($news->sub_modul && $news->sub_modul != 'kartini'){?>
                        <?=$news->sub_modul?><?=($news->modul == "market") ? " Outlook" : ""?>
                    <?php }?>
                </h4>
                <h3><b><?php echo $news->title?></b></h3>
            </div>
            <div style="margin:20px 0 20px 0">
            	<?php if($news->photo){?>
					<div style="margin:0 auto; text-align:center">
						<img style="margin-left:0px; height:150px;" src="<?=base_url()."assets/uploads/market/photos/".$news->photo;?>">
					</div>
				<?php } else{if($photo){?>
	                <div style="margin:0 auto; text-align:center">
                        <?php if($news->modul == "product_knowledge"){?>
                            <img style="margin-left:0px; width:100%;" src="<?php echo base_url()?><?php echo $photo[0]->full_url;?>">
                        <?php } if($news->modul == "competition"){?>
                            <img style="margin-left:0px; width:100%;" src="<?php echo base_url()?><?php echo $photo[0]->full_url;?>">
                        <?php } else { ?>
                            <img style="margin-left:0px; height:150px;" src="<?php echo base_url()?><?php echo $photo[0]->full_url;?>">
                        <?php }?>
					</div>
                <?php }}?>
            </div>
            <div style="margin-top:30px; font-size:16px;"><p><?php echo $news->description?></p></div>
            <?php if($attachments){?>
            <hr>
            <b>Attachment</b>
            <div style="margin-top:10px; max-width:80%">
                <?php foreach($attachments as $file){?>
                    <div class="row file_<?php echo $file->id?>">
                        <div class="col-xs-1" style="">
                            <span><img style="height:18px" src="<?= get_ext_icon($file->ext)?>"></span>
                        </div>
                        <div class="col-xs-9" style="">
                        	<a href="<?=base_url().$file->full_url?>" target="_blank"><?php long_text($file->title,30)?></a>
                        </div>
                        <div class="col-xs-2" style="">
                            <?php if(($user['id'] == $file->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                <a onclick="delete_files_upload(<?php echo $file->id?>,'file')">
                                    <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                </a>
                            <?php }?>
                        </div><div style="clear:both"></div>
                    </div>
                <?php }?>
            </div>
            <?php }?>

            <?php if($galleries){?>
            <hr>
            <b>Photo Galleries</b>
            <div id="lightgallery" style="margin-top:10px;">
                <?php foreach($galleries as $files){?>
                    <div style="width:24%; height:100px; overflow:hidden; float:left; padding:2px;">
                        <a class="item" href="<?php echo base_url()?><?php echo $files->full_url?>" >
                            <img style="width:100%;" src="<?=base_url().get_thumbnail_src($files->full_url);?>">
                        </a>
                    </div>
                <?php }?>
            </div><div style="clear:both"></div>
            <?php }?>
        </div>
    </div>
    <div class="col-md-4 column">
        <div style="padding-left: 40px;">
            <div class="header_side row">
                <div class="col-md-2 col-xs-3">
                    <div style="overflow:hidden; width: 100%; max-width: 40px; height: 40px; border-radius: 10px;">
                        <?php employee_photo($news)?>
                    </div>
                </div>
                <div class="col-md-10 col-xs-9" style="padding-right:0px;">
                    <div style="margin-bottom: 10px;">
                        <div style="width:100%;">
                            <h4><?php echo $news->full_name?></h4>
                            <div class="second_font">
                                <span><?php echo date("M, d Y",strtotime($news->created));?></span>
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
<script>
$(document).ready(function() {
        $("#lightgallery").lightGallery({
        	selector: '.item'
        }); 
    });
</script>	