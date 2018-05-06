function get_rkk_list(type, value, cust_type, cust_name){
    var start = $("#start_rkk").val();
    var end = $("#end_rkk").val();
    var group_filter = $("#cbgroup_rkk").val();
    var dept_filter = "";
    if(group_filter){
        var dept_filter = $("#dept_filter").val();
    }
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"rkk/get_rkk_list",
        data: {type: type, value: value, start: start, 
            end: end, cbgroup: group_filter, cbdept: dept_filter,
            cust_type: cust_type, cust_name: cust_name},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $("#loading_panel").hide();
            }else{}
        }
    });
}
