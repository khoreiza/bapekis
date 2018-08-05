<?php $user = $this->session->userdata('userbapekis'); ?>
<div class="container_broventh container_broventh_small">
    <div>
        <div class="row">
            <div class="col-md-10">
                <h1 class="page_title">Tentang BAPEKIS Mandiri</h1>
                <p class="broventh_page_description">
                    Profil para pengurus BAPEKIS Mandiri
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 column" style="padding-right: 20px;">
            <div class="broventh_submenu_div" style="margin-top: 0px;">
                <div class="broventh_submenu_title no_border">
                </div>
                <div class="broventh_submenu_body">
                    <div id="list_of_member">
                        <div id="ceo" style="padding: 0 40px 0 40px">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="photo_frame_circle" style="width: 180px; height: 180px; margin: 0px 10px 0 0px; float: left;">
                                        <?=employee_photo($members[0])?>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h4><?=$members[0]->jabatan?></h4>
                                    <h2 class="news_title" style="margin:5px 0 25px 0"><?=$members[0]->full_name?></h2>
                                    <h4><?=$members[0]->description?></h4>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 40px;">
                            <div class="row">
                                        <?php unset($members[0]); $prev_group=""; foreach($members as $member){?>
                                            <?php if($prev_group != $member->group){?>
                                                <?php if($prev_group){?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            <div class="col-md-6">
                                                
                                                <div class="row">
                                            <?php }?>
                                                    <div class="col-md-6" style="margin: 20px 0 40px 0;">
                                                        <div class="center_text">
                                                            <div class="photo_frame_circle" style="width: 140px; height: 140px; margin:0 auto; margin-bottom: 10px;">
                                                                <?=employee_photo($member)?>
                                                            </div>
                                                            <div>
                                                                <h4 class="news_title"><?=$member->full_name?></h4>
                                                                <h5 style="margin-top: 5px;"><?=$member->jabatan?></h5>
                                                                <h5 style="margin-top: 5px;"><?=($prev_group != $member->group) ? get_long_text($member->group,100) : ''?></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                        <?php $prev_group = $member->group;}?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 column broventh_left_content" style="padding-left: 20px;">
            <div class="broventh_card">
                <h4 class="center_text">Kontak BAPEKIS</h4><hr>
                <div style="margin-top: 20px;">
                    <div class="row">
                        <div class="col-xs-1" style="width: 25px;"><span class="glyphicon glyphicon-home"></span></div>
                        <div class="col-xs-10">Jl. Jend. Gatot Subroto Kav.36-38 Jakarta 12190</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1" style="width: 25px;"><span class="glyphicon glyphicon-phone"></span></div>
                        <div class="col-xs-10">021-5263553</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1" style="width: 25px;"><span class="glyphicon glyphicon-envelope"></span></div>
                        <div class="col-xs-10">bapekis@bankmandiri.co.id</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/mosque.js"></script>
<script type="text/javascript">

</script>