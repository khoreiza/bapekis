function input_cr(id){
        $(".loading_panel").show();
        $.ajax({
            type: "GET",
            url: config.base+"ots/input",
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

function show_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"ots/show_popup",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
            }else{
            }
        }
    });
}
    
function delete_cr(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "GET",
            url: config.base+"ots/delete_call_report/"+id,
            dataType: 'html',
            cache: false,
            success: function(resp){
                toggle_visibility('cr_row_'+id);
            }
          });
        },
    });
}