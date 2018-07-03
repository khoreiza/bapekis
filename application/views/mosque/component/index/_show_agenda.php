<style type="text/css">
    .agenda_info .glyphicon{padding-right: 5px; color:<?=array_color_new(2)?>; font-size: 12px;}
</style>

<?php $user = $this->session->userdata('userbapekis');?>


<div style="padding: 0 15px 0 15px;">
    <div>
        <h3 class="news_title center_text"><?=$agenda->title?></h3>
    </div>
    <div>    
        <?php if($agenda->description)?> <div style="margin: 5px 0 10px 0;"><?=$agenda->description?></div>
        <div style="margin-top: 5px;" class="agenda_info">
            <div><span class="glyphicon glyphicon-calendar"></span> <?=date("j M y", strtotime($agenda->start))?></div>
            <div><span class="glyphicon glyphicon-time"></span> <?=date("H:i", strtotime($agenda->start))?> - <?=date("H:i", strtotime($agenda->end))?></div>
            <div><span class="glyphicon glyphicon-home"></span> <?=$agenda->name?></div>
        </div>
        <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR") || in_array($user['id'],$list_allowed_user)){ ?>
            <div style="margin-top: 10px;" class="right_text">
                <a href="<?=base_url().'meeting/agenda/'.$agenda_id?>">
                    See Detail
                    <span class="glyphicon glyphicon-log-in" style="margin-left: 3px;"></span>
                </a>
            </div>
        <?php } ?>
    </div>
    <?php
        if($agenda->need_request){
        $approver = explode(";", $agenda->need_request);
        if(in_array($user['id'], $approver) && (isset($agenda->status) && $agenda->status == "Pending")){?>
            <hr>
            <h4 class="helper_text">Meeting Room Request</h4>
            <div class="row" style="margin-top: 20px;">
                <div class="col-xs-6 right_text">
                    <a onclick="proceed_request(<?=$agenda->agenda_id?>,'Approved')" class="btn btn-broventh btn-second "><span class="glyphicon glyphicon-ok-circle"></span> Approve</a>
                </div>
                <div class="col-xs-6">
                    <a onclick="proceed_request(<?=$agenda->agenda_id?>,'Rejected')" class="btn btn-broventh btn-fourth"><span class="glyphicon glyphicon-remove-circle"></span> Reject</a>
                </div>
            </div>
    <?php }}?>
</div>

<script>
    $(document).ready(function () {
        <?php if(!isset($agenda)){?>
            <?php if(isset($room_id) && $room_id){?>
                pick_room(<?=$room_id?>,'<?=$room_name?>');
            <?php }else{?>
            search_availability_room();
            <?php }?>
        <?php }?>
        
    });

    function pick_room(id,name){
        $("#room_id").val(id);
        $("#room_name").html(name);
        $("#list_room").html('');
        $("#booking_form").show();
    }
    
    function search_availability_room(status){
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var start_time = $("#start_time").val();
        var end_time = $("#end_time").val();
        var agenda_id = $("#agenda_id").val();
        if(status != "all_room"){
            var room_id = $("#request_room_id").val();
        }

        $.ajax({
            type: "GET",
            url: config.base+"meeting/search_availability_room",
            data: {start_date: start_date, end_date: end_date, start_time: start_time, end_time: end_time, room_id: room_id, agenda_id: agenda_id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              if(resp.status==1){
                  $("#list_room").html(resp.html);
                  $("#booking_form").hide();
              }else{}
            }
        });
    }

    function submit_booking(){
        $("#form_booking").ajaxForm({ 
            dataType: 'json',
            beforeSerialize: function(form, options) { 
                    for (instance in CKEDITOR.instances)
                    CKEDITOR.instances[instance].updateElement();
            },
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
                $('#popup_Modal').modal('hide');
                change_date_for_room();
            },
            error: function()
            {
                $("#message").html("<font color='red'> ERROR: unable to submit booking</font>");
                
            }
        }).submit();
    }
    
    $('#start_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy'
    });
    $('#end_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy'
    });

    $('#start_time').timepicker({
        template: false,
        showInputs: false,
        minuteStep: 30,
        showMeridian: false,
    });

    $('#end_time').timepicker({
        template: false,
        showInputs: false,
        minuteStep: 30,
        showMeridian: false,
    });
</script>