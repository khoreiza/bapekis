function show_request_form(id, type){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"gs/input_request",
        data: {id: id, type: type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
                change_form_group_part(2);
            }else{}
        }
    });
}

function get_gs_request(){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"gs/get_request",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#list_request_div").html(resp.html);
            }else{}
        }
    });
}

function change_form(){
    var type = $('#category').val();
    var request_id = $("#request_id").val();
    //console.log(request_id);
    if(type.toLowerCase().indexOf('atk')!==-1){
        // found
        show_item_form();
        if(request_id){
            console.log('cuy');
            show_submodul_form('atk');
        }
    }else if(type.toLowerCase().indexOf('hardware')!==-1){
        // found
        show_item_form();
        if(request_id){
            show_submodul_form('hardware');
        }
    }else{
        // found
        show_submodul_form(type);
    }
}

function show_item_form(){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"gs/show_item_form",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $("#gs_extended_form").html(resp.html);
            }else{}
        }
    });

    /*$("#gs_extended_form").html('<div style="margin-bottom: 30px;" class="helper_text">'
                                    +'<div class="pull-right">'
                                        +'<a onclick="show_submodul_form('+"'atk'"+',0)" class="btn btn-brobot btn-gray btn-sm">+ ITEM</a>'
                                    +'</div>'
                                    +'<h4>Item</h4>'
                                +'</div><div id="gs_item_form"></div>');*/
}

function show_submodul_form(form_type, is_req_id) {
    $(".loading_panel").show();
    if(is_req_id!==0){
        var request_id = $("#request_id").val();
    }
    if(form_type.toLowerCase().indexOf('others')==-1){
        $.ajax({
            type: "GET",
            url: config.base + "gs/show_submodul_form",
            data: {form_type: form_type, request_id: request_id},
            cache: false,
            success: function(resp) {
                $(".loading_panel").hide();
                if(resp.status==1) {
                    if(form_type.toLowerCase().indexOf('atk')!==-1){
                        $('#gs_item_form').append(resp.html);
                        //$('.desc').summernote();
                    }else if(form_type.toLowerCase().indexOf('hardware')!==-1){
                        $('#gs_item_form').append(resp.html);
                        //$('.desc').summernote();
                    }else if(form_type.toLowerCase().indexOf('muka')!==-1){
                        $("#gs_extended_form").html(resp.html);
                    }else if(form_type.toLowerCase().indexOf('perdin')!==-1){
                        $("#gs_extended_form").html(resp.html);
                        fill_customer_options('customer');
                    }else if(form_type.toLowerCase().indexOf('project')!==-1){
                        $("#gs_extended_form").html(resp.html);
                    }
                    $('.selectpicker').selectpicker('refresh');
                }
                $(".date").datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'd M yy',
                    dateFormat:"mm/dd/yy"
                });
            },
            error: function() {
                $(".loading_panel").hide();
            }
        });
    }else{
        $(".loading_panel").hide();
        $("#gs_extended_form").html('');
    }
}

function delete_item(id,e){
    if(id===null){
        $.confirm({
            title: 'Apa anda yakin?',
            content: '',
            confirmButton: 'Ya',
            confirm: function(){
                $(e).parent().parent().remove();
            },
        });
    }else{
        $.confirm({
            title: 'Apa anda yakin?',
            content: '',
            confirmButton: 'Ya',
            confirm: function(){
              $.ajax({
                type: "POST",
                data:{id:id},
                url: config.base+"gs/delete_item",
                dataType: 'html',
                cache: false,
                success: function(resp){
                    toggle_visibility('item_'+id);
                }
              });
            },
        });
    }    
}


function delete_request(id,category){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id, category:category},
            url: config.base+"gs/delete_request",
            dataType: 'html',
            cache: false,
            success: function(resp){
                toggle_visibility('project_'+id);
            }
          });
        },
    });
}