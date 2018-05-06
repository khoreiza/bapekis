function get_dashboard(page){
    $(".loading_panel").show();
    var type = ""; var prev_type = "";
    if(page){
        type = page;
    }else{
        type = $('#type_dashboard').val();
    }
    
    var lurl = '';
    var date = '';
    if(type=='realization'){
        prev_type = 'target_setting';
        lurl = 'get_dashboard_realization';
        date = $("#dashboard_date_filter").val();
    }else if(type=='target_setting'){
        prev_type = 'realization';
        lurl = 'get_dashboard_target_setting';
        date = $("#target_setting_date").val();
    }
    var custgroup_name = $("#cusgroup_name").val();
    var segment_filter = $("#segment_filter").val();
    var anchor_filter = $("#anchor_filter").val();
    var gam = $("#gam_filter").val();
    var tiering = $("#tiering_filter").val();

    $.ajax({
        type: "GET",
        url: config.base+"account_planning/"+lurl,
        data: {custgroup_name: custgroup_name, segment_filter: segment_filter, date: date, anchor_filter: anchor_filter, gam_filter: gam, tiering_filter: tiering},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#dashboard_display_div").html(resp.content);
                $("#a_"+type).removeClass('btn-tosca').addClass('btn-gray btn-full');
                $("#a_"+prev_type).removeClass('btn-gray btn-full').addClass('btn-tosca');
                $("#type_dashboard").val(type);
                change_filter_date(type);
            }else{}
        }
    });
}

function change_filter_date(type){
    if(type=='realization'){
        $('#dashboard_date_div').show();
        $('#target_setting_date_div').hide();
    }else if(type=='target_setting'){
        $('#target_setting_date_div').show();
        $('#dashboard_date_div').hide();
    }
}
function change_summary_page_content(sub_menu){
    $(".loading_panel").show();
    $(".nav_ap").removeClass('third_font');
    if(!sub_menu){
        sub_menu = $("#content_page_flag").val();
    }

    var gam_filter = $("#gam_filter").val();
    var tiering_filter = $("#tiering_filter").val();
    var anchor_filter = $("#anchor_filter").val();
    var segment_filter = $("#segment_filter").val();
    var date = '';
    if(sub_menu == "dashboard") date = $("#dashboard_date_filter").val();

    //var segment_filter = $("#segment_filter").val();
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/s"+sub_menu,
        data: {custgroup_name: '', date: date, segment_filter: segment_filter, gam_filter: gam_filter, tiering_filter: tiering_filter, anchor_filter: anchor_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $('.ap_page_nav').removeClass('third_font');
                $('#'+sub_menu+'_nav').addClass('third_font');
                
                $(".dashboard_date_div").hide();
                $("#segment_filter_div").show();

                $("#content_page_flag").val(sub_menu);
                $("#summary_content_box").html(resp.content);
                $('.column').theiaStickySidebar({additionalMarginTop: 76});

                if(sub_menu == "index"){
                    $("#filter_anchor_search_div").show();
                    $("#segment_filter_div").hide();
                    $("#filter_anchor_select_div").hide();
                    filter_anchor_list();
                }else if(sub_menu == 'activity'){
                    change_anchor();
                    $("#filter_anchor_search_div").hide();
                    $("#filter_anchor_select_div").show();
                    filter_data_activity();
                }else if(sub_menu == "dashboard"){
                    change_anchor();
                    $("#filter_anchor_search_div").hide();
                    $("#filter_anchor_select_div").show();
                    $(".dashboard_date_div").show();
                    get_dashboard();
                }
            }else{}
        }
    });
}

function filter_anchor_list(){
    var gam = $("#gam_filter").val();
    var tiering = $("#tiering_filter").val();
    var search = $("#search_filter").val();
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/filter_anchor",
        data: {gam: gam, tiering: tiering, search: search},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#list_anchor_div").html(resp.list_anchor_page);
                $("#summary_information_div").html(resp.summary_information_page);
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function change_anchor(){
    var gam = $("#gam_filter").val();
    var tiering = $("#tiering_filter").val();
    var anchor_filter = $("#anchor_filter").val();
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/get_anchor_by",
        data: {gam: gam, tiering: tiering, anchor_filter: anchor_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#filter_anchor_select_div").html(resp.page);
                $('.selectpicker').selectpicker('refresh');
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function filter_data_activity(){
    console.log('filter data');
    //var customer_group = "<?=$customer_group?>";
    var customer_group = $("#cusgroup_name").val();
    var anchor_filter = $("#anchor_filter").val();
    var gam = $("#gam_filter").val();
    var tiering = $("#tiering_filter").val();
    var segment_filter = $("#segment_filter").val(); console.log(segment_filter);
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/filter_data_activity",
        data: {customer_group: customer_group, anchor_filter: anchor_filter, gam: gam, tiering: tiering, segment_filter: segment_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#loading_panel").hide();
                $("#content_anchor_activity").html(resp.content);
                $('.table_activity_anchor').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'pageLength',
                    ]
                });
                filter_list_activity('', '');
            }else{}
        }
    });
}

function filter_list_activity(status, segment){
    $("#loading_panel").show();
    var customer_group = $("#cusgroup_name").val();
    var anchor_filter = $("#anchor_filter").val();
    var gam = $("#gam_filter").val();
    var tiering = $("#tiering_filter").val();
    var segment = $("#segment_filter").val();
    
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/filter_list_activity",
        data: {customer_group: customer_group, status: status, segment: segment, anchor_filter: anchor_filter, gam: gam, tiering: tiering},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#loading_panel").hide();
                $("#table_list_activity").html(resp.content);
            }else{}
        }
    });
}


function change_ap_page_content(sub_menu){
    var id = $('#id_anchor').val();
    $(".loading_panel").show();
    $(".nav_ap").removeClass('third_font');
    if(!sub_menu){
        sub_menu = $("#content_page_flag").val();
    }
    
    if(sub_menu != "dashboard"){
        $("#dashboard_date_div").hide();
        $("#target_setting_date_div").hide();
    }

    var custgroup_name = $("#cusgroup_name").val();
    var segment_filter = $("#segment_filter").val();
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/"+sub_menu,
        data: {id: id, custgroup_name: custgroup_name, segment_filter: segment_filter},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#"+sub_menu+"_nav").addClass('third_font');
                $("#content_page_flag").val(sub_menu);
                $("#ap_page_content").html(resp.content);
                $('.column').theiaStickySidebar({additionalMarginTop: 106});
                //change_ap_page_content(sub_menu);
            }else{}
        }
    });
}

