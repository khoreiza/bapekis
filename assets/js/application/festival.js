function show_financial_form(id, mosque_id){
    $.ajax({
        type: "GET",
        url: config.base+"festival/show_form",
        data: {id: id,mosque_id: mosque_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
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