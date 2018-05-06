/**************** TUTORIAL FUNCTION ****************/
function show_tutorial_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"data/tutorial_form",
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
/**************** END TUTORIAL FUNCTION ****************/











/**************** PARSER FUNCTION ****************/
function show_parser_file_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"data/parser_file_form",
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
/**************** END PARSER FUNCTION ****************/









/**************** USER FUNCTION ****************/
function show_user_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"user/user_form",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#user_list_div").hide();
                $("#user_form_div").html(resp.html);
                if(id){
                    show_user_data_detail(id);
                }
            }else{}
        }
    });
}

function show_user_data_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"user/user_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#user_detail_div").html(resp.html);
            }else{}
        }
    });
}

function change_user_status(v_status, v_id){
    var url = config.base+"user/";
    if(v_status=="active"){
        url = url+"disable_user";
    }else if(v_status=="nonactive"){
        url = url+"enable_user";
    }
    $.getJSON(
        url,
        {
            id: v_id
        },
        function(data, status, xhr){
            if(status=="success"){
                if(data.value==1){
                    $("#status_account_"+v_id).removeClass('active');
                    $("#btn_status_account_"+v_id).removeClass('active');
                    

                    if(v_status=="active"){
                        //$("#btn_active_user").replaceWith( "<button id='btn_active_user' class='btn btn-primary btn-xs' onclick=change_user_status('nonactive',"+v_id+")>Enable</button>" );
                        $("#status_account_"+v_id).html('Nonactive');
                        $("#btn_status_account_"+v_id).removeClass('btn-fourth');
                        $("#btn_status_account_"+v_id).addClass('btn-fifth');
                        $("#btn_status_account_"+v_id).html('Enable');
                        $("#btn_status_account_"+v_id).attr("onclick","change_user_status('nonactive',"+v_id+")");

                    }else if(v_status=="nonactive"){
                        $("#status_account_"+v_id).addClass('active');
                        $("#status_account_"+v_id).html('Active');
                        $("#btn_status_account_"+v_id).removeClass('btn-fifth');
                        $("#btn_status_account_"+v_id).addClass('btn-fourth');
                        $("#btn_status_account_"+v_id).html('Disable');
                        $("#btn_status_account_"+v_id).attr("onclick","change_user_status('active',"+v_id+")");
                        //$("#btn_active_user").replaceWith( "<button id='btn_active_user' class='btn btn-warning btn-xs' onclick=change_user_status('active',"+v_id+")>Disable</button>" );
                    }
                }
            }else{
                $(v_id_div).html("error");
            }
        }
    );
}

function reset_password(v_username){
    bootbox.confirm("Apa anda yakin?", function(confirmed) {
        if(confirmed===true){
            $.getJSON(
                config.base+"user/reset_password",
                {
                    username: v_username
                },
                function(data, status, xhr){
                    if(status=="success"){
                        if(data.value==true){
                            alert('Password has been reset. Password is equal with Username.');
                        }
                    }
                }
            );
        }
    });

}

function delete_user(v_id){
    bootbox.confirm("Apa anda yakin?", function(confirmed) {
        if(confirmed===true){
            $.getJSON(
                config.base+"user/delete_user",
                {
                    id: v_id
                },
                function(data, status, xhr){
                    if(status=="success"){
                        if(data.value==true){
                            $('#usersu_'+v_id).animate({'opacity':'toggle'});
                            succeedMessage('User berhasil dihapus');
                        }
                    }else{
                        $('#usersu_'+v_id).html("error");
                    }
                }
            );
        }
    });
}