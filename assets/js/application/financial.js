function show_financial_form(id, mosque_id){
    $(".loading_panel").show();

    $.ajax({
        type: "GET",
        url: config.base+"financial/show_financial_form",
        data: {id: id,mosque_id: mosque_id},
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





















function get_event(date,month_year){
    $(".loading_panel").show();
    var search = $("#event_search").val();
    
    $.ajax({
        type: "POST",
        url: config.base+"calendar/get_event",
        data: {date: date, month_year: month_year},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                $('.date_title').html(resp.date_title);
                $("#events_list_div").html(resp.html);

                $('.selectpicker').selectpicker('refresh');

                //show_popup_modal(resp.html);
            }else{}
        }
    });
}

function get_month_calendar(month,year){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"calendar/get_month_calendar",
        data: {month: month, year: year},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#calendar_month_div").html(resp.html);
                
                var month_year = "";
                if(month && year){
                    month_year = year+"-"+month;
                }
                get_event('',month_year);
            }else{}
            $(".loading_panel").hide();
        }
    });
}

function delete_event(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
          $.ajax({
            type: "POST",
            data:{id:id},
            url: config.base+"calendar/delete_event",
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status == 1){
                    //$('#popup_Modal').modal('hide');
                    window.location = config.base+"calendar";
                }
            }
          });
        },
    });
}