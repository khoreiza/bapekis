function show_documentation_category_files(category_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"risk/show_documentation_category_files",
        data: {category_id: category_id},
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



function get_documentation_categories(){
    //var year = $('#year_filter').val();
    //var group = $("#group_filter").val();
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"risk/get_documentation_categories",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#documentation_category_div").html(resp.html);
            }else{}
            $(".loading_panel").hide();
        }
    });
}



function show_documentation_form(id,category_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"risk/input_documentation",
        data: {id: id, category_id: category_id},
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


function delete_risk_documentation(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"risk/delete_documentation",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    //get_scenario_data();
                    $('#div_documentation_file_'+id).remove();
                    get_documentation_categories();
                }
            }
          });
        },
    });
}








function delete_scenario_product(id, scenario_id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id, scenario_id: scenario_id},
            url: config.base+"pricing/delete_scenario_product",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    //$('#div_scenario_scene_'+id).remove();
                    get_scenario_product_data(scenario_id);
                }
            }
          });
        },
    });
}






function show_scenario_form(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"pricing/input_scenario",
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


function get_scenario_data(){
    //var year = $('#year_filter').val();
    //var group = $("#group_filter").val();
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"pricing/get_scenario_data",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#scenario_data_div").html(resp.html);
            }else{}
            $(".loading_panel").hide();
        }
    });
}




