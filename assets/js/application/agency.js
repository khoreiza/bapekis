function show_borrowed_form(id, form_id, document_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"agency/borrow_document",
        data: {id: id, form_id: form_id, document_id: document_id},
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


function show_document_form(id, form_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"agency/input_document",
        data: {id: id, form_id: form_id},
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

function get_document_data(){
    //var year = $('#year_filter').val();
    //var group = $("#group_filter").val();
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"agency/get_document_data",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#document_data_div").html(resp.html);
            }else{}
            $(".loading_panel").hide();
        }
    });
}

function show_document_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"agency/show_document",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
            $(".loading_panel").hide();
        }
    });
}

function show_instruction_form(id, form_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"agency/input_instruction",
        data: {id: id, form_id: form_id},
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

