function input_activity_parent(id, source_type){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"activity_step/input_parent",
        data: {id: id, source_type: source_type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function add_sub_activity(){
    $("#sub_activity_list").prepend('<div class="form-group">'
                                    +'<div class="row">'
                                        +'<div class="col-sm-6">'
                                            +'<input type="text" class="form-control" id="activity_sub" name="activity_sub[]" placeholder="Activity">'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="row" style="margin-top:10px;">'
                                        +'<div class="col-sm-3">'
                                            +'<select class="selectpicker" id="user_pic_sub" name="user_pic_sub[]" data-live-search="true" data-dropup-auto="false" data-width="100%">'
                                                +'<?php if($pic){foreach($pic as $k=>$v){?>'
                                                        +'<option <?=($user["id"] == $v["id"] ? "selected" : "")?> value="<?php echo $v["id"]?>"><?php echo $v["full_name"]?></option>'
                                                +'<?php }}?>'
                                            +'</select>'
                                        +'</div>'
                                        +'<div class="col-sm-2" style="">'
                                            +'<input type="text" class="form-control deadline_sub" id="deadline_sub" name="deadline_sub[]" placeholder="Deadline">'
                                        +'</div>'
                                        +'<div class="col-sm-2">'
                                            +'<select class="selectpicker form-control" name="status_sub[]" data-width="100%">'
                                                +'<option value="Not Started">-- Status --</option>'
                                                +'<option value="Not Started">Not Started</option>'
                                                +'<option value="On Progress">On Progress</option>'
                                                +'<option value="Delay">Delay</option>'
                                                +'<option value="Done">Done</option>'
                                            +'</select>'
                                        +'</div>'
                                        +'<div class="col-sm-5">'
                                            +'<input type="text" class="form-control" id="tenor" name="progress_sub[]" placeholder="Progress">'
                                        +'</div>'
                                        +'<input type="hidden" name="sub_activity_id[]">'
                                    +'</div>'
                                +"</div><hr>");
    $('.selectpicker').selectpicker('refresh');
    $(".deadline_sub").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy',
        dateFormat:"mm/dd/yy"
    });
}