<?php 
    if($event->full_url){
        $img_url = base_url().$event->full_url;
    }else{
        $img_url = get_calendar_category($event->category,date("H",strtotime($event->start)));
    }
?>
<style type="text/css">
    .hero-image {
      max-width: 100%; 
      width: 800px;
      margin: auto;
      height: 140px; overflow: hidden;
    }

    .hero-image::after {
      display: block;
      position: relative;
      background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0, #fff 100%);
      margin-top: -190px;
      height: 195px;
      width: 100%;
      content: '';
      z-index: 100;
    }

    .header_cal_img{
        height: 140px;
        background-image: url(<?=$img_url?>);
        background-size: 100%;
    }
</style>
<?php 
	$user = $this->session->userdata('userbapekis');
?>
<div id="" class="container_broventh container_broventh_small">
    <div class="row">
        <div class="col-md-7">
            <div id="header_cal">
                <div class="row">
                    <div class="col-md-6">
                        <?php if($event->modul == "culture"){?>
                            <a href="<?=base_url()?>culture/program/<?=$event->ownership_id?>" style="font-size: 12px;"><span class="glyphicon glyphicon-menu-left"></span> CULTURE PROGRAM</a>
                        <?php }else{?>
                            <a href="<?=base_url()?>calendar" style="font-size: 12px;"><span class="glyphicon glyphicon-menu-left"></span> CALENDAR OF EVENT</a>
                        <?php }?>
                    </div>
                    <div class="col-md-6 right_text" style="font-size: 11px; padding-top: 5px;">
                        <?php if(($user['id'] == $event->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                            <a onclick="show_calendar_form(<?=$event->id?>,'<?=$event->modul?>',<?=$event->ownership_id?>);" class="edit_color">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a onclick="delete_event(<?=$event->id?>);">
                                <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                            </a>
                        <?php }?>
                    </div>
                </div>
                <div>
                    <div style="margin-top: 20px;">
                        <div class="hero-image" style="">
                            <div class="header_cal_img"></div>
                        </div>
                    </div>
                    <div style="margin-top: -42px; padding: 10px; z-index: 1001; position: relative;">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="page_title"><?=$event->title?></h2>
                                <h6 style="margin: 3px 0 10px 0;">
                                    <?=$event->category?>
                                    <?=($event->location) ? " ".dot_devider()." ".$event->location : "" ?>
                                    <?=dot_devider()." ".date("j M y",strtotime($event->start))?>
                                    <?=(date("Y-m-d",strtotime($event->start)) != date("Y-m-d",strtotime($event->end)) || !$event->end) ? " - ".date("j M y",strtotime($event->end)) : ""?>
                                </h6>
                                <div style="margin-top: 20px;">
                                    <?=$event->description?>
                                </div>
                            </div>
                            <div class="col-md-4 right_text" style="padding-top: 20px;">
                                <form action="<?php echo base_url().'calendar/submit_event_documentation/'.$event->id;?>" method ="post" id="form_documentation" role="form" enctype="multipart/form-data">
                                    <input type="file" onchange="upload_cal_documentation()" style="margin-right: 10px;">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="progress" class="progress"  style="display:none;">
                    <div id="bar" class="bar"></div>
                    <div id="percent" class="percent"></div >
                </div>
                <div id="message" class="message"></div>
                <div id="list_of_doc"><?=$list_of_documentation?></div>
            </div>
            <div style="margin-top: 40px;">
                <?php if($news){?>
                    <div class="row">
                        <?php foreach($news as $row){?>
                            <div class="col-md-4" id="news_content_<?=$row->id?>">
                                <div class="broventh_card">
                                    <div style="padding-right: 5px;">
                                        <?php if($row->full_url){?>
                                            <div style="margin: -10px -15px 10px -10px; ">
                                                <div style="width: 100%; height: 145px; overflow: hidden; padding: 0px;" id="<?=$row->id?>_banner_event_parent">
                                                    <img src="<?=base_url().$row->full_url?>" style="width: 100%;" id="<?=$row->id?>_banner_event">
                                                </div>
                                                <script type="text/javascript">
                                                    adjust_img_size('<?=$row->id?>_banner_event');
                                                </script>
                                            </div>
                                            <h5 style="height: 30px; overflow: hidden;" class="news_title"><a onclick="show_news_detail(<?=$row->id?>)"><?php long_text_real($row->title,55)?></a></h5>
                                            <div style="padding: 0px 0px; height: 20px;">
                                                <div class="third_font" style="font-size: 10px; margin:5px 0 5px 0;"><?=date("j M",strtotime($row->created))?>  · <?php long_text_real(get_user_nick_name($row),15)?></div>
                                            </div>
                                        <?php }else{?>
                                            <div style="margin-bottom: 15px; height: 125px; overflow: hidden;">
                                                <h3 class="news_title"><a onclick="show_news_detail(<?=$row->id?>)"><?php long_text_real($row->title,74)?></a></h3>
                                            </div>
                                            <div style="padding: 0px 0px; height: 60px;">
                                                <div class="third_font" style="font-size: 10px; margin:5px 0 5px 0;"><?=date("j M",strtotime($row->created))?>  · <?php long_text_real(get_user_nick_name($row),15)?></div>
                                                <p class="text_description" style="font-size: 12px"><?php long_text_real(strip_tags($row->description),62)?></p>
                                            </div>
                                        <?php }?>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="col-md-4 center_text" style="padding-top: 80px;">
                            <a onclick="show_input_form('','calendar news','<?=get_long_text($event->modul,100)?>','<?=$event->id?>');" class="btn btn-broventh btn-first btn-circle"><span class="glyphicon glyphicon-plus"></span></a>
                            <div>Event News</div>
                        </div>
                    </div>
                <?php }else{?>
                    <div class="center_text">
                        <a class="btn-broventh btn-first" onclick="show_input_form('','calendar news','<?=get_long_text($event->modul,100)?>','<?=$event->id?>');"><span class="glyphicon glyphicon-plus"></span> Event News</a>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="col-md-3" style="padding-left: 20px;">
            <div style="margin-top: 30px;">
                <?=$files_upload?>
            </div>
        </div>
    </div> 
    
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/calendar.js"></script>
<script type="text/javascript">
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