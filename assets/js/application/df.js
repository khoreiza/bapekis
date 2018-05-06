/************* DISTRIBUTOR FUNCTION ************/

function show_distributor_form(principal_id,distributor_id, form_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"df/input_distributor",
        data: {principal_id: principal_id, distributor_id: distributor_id, form_id: form_id},
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

function initiate_distributor_activity(distributor_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"df/initiate_activity",
        data: {distributor_id: distributor_id},
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

function get_distributor_data(id){

    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"df/get_distributor_data",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#distributor_performance_div").html(resp.html);
            }else{}
        }
    });
}

function delete_distributor_activity(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
            $.ajax({
                type: "POST",
                url: config.base+"df/delete_distributor_activity",
                data: {id: id},
                cache: false,
                success: function(){
                    location.reload();
                }
            });
        },
    });
    
}

/************* END OF DISTRIBUTOR FUNCTION ************/













/************* PRINCIPAL FUNCTION ************/

function show_principal_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"df/input_principal",
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

function get_principal_performance(id){
    var is_project = $("#is_project").val();
    var principal_customer = $("#principal_customer").val();
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"df/get_principal_performance",
        data: {id: id,is_project: is_project, principal_customer: principal_customer},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#principal_performance_div").html(resp.html);
            }else{}
        }
    });
}

/************* END OF PRINCIPAL FUNCTION ************/










/************* INDEX FUNCTION ************/

function get_summary_df(){
    /*var year = $('#year_filter').val();
    var group = $("#group_filter").val();*/
    var is_project = $("#is_project").val();
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"df/get_summary_df",
        data: {is_project: is_project},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#summary_df_div").html(resp.performance_div);
                $("#df_news_div").html(resp.news_view);
            }else{}
        }
    });
}

/************* END OF INDEX FUNCTION ************/







/************* GENERAL FUNCTION ************/

function change_principal_performance_info(div){
    $('.df_principal_detail_nav').removeClass('helper_text');
    $('.df_principal_detail_nav').addClass('helper_text');
    $('#'+div+'_nav').removeClass('helper_text');

    $(".df_principal_detail_div").hide();
    $("#"+div+"_div").show();
}

/************* END OF GENERAL FUNCTION ************/










