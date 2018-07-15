<?php 
    if($mosque->full_url){
        $img_url = base_url().$mosque->full_url;
    }else{
        $img_url = get_calendar_category($mosque->category,date("H",strtotime($mosque->start)));
    }
?>
<style type="text/css">
    .hero-image {
      max-width: 120%;
      height: 250px; overflow: hidden;
      margin:-30px -10px;
      padding: 15px;
    }

    .header_cal_img{
        border-radius: 5px;
        height: 200px;
        background-image: url(<?=$img_url?>);
        background-size: 100%;
        background-repeat: no-repeat;
    }
    .show_header_option{
        margin-right: 5px;
    }
</style>
<?php 
	$user = $this->session->userdata('userbapekis');
?>
<div id="" class="container_broventh container_broventh_small">
    <div class="row">
        <div class="col-md-8">
            <div id="header_cal">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?=base_url()?>mosque" class="btn btn-broventh btn-third btn-sm"><span class="glyphicon glyphicon-chevron-left"></span> LIST MOSQUE</a>
                    </div>
                </div>
                <div class="broventh_card_transparent" style="margin-top: 20px;">
                    <div class="row">
                        <div class="col-md-4">
                            <div style="margin-top: 20px;">
                                <div class="hero-image" style="">
                                    <div class="header_cal_img"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div style="margin-top: 20px; padding: 10px;">
                                <div class="">
                                    <h2 class="page_title"><?=$mosque->name?></h2>
                                    <h4 style="margin: 10px 0 10px 0;">
                                        <?=$mosque->region?>
                                        <?=($mosque->location) ? " ".dot_devider()." ".$mosque->location : "" ?>
                                    </h4>
                                    <div style="margin-top: 10px;">
                                        <?=$mosque->note?>
                                    </div>
                                </div>
                                <hr>
                                <div class="">
                                     <a onclick="show_calendar_form('','mosque',<?=$mosque->mosque_id?>)" class="btn btn-broventh btn-white show_header_option">
                                        <span class="glyphicon glyphicon-calendar"></span> Add Event
                                    </a>
                                     <a onclick="show_sharing_form('','<?=$mosque->mosque_id?>');" class="btn btn-broventh btn-white show_header_option">
                                        <span class="glyphicon glyphicon-volume-up"></span> Add News
                                    </a>
                                     <a onclick="show_add_mosque_form(<?=$mosque->mosque_id?>)" class="btn btn-broventh btn-white show_header_option">
                                        <span class="glyphicon glyphicon-tasks"></span> Add Financial
                                    </a>
                                    <a onclick="show_add_mosque_form(<?=$mosque->mosque_id?>)" class="btn btn-broventh btn-edit show_header_option">
                                        <span class="glyphicon glyphicon-pencil"></span> Edit Data
                                    </a>
                                    <a onclick="show_add_mosque_form(<?=$mosque->mosque_id?>)" class="btn btn-broventh btn-delete edit_color">
                                        <span class="glyphicon glyphicon-trash"></span> Delete Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="broventh_card menu_bar_nav">
                <div class="menu_bar_header_nav">
                    <div class="row">
                        <div class="menu_bar">
                            <div class="menu_bar_nav mosque_show_nav" id="overview_nav"><a onclick="change_div_component_info('overview', 'mosque_show')">Overview</a></div>
                        </div>
                        <div class="menu_bar">
                            <div class="menu_bar_nav mosque_show_nav" id="event_nav"><a onclick="change_div_component_info('event', 'mosque_show')">Events</a></div>
                        </div>
                        <div class="menu_bar">
                            <div class="menu_bar_nav mosque_show_nav" id="news_nav"><a onclick="change_div_component_info('news', 'mosque_show')">News</a></div>
                        </div>
                        <div class="menu_bar">
                            <div class="menu_bar_nav mosque_show_nav" id="financial_nav" ><a onclick="change_div_component_info('financial', 'mosque_show')">Financial</a></div>
                        </div>
                        <div class="menu_bar">
                            <div class="menu_bar_nav mosque_show_nav" id="photos_nav" ><a onclick="change_div_component_info('photos', 'mosque_show')">Photos</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu_content_section" id="mosque_show_content">
            </div>
        </div>
        <div class="col-md-3" style="padding-left: 20px;">
            <div style="margin-top: 30px;">
                <?=$files_upload?>
            </div>
        </div>
    </div> 
    
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/mosque.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/calendar.js"></script>
<script type="text/javascript">
    get_mosque_show_data(<?=$mosque->mosque_id?>);





    $(document).ready(function () {
        $('input[type=file]').bootstrapFileInput();
        $('.file-input-wrapper').html('<span class="glyphicon glyphicon-camera"></span><input type="file" name="photos[]" multiple onchange="upload_cal_documentation()" style="margin-right: 10px; left: -378.312px; top: -9.5px;">');
        $('.file-input-wrapper').addClass('btn-broventh btn-circle btn-first btn-lg');

    });

    




    function upload_cal_documentation(){
        $("#form_documentation").ajaxForm({ 
            beforeSend: function() {
                $("#progress").show();
                $("#message").show();
                //clear everything
                $("#bar").width('0%');
                $("#message").html("");
                $("#percent").html("0%");
                
            },
            uploadProgress: function(event, position, total, percentComplete) 
            {
                $("#bar").width(percentComplete+'%');
                $("#percent").html(percentComplete+'%');
                if(percentComplete==100){
                    $("#message").html("Processing ...");
                }
            },
            success: function(resp) 
            {
                $("#progress").hide();
                $("#message").html("");
                $("#list_of_doc").html(resp.result);
                /*window.setTimeout( function(){$('#message').slideUp();}, 2500);*/
            },
            error: function()
            {
                $("#message").html("<font color='red'> ERROR: unable to upload files</font>");

            }
        }).submit();
    }
</script>