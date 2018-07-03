<?php $user = $this->session->userdata('userbapekis'); ?>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:100%; max-width:800px;">
        <div class="modal-content">
    	   <div class="modal-body">
               <div>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
			 <div>
                <div class="form-signin" style="padding: 0 20px 0 20px;">	      
                    <div class="row" style=" margin-bottom:40px; padding-bottom: 5px; border-bottom: 1px solid #c3c3c3">
                        <div class="col-sm-2" style="height: 40px; overflow: hidden;">
                            <img class="right_text" style="height: 80px;" src="<?=base_url()?>assets/img/general/brobot-owl.png">
                        </div>
                        <div class="col-sm-10 right_text" style="margin-top: 15px;">
                            <h3>Booking Meeting Room</h3>
                        </div>
                    </div>
                    <input type="hidden" id="request_room_id" value="<?=$room_id?>">
                    <?php if(isset($agenda)){?><input type="hidden" id="agenda_id" value="<?=$agenda->agenda_id?>"><?php }?>
                    <form class="form-horizontal" id="form_booking"
                          action="<?php if(isset($agenda)){
                        echo base_url()."meeting/store_booking/".$agenda->agenda_id;}
                    else{
                        echo base_url()."meeting/store_booking";}?>" 
                          method ="post" id="form_input_room" role="form" enctype="multipart/form-data">
                        <input type="hidden" id="meeting_type" name="meeting_type" value="<?php if(empty($room->need_request)){echo 'calendar';}else{echo 'meeting_request';} ?>">
                        <input type="hidden" id="type" name="type" value="<?=$type?>">
                        <div style="margin-bottom: 20px;">
                            <?php if(empty($room->need_request) || empty($agenda_id)){ ?>
                            <h5>Pick your Meeting Date and Time</h5>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-1 control-label"><span class="glyphicon glyphicon-calendar"></div>
                                <div class="col-sm-3">
                                    <?php $date=""; if(isset($agenda) && $agenda->start){$date = date("j M y", strtotime($agenda->start));}elseif(isset($start_date) && $start_date){$date = date("j M y", strtotime($start_date));}else{$date = date("j M y", strtotime(date("Y-m-d")));}
                                    ?>
                                    <input type="text" onchange="search_availability_room()" class="form-control" id="start_date" name="start_date" placeholder="Start Date" value="<?php echo $date?>">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date" value="">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-1 control-label"><span class="glyphicon glyphicon-time"></div>
                                <div class="col-sm-2">
                                    <input type="text" oninput="search_availability_room()" class="form-control" id="start_time" name="start_time" placeholder="" value="<?php if(isset($agenda)){echo date("H:i", strtotime($agenda->start));}elseif(isset($start_time) && $start_time){echo $start_time.":00";}else{echo "8:00";}?>">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" oninput="search_availability_room()" class="form-control" id="end_time" name="end_time" placeholder="" value="<?php if(isset($agenda)){echo date("H:i", strtotime($agenda->end));}elseif(isset($start_time) && $start_time){echo ($start_time+1).":00";}else{echo "17:00";?> <?php }?>">
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-brobot btn-gray btn-md" onclick="search_availability_room('all_room')">Search Room</a>
                                </div>
                            </div>
                            <?php } ?>

                            <div id="list_room">

                            </div>

                            <div id="booking_form" <?php if(!isset($agenda)){?>style="display: none;"<?php }?>>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Room</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" id="room_id" name="room_id" value="<?php if(isset($agenda)) echo $agenda->meeting_room_id?>">
                                        <label class="control-label" id="room_name"><?php if(isset($agenda)) echo $agenda->name?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Agenda</label>
                                    <div class="col-sm-9">
                                        <input  <?php if(!empty($room->need_request) && !empty($agenda_id)){ echo "readonly"; }?>  type="text" class="form-control" id="agenda" name="agenda" placeholder="" value="<?php if(isset($agenda)) echo $agenda->title?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Notes</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder="" ><?php if(isset($agenda)) echo $agenda->description?></textarea>
                                    </div>
                                </div>
                                
                            </div><hr/>
                            
                        <?php if(!empty($agenda_id) || empty($room->need_request)){ ?>
                            <div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label input-md">Invitees</label>
                                    <div class="col-sm-5">
                                        <select class="selectpicker show-tick with-ajax" multiple data-selected-text-format="count" id="invitees" name="invitees[]" data-width="100%" data-live-search="true" data-dropup-auto="false">
                                            <?php if(isset($agenda_invitees) && $agenda_invitees){foreach($agenda_invitees as $ivt){?>
                                                <option value="<?=$ivt->user?>" selected><?=$ivt->full_name?></option>
                                            <?php }}?>
                                        </select>
                                        <script type="text/javascript">fill_user_options('invitees');</script>
                                    </div>
                                    <div class="pull-right">
                                        <a onclick="add_custom_invitee()" class="btn btn-brobot btn-gray btn-sm">+ CUSTOM INVITEE</a>
                                    </div>
                                </div>
                                <div id="div_custom_invitee">
                                        <?php if(isset($custom_invitees) && $custom_invitees){ foreach($custom_invitees as $ci){ ?>
                                            <div id="sub_div_custom_invitee_<?=$ci->meeting_attendance_id?>" class="form-group">
                                                <div class="row">
                                                    <label class="col-sm-2 control-label input-md"></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="custom_invitee" name="custom_invitee[]" placeholder="Name" value="<?=$ci->custom_invitee?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="custom_invitee_unit" name="custom_invitee_unit[]" placeholder="Unit" value="<?=$ci->custom_invitee_unit?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="custom_invitee_phone" name="custom_invitee_phone[]" placeholder="Phone" value="<?=$ci->custom_invitee_phone?>">
                                                    </div>
                                                    <a class="pull-right" onclick="delete_custom_invitee(<?=$ci->meeting_attendance_id?>)">
                                                        <span class="glyphicon glyphicon-trash delete_color"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } } ?>
                                </div>
                            </div><hr/>
                            <div>
                                <div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label input-md">Attachment</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="attachment[]" id="attachment" multiple class="btn btn-default">
                                            <?php if(isset($attachment)){?>
                                            <div style="margin-top:20px; max-width:80%">
                                                <?php foreach($attachment as $file){?>
                                                    <div class="file_<?php echo $file->id?>">
                                                        <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                                            <span><img style="height:18px" src="<?=get_ext_office($file->ext)?>"></span>
                                                            <a href="<?php echo base_url()?><?php echo $file->full_url;?>"><?= $file->title?></a>
                                                        </div>
                                                        <div style="float:right; padding-right:10px;">
                                                            <?php if(($user['id'] == $file->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                                                <a onclick="delete_files_upload(<?php echo $file->id?>,'file_form')">
                                                                    <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                                                </a>
                                                            <?php }?>
                                                        </div><div style="clear:both"></div>
                                                    </div>
                                                <?php }?>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                            <div>
                                <button style="margin-top: 20px;" class="btn btn-brobot btn-tosca btn-lg" type="button" onclick="submit_booking()">BOOK ROOM</button>
                            </div>
                        </div>
                    </form>
                </div>
			</div>
		  </div>
	   </div>
    </div>
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
        $('input[type=file]').bootstrapFileInput();
    });
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