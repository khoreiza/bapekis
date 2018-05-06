function show_kpi_form(id){
    var year = $('#year_filter').val();
    var group = $("#group_filter").val();

    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"kpi/input_kpi",
        data: {id: id, year: year, group: group},
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

function show_kpi_realization_form(kpi_id, id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"kpi/input_kpi_realization",
        data: {id: id, kpi_id},
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


function view_kpi(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"kpi/view_kpi",
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

function get_list_kpi(){
    var year = $('#year_filter').val();
    var group = $("#group_filter").val();

    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"kpi/get_list_kpi",
        data: {year: year, group: group},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#list_kpi_div").html(resp.html);
            }else{}
        }
    });
}

function delete_kpi_realization(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"kpi/delete_kpi_realization",
            dataType: 'html',
            cache: false,
            success: function(resp){
                if(resp.status){
                    $('#popup_Modal').modal('hide');
                    window.location.reload();
                }
            }
          });
        },
    });
}

function delete_kpi(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"kpi/delete_kpi",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status){
                    $('#div_realization_'+id).remove();
                }
            }
          });
        },
    });
}

