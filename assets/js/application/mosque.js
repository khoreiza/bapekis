function get_mosque_show_data(mosque_id){
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"Mosque/get_mosque_show_data",
        data: {mosque_id: mosque_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#mosque_show_content").html(resp.mosque_content);
                $("#loading_panel").hide();
            }else{}
        }
    });
}


function show_add_mosque_form(id){
   $("#loading_panel").show();
   $.ajax({
      type: "GET",
      url: config.base+"Mosque/add_mosque",
      data: {id: id},
      dataType: 'json',
      cache: false,
      success: function(resp){
         if(resp.status==1){
            show_popup_modal(resp.html);
         }else{}
         $("#loading_panel").hide();
      }
  });
}


function change_mosque_data(){
  var group_req = $("#group_req").val();
  var date = $("#meeting_date").val();
  $("#loading_panel").show();
  $.ajax({
      type: "GET",
      url: config.base+"Mosque/change_mosque_data",
      data: {group_req: group_req,date: date},
      dataType: 'json',
      cache: false,
      success: function(resp){
          if(resp.status==1){
              $("#list_of_mosque_index").html(resp.list_of_mosque);
              $("#loading_panel").hide();
          }else{}
      }
  });
}








function show_book_room_form(start,room_id,agenda_id,type){
  var date = $("#meeting_date").val();
  $.ajax({
      type: "GET",
      url: config.base+"meeting/add_booking",
      data: {start:start, room_id: room_id, date: date, agenda_id: agenda_id, type:type},
      dataType: 'json',
      cache: false,
      success: function(resp){
          if(resp.status==1){
              show_popup_modal(resp.html);
          }else{}
      }
  });
}

function show_agenda(agenda_id,type){
  $(".loading_panel").show();
  $.ajax({
      type: "GET",
      url: config.base+"meeting/show_agenda",
      data: {agenda_id: agenda_id, type:type},
      dataType: 'json',
      cache: false,
      success: function(resp){
          if(resp.status==1){
              show_popup_modal(resp.html);
              $(".loading_panel").hide();
          }else{}
      }
  });
}

function change_date_for_room(){
    var date = $("#meeting_date").val();
    var group_req = $("#group_req").val();
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"meeting/change_date",
        data: {date: date, group_req: group_req},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#list_of_rooms_index").html(resp.html);
                $("#date_info").html(resp.date_title);
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function delete_booking_agenda(id,type){
    var div = "";   
    $.confirm({
    title: 'Apa anda yakin?',
    content: '',
    confirmButton: 'Ya',
    confirm: function(){  
      $.ajax({
      type: "GET",
      url: config.base+"meeting/delete_booking",
      data: {id:id, type: type},
      dataType: 'json',
      cache: false,
      success: function(resp){
        console.log(resp);
        if(resp.status==true){
            if(type == "calendar"){div = "#agenda_";}
            else{div = "#request_"}
            $(div+id).animate({'opacity':'toggle'});
            change_date_for_room();
        }else{
          console.log('action after failed');
        }
      }
      });
    },
  });
}

function show_mom_form(meeting_id){
  $("#loading_panel").show();
  $.ajax({
      type: "GET",
      url: config.base+"meeting/input_mom",
      data: {meeting_id:meeting_id},
      dataType: 'json',
      cache: false,
      success: function(resp){
          console.log(resp);
          if(resp.status==1){
              $('#agenda_content_div').html(resp.html);
              $("#loading_panel").hide();
          }
      }
  });
}


function submit_mom(status){
  $("#status").val(status);
  if(status=='final'){
    $.confirm({
      title: 'Mom yang sudah final tidak bisa diubah kembali. Apa anda yakin?',
      content: '',
      confirmButton: 'Ya',
      confirm: function(){
          submit_mom_action();
      }
    });
  }else{
    submit_mom_action();
  }
}

function submit_mom_action(){
  $("#loading_panel").show();
  $("#form_mom").ajaxForm({ 
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
            console.log(resp);
            if(resp.status){
                window.location.href = resp.redirect_url;    
            }
        },
        error: function()
        {
            $("#message").html("<font color='red'> ERROR: unable to submit booking</font>");
            
        }
    }).submit();
}

function submit_attendance_presence(){
    $("#loading_panel").show();
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
                $("#loading_panel").hide();
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

$("#deadline").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'd M yy',
    dateFormat:"mm/dd/yy"
});

