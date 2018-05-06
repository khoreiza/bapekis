function get_scenario_scene_data(scenario_id){
    //var year = $('#year_filter').val();
    //var group = $("#group_filter").val();
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"projection/get_scenario_scene_data",
        data: {scenario_id: scenario_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#scenario_product_data_div").html(resp.html);
            }else{}
            $(".loading_panel").hide();
        }
    });
}



function show_scenario_scene_form(id,scenario_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"projection/input_scenario_scene",
        data: {id: id, scenario_id: scenario_id},
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


function delete_scenario_scene(id, scenario_id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id, scenario_id: scenario_id},
            url: config.base+"projection/delete_scenario_scene",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    $('#div_scenario_scene_'+id).remove();
                    get_scenario_scene_data(scenario_id);
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
        url: config.base+"projection/input_scenario",
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
        url: config.base+"projection/get_scenario_data",
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


function delete_scenario(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"projection/delete_scenario",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    get_scenario_data();
                }
            }
          });
        },
    });
}



