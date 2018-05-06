function get_mail_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"mail/detail_popup",
        data: {id: id},
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



function show_mail_form(id, form_id, kind){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"mail/input_mail",
        data: {id: id, form_id: form_id, kind: kind},
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

function get_mail_data(kind){
    //var year = $('#year_filter').val();
    //var group = $("#group_filter").val();
    if(kind == ""){
       var kind = "outgoing";
    }
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"mail/get_mail_data",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#mail_data_div").html(resp.html);
                change_div_component_info(kind+'_mail', 'mail_index');
            }else{}
            $(".loading_panel").hide();
        }
    });
}


function change_mail_type(){
        
    var type = $("#type").val();
    
    /***** FORM DESTINATION ******/
    if(type == "PKS" || type == "Nota Analisa" || type == "BAST" || type == "SPPK"){
        $("#form_destination").hide();
    }else{
        $("#form_destination").show();
    }


    /***** FORM CUSTOMER *****/
    if(type == "Nota Analisa" || type == "BAST" || type == "SPPK"){
        $("#form_customer").show();
    }else{
        $("#form_customer").hide();
    }
}




function delete_mail(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"mail/delete_mail",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    $('#div_mail_'+id).remove();
                }
            }
          });
        },
    });
}


function show_disposition_form(id, mail_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"mail/input_disposition",
        data: {id: id, mail_id: mail_id},
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


function delete_disposition(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"mail/delete_disposition",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    $('#div_disposition_'+id).remove();
                }
            }
          });
        },
    });
}