function submit_activity_parent(){
    $("#form_activity_parent").ajaxForm({ 
        dataType: 'json',
        success: function(resp) 
        {   
            var full_url = config.base + resp.url;
            notify_by_user('activity_step', 'Ada aktivitas bla bla bla', get_relative_url(full_url), resp.list_user);
            alert('Activity berhasil disimpan');
            refreshFilterPage();
            $('#popup_Modal').modal('hide');
        },
    }).submit();
}

function show_mom(id){
  $("#loading_panel").show();
  $.ajax({
      type: "POST",
      url: config.base+"meeting/show_mom",
      data: {id:id},
      dataType: 'json',
      cache: false,
      success: function(resp){
          if(resp.status==1){
              show_popup_modal(resp.html);
              $("#loading_panel").hide();
          }
      }
  });
}

//$("#form_activity_parent").validate();

function delete_facility(id){        
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
            $.ajax({
                type: "GET",
                url: config.base+"rkk/delete_rkk_facility",
                data: {id: id},
                dataType: 'json',
                cache: false,
                success: function(resp){
                    if(resp.status===true){
                        $('#facility_'+id).animate({'opacity':'toggle'});
                    }else{}
                }
            });
        },
    });
}

function delete_activity_step(id,element){
    if(id!=0){
      $.confirm({
          title: 'Apa anda yakin?',
          content: '',
          confirmButton: 'Ya',
          confirm: function(){
              $.ajax({
                  type: "POST",
                  url: config.base+"activity_step/deleteActivityStep",
                  data: {id: id},
                  cache: false,
                  success: function(){
                      console.log(id);
                      $('#sub_sub_activity_list_'+id).animate({'opacity':'toggle'});
                      $('#sub_sub_activity_list_'+id).remove();
                  }
              });
          },
      });
    }else{
      $.confirm({
          title: 'Apa anda yakin?',
          content: '',
          confirmButton: 'Ya',
          confirm: function(){
              var pel = $(element).parent().parent();
              console.log(pel);
              pel.animate({'opacity':'toggle'});
              pel.remove();
          },
      });
    }
}

function print_mom(id){
    console.log('printmom');
    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"meeting/print_mom",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status){
                $("#loading_panel").hide();
                window.location.assign(config.base+resp.url);
            }
        }
    });
}

function print_list_attendance(id){
    console.log('print_list_attendance');
    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"meeting/print_list_attendance",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status){
                $("#loading_panel").hide();
                window.location.assign(config.base+resp.url);
            }
        }
    });
}

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
    var group_req = $("#group_req").val();
    var room_id = "";

    if(status != "all_room"){
        var room_id = $("#request_room_id").val();
    }

    $.ajax({
        type: "GET",
        url: config.base+"meeting/search_availability_room",
        data: {start_date: start_date, end_date: end_date, start_time: start_time, end_time: end_time, room_id: room_id, agenda_id: agenda_id, group_req: group_req},
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

function add_sub_activity(){
    $("#sub_activity_list").prepend('<div class="form-group">'
                                    +'<div class="row">'
                                        +'<div class="col-sm-6">'
                                            +'<input type="text" class="form-control" id="activity_sub" name="activity_sub[]" placeholder="Activity">'
                                        +'</div>'
                                        +'<a class="pull-right" onclick="delete_activity_step(0,this)">'
                                            +'<span class="glyphicon glyphicon-trash delete_color"></span>'
                                        +'</a>'
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
                                        +'<input type="hidden" name="progress_sub_id[]">'
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

function add_custom_invitee(){
    $("#div_custom_invitee").prepend('<div class="form-group">'
                                    +'<div class="row">'
                                        +'<label class="col-sm-2 control-label input-md"></label>'
                                        +'<div class="col-sm-3">'
                                            +'<input type="text" class="form-control" id="custom_invitee" name="custom_invitee[]" placeholder="Name">'
                                        +'</div>'
                                        +'<div class="col-sm-3">'
                                            +'<input type="text" class="form-control" id="custom_invitee_unit" name="custom_invitee_unit[]" placeholder="Unit">'
                                        +'</div>'
                                        +'<div class="col-sm-3">'
                                            +'<input type="text" class="form-control" id="custom_invitee_phone" name="custom_invitee_phone[]" placeholder="Phone">'
                                        +'</div>'
                                        +'<a class="pull-right" onclick="delete_custom_invitee(0,this)">'
                                            +'<span class="glyphicon glyphicon-trash delete_color"></span>'
                                        +'</a>'
                                    +'</div>'
                                +"</div>");
    $('.selectpicker').selectpicker('refresh');
    $(".deadline_sub").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy',
        dateFormat:"mm/dd/yy"
    });
}
