<div>
	<div class="row">
        <div class="col-md-7">
            <?php if($event->full_url){?>
                <div style="width: 200px; margin: 0 auto; margin-bottom: 40px;">
                    <img id="<?=$event->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$event->full_url?>">
                </div>
            <?php }?>
            <div>
                <div>
            		<h3><?=$event->title?></h3>
            		<h6 style="margin-top: 8px">
            			<?=date("D, j M y", strtotime($event->start))?>
            			<?=dot_devider()?>
            			<?=$event->category?>
            		</h6>
            	</div>
            	<div style="margin-top: 40px">
            		<p><?=$event->description?></p>
            	</div>
            </div>
        </div>
        <div class="col-md-5">
            <?php if($attachments){?>
                <b>Attachment</b>
                <div style="margin-top:10px; max-width:80%">
                    <?php foreach($attachments as $file){?>
                        <div class="row file_<?php echo $file->id?>">
                            
                            <div class="col-xs-1" style="">
                                <span><img style="height:18px" src="<?=get_ext_office($file->ext)?>"></span>
                            </div>
                            <div class="col-xs-11" >
                                <a class="news_title" href="<?php echo base_url()?><?php echo $file->full_url;?>"><?= $file->title?></a>
                            </div>
                        </div>
                    <?php }?>
                </div>
            <?php }?>

            <?php if($galleries){?>
                <hr>
                <b>Photo Galleries</b>
                <div id="lightgallery" style="margin-top:10px;">
                    <?php foreach($galleries as $files){?>
                        
                            <a class="item" href="<?php echo base_url()?><?php echo $files->full_url?>" >
                                <img style="" src="<?=base_url().get_thumbnail_src($files->full_url);?>">
                            </a>
                        
                    <?php }?>
                </div><div style="clear:both"></div>
            <?php }?>

        </div>
     </div>
</div>

<script>
    $(document).ready(function() {
        $("#lightgallery").lightGallery({
            selector: '.item'
        }); 

        $("#lightgallery").justifiedGallery({
            rowHeight : 70,
            
            margins : 3
        });
    });
</script>   