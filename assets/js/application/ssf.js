function filter_project_list(){
    var search = $("#search_filter").val();
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"ssf/filter_project",
        data: {search: search},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#list_project_div").html(resp.project_list_view);
                //$("#summary_information_div").html(resp.summary_information_page);
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function delete_project(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"ssf/delete_project",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#project_div_'+id).animate({'opacity':'toggle'});
                filter_project_list();
                //$('#participant_view').html(resp.html);
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function show_project_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"ssf/input_project",
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

function show_participant_form(id, project_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"ssf/add_participant",
        data: {id: id, project_id: project_id},
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

function delete_participant(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"ssf/delete_participant",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#participant_view').html(resp.html);
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function show_team_matrix_form(id, project_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"ssf/add_team_matrix",
        data: {id: id, project_id: project_id},
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

function delete_team_matrix(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"ssf/delete_team_matrix",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#team_matrix_div_'+id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function get_ssf_analysis(){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base + "ssf/get_ssf_analysis",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();

            if(resp.status) {
                $("#ssf_display_div").html(resp.html);
                change_broventh_active_page_button('btn-ssf-menu', "btn-menu-analysis");
                //change_legel_menu("summary");
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function get_ssf_institutions(){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base + "ssf/get_ssf_institutions",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();

            if(resp.status) {
                $("#ssf_display_div").html(resp.html);
                //change_broventh_active_page_button('btn-ssf-menu', "btn-menu-analysis");
                //change_legel_menu("summary");
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}


function show_institution_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"ssf/input_institution",
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

function delete_institution(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"ssf/delete_institution",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                console.log(resp);
                if(resp.status==1){
                    $('#institutions_div_'+id).animate({'opacity':'toggle'});
                }else{
                    console.log('action after failed');
                }
            }
          });
        },
    });
}


function change_fbi_graph(type){
    change_broventh_active_page_button('fbi_graph_btn', "fbi_graph_btn_"+type);
    $(".fbi_graph").hide();
    $("#fbi_graph_"+type).show();

}

function show_list_project(user_id){
    $(".loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"ssf/get_list_project",
        data: {user_id: user_id},
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


function show_institution(institution_id){
    $(".loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"ssf/get_institution",
        data: {institution_id: institution_id},
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
