<style>
    .lg-backdrop{
        z-index: 1060 !important;
    }
    .lg-outer{
        z-index: 1065 !important;
    }
</style>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:<?=$popup_width?>; max-width: 100%;">
    <div class="modal-content">
    	<div class="modal-body" style="margin:-15px;">
            <div style="border-bottom:1px solid <?=array_color(10)?>; padding: 20px 20px 10px 20px; background-color: #fafafa;">
                <div class="row">
                    <div class="col-xs-1" style="max-width: 60px;">
                        <div class="cirlce_frame_broventh" style="">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </div>
                    </div>
                    <div class="col-xs-10">
                        <div class="row" style=" padding-left:10px; padding-bottom:5px;">
                            
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <h3 class="news_title"><?=$popup_title?></h3>
                                <?php if(isset($popup_subtitle)){?><h4 class="third_font"><?=$popup_subtitle?></h4><?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div>
            <div class="pop_up_content_broventh">
                <div id="loading_panel" class="center_text loading_panel" style="display:none; padding:5px; width:100%; background-color:white;">
                        <?php $rand_num = rand(1,7);?>
                        <img src="<?=base_url()?>assets/img/loader_images/Preloader_<?=$rand_num?>.gif">
                        <div>Loading Data . . .</div>
                    </div>
                <div>
                    <?=$popup_content?>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script>
    
</script>