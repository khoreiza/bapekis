<style type="text/css">
    #chartdiv_growth{
        width:100%;
        height:148px !important;
    }
</style>
<?php $user = $this->session->userdata('userbapekis');?>

<div id="" class="container_broventh container_broventh_small">
    <div style="margin-bottom: 20px;">
        <a href="<?=base_url()?>meeting" style="font-size: 12px;"><span class="glyphicon glyphicon-menu-left"></span> MEETING ROOM PAGE</a>
    </div>
    <div class="row" style="">
        <div class="col-md-8">
            <div style="margin-bottom: 0px;">
                <h2 class="page_title"><?=get_long_text($agenda->title,200)?></h2>
                <p class="broventh_page_description" id="principal_desc">
                    <?=get_long_text_real($agenda->description,2000)?>
                </p>
            </div>
            <div id="agenda_content_div">
                <div class="row">
                    <div class="col-md-6" style="padding-right: 20px;">
                        <?=$general_info_div?>
                    </div>
                    <div class="col-md-6" style="padding-left: 20px ">
                        <?=$mom_div?>
                        <div class="row">
                            <div class="col-md-12">
                                <?=$activity_steps_div?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 broventh_sidebar column">
            <div class="square_box" style="margin-top:10px;">
                <div class="square_box_body">
                    <div class="section_border_separation">
                        <h3 style="padding-top: 5px;">Disscussion Box</h3>
                    </div>
                    <div>
                        <?=$comment_view?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/meeting_new.js"></script>