<div class="component_part">
    <div class="component_part_content">
            <div class="title_section">
                <div class="row">
                    <div class="col-md-1 img_section">
                        <img src="<?=base_url()?>assets/img/general/Logo lampu.png">
                    </div>
                    <div class="col-md-6">
                        <div class="part_title">BAPEKIS SHARING</div>
                    </div>
                </div>
            </div>
            <div class="body_section">
                <?php foreach($category_sharings as $category => $sharings){ if($sharings){?>
                    <div style="padding: 0px 0 40px 0">
                        <div style="padding-left: 15px;">
                            <div style="font-size: 25px; font-weight: normal"><?=$sharings[0]->category?></div>
                            <div style="font-size: 16px; color: #aaa;"><?=$sharings[0]->category_description?></div>
                        </div>
                        <div class="row" style="padding: 15px 0 0 0;">
                            <?php foreach($sharings as $sharing){?>
                                <div class="col-md-4" style="padding: 0 0px 0 18px;">
                                    <div class="box_subpart">
                                        <div class="row">
                                            <div class="col-md-4 col-xs-5" style="padding: 0;">
                                                <div style="width: 100%; height: 120px; overflow: hidden;" id="<?=$sharing->id?>_banner_sharing_parent">
                                                    <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
                                                </div>
                                                <script type="text/javascript">
                                                    //or however you get a handle to the IMG
                                                    adjust_img_size('<?=$sharing->id?>_banner_sharing','');
                                                </script>
                                            </div>
                                            <div class="col-md-8 col-xs-7" style="padding-left: 0px;">
                                                <div style="padding: 5px 10px 5px 10px;">
                                                    <span style="font-size: 10px; color: #929292"><?=date("M j, Y")?></span>
                                                    <div class="news_title"><?=get_long_text_real($sharing->title,80)?></div>
                                                    
                                                </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                        
                    </div>
                <?php }}?>
            </div>
        </div>
    </div>
</div>