function show_popup_modal(resp, modal_id){
    $('#popup_Modal').modal('hide');
    setTimeout(function(){
        $('#modal_finder').html(resp);
        $('.selectpicker').selectpicker('refresh');
        $('#popup_Modal').modal('show');
    }, 500);
}

function show_form(id,comp_stat){
    $.ajax({
        type: "GET",
        url: config.base+"login_photo/show_form",
        data: {id: id,in_competition: comp_stat},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
}

function login_photo_form(id){
    $.ajax({
        type: "GET",
        url: config.base+"general/login_photo_form",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $('#photo_login_form').html(resp.message);
                $('.selectpicker').selectpicker('refresh');
            }else{}
        }
    });
}

function delete_photo(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"general/delete_login_photo",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $("#login_photo_"+resp.photo_id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function show_detail(id){
    $.ajax({
        type: "GET",
        url: config.base+"festival/show_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
}