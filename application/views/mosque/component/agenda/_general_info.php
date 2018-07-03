<?php $user = $this->session->userdata('userbapekis'); ?>

<div>
    <div class="broventh_submenu_div" style="margin-top: 0px;">
        <div class="broventh_submenu_title no_border">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-briefcase"></span></a>
                    Meeting Information
                </div>
            </div>
        </div>
        <div class="broventh_submenu_body">
            <div class="broventh_card">
                <div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-user"></span></div>
                        <div class="col-xs-10"><?=$agenda->full_name?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-home"></span></div>
                        <div class="col-xs-10"><?=$agenda->name?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-calendar"></span></div>
                        <div class="col-xs-10"><?=date("j M y",strtotime($agenda->start))?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1"><span class="glyphicon glyphicon-time"></span></div>
                        <div class="col-xs-10"><?=date("H:i",strtotime($agenda->start))." - ".date("H:i",strtotime($agenda->end))?></div>
                    </div>
                </div><hr>
                <div>
                    <h6 class="news_title">Meeting Attachment</h6>
                    <div>
                        <?php if($attachments){?>
                        <div style="margin-top:10px; max-width:100%">
                            <?php foreach($attachments as $file){?>
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
    <div class="broventh_submenu_div" style="margin-top: 10px;">
        <div class="broventh_submenu_title no_border">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-user"></span></a>
                    Meeting Attendance
                </div>
            </div>
        </div>
        <form class="form-horizontal form-borventh" action="<?=base_url()?>meeting/store_attendance_presence" method ="post" id="form_attendance" role="form" enctype="multipart/form-data">
            <input type="hidden" name="meeting_id" value="<?=$agenda->id?>" id="meeting_id">
            <div class="broventh_submenu_body">
                <div class="broventh_card">
                    <table class="table table-striped">
                        <thead><th colspan="3" style="text-align: left">Attendance</th><th>Hadir</th><th>Tidak</th></thead>
                        <tbody>
                            <?php if($attendances){ foreach($attendances as $k => $atd){ $no = $k+1; ?>
                                <tr>
                                    <td><?=$no?></td>
                                    <td>
                                        <div class="photo_frame_circle" style="height: 20px; width:20px;">
                                            <?=employee_photo($atd)?>
                                        </div>
                                    </td>
                                    <td><a onclick="show_user_detail(<?=$atd->user_id?>)"><?=$atd->full_name?></a></td>
                                    <!-- 0 = belum, 1 = tidak hadir, 2 = hadir -->
                                    <td class="center_text"><input type="radio" name="attendance_<?=$atd->meeting_attendance_id?>" value="2" <?= (isset($atd) && $atd->is_present==2) ? 'checked' : '' ?> ></td>
                                    <td class="center_text"><input type="radio" name="attendance_<?=$atd->meeting_attendance_id?>" value="1" <?= (isset($atd) && $atd->is_present==1) ? 'checked' : '' ?> ></td>
                                </tr>
                            <?php } } ?>
                            <?php if($custom_invitees) { foreach($custom_invitees as $k => $atd){ $no=$no+1; ?>
                                <tr>
                                    <td><?=$no?></td>
                                    <td>
                                        <div class="photo_frame_circle" style="height: 20px; width:20px;">
                                        </div>
                                    </td>
                                    <td><?=$atd->custom_invitee?></td>
                                    <!-- 0 = belum, 1 = tidak hadir, 2 = hadir -->
                                    <td class="center_text"><input type="radio" name="attendance_<?=$atd->meeting_attendance_id?>" value="2" <?= (isset($atd) && $atd->is_present==2) ? 'checked' : '' ?> ></td>
                                    <td class="center_text"><input type="radio" name="attendance_<?=$atd->meeting_attendance_id?>" value="1" <?= (isset($atd) && $atd->is_present==1) ? 'checked' : '' ?> ></td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 20px;" class="right_text">
                    <a class="btn btn-first btn-broventh" onclick="submit_attendance_presence()"><span class="glyphicon glyphicon-save"></span> Save</a>
                    <a onclick="print_list_attendance(<?=$agenda->id?>)" class="btn btn-third btn-broventh" style="margin-left:10px;"><span class="glyphicon glyphicon-print"></span> Print</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    function submit_attendance_presence(){
        $("#form_attendance").ajaxForm({ 
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
                if(resp.status==1){
                    alert('Data presensi sudah berhasil disimpan');    
                }
            },
            error: function()
            {
                $("#message").html("<font color='red'> ERROR: unable to submit presence</font>");
                
            }
        }).submit();
    }

</script>