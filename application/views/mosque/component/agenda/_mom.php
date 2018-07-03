<?php $user = $this->session->userdata('userbapekis'); ?>

<div>
    <?php if(!isset($mom)){?>
        <div class="center_text" style="margin-top: 60px;">
            <a class="btn btn-broventh btn-third btn-lg btn-circle"><span class="glyphicon glyphicon-list-alt"></span></a>
            <h4 style="margin-top: 20px;">You haven't created MoM yet.</h4>
            <div style="margin-top: 10px;"><a onclick="show_mom_form(<?=$meeting_id?>)" class="btn btn-first btn-broventh">
                <span class="glyphicon glyphicon-edit" style="margin-right: 4px;"></span> Start Creating One </a>
            </div>
        </div>
    <?php }else{?>
    <div class="broventh_submenu_div" style="margin-top: 0px;">
        <div class="broventh_submenu_title no_border">
            <div class="row">
                <div class="col-md-12">
                    <?php if($mom->mom_status=='draft'){ ?>
                        <a onclick="show_mom_form(<?=$meeting_id?>)" class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-pencil"></span></a>
                    <?php }else{ ?>
                        <a href="<?=base_url()?>meeting/detail_mom/<?=$mom->mom_id?>" class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-print"></span></a>
                    <?php } ?>
                    Minute of Meetings
                </div>
            </div>
        </div>
        <div class="broventh_submenu_body">
            <div class="broventh_card">
                <div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-pencil"></span></div>
                        <div class="col-xs-10"><a href="<?=base_url()?>meeting/detail_mom/<?=$mom->mom_id?>"><?=$mom->title?></a></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-user"></span></div>
                        <div class="col-xs-10"><?=$mom->full_name?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-calendar"></span></div>
                        <div class="col-xs-10"><?=date("j M y",strtotime($mom->updated_date))?></div>
                    </div>
                </div><hr>
                <div>
                    <h6 class="news_title">Mom Attachment</h6>
                    <div>
                        <?php if($mom_attachment){?>
                        <div style="margin-top:10px; max-width:100%">
                            <?php foreach($mom_attachment as $file){?>
                                <div class="file_<?php echo $file->id?>">
                                    <div class="row" style="padding-right:10px;">
                                        <div class="col-xs-1">
                                            <img style="height:18px" src="<?=get_ext_office($file->ext)?>">
                                        </div>
                                        <div class="col-xs-11">
                                            <a href="<?php echo base_url()?><?=$file->full_url;?>"><?=long_text(str_replace("_", " ", $file->title),34)?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</div>