function reload_summary_page_content(customer_id, customer_type){
    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"customer_group/reload_summary_performance_page",
        data: {customer_id: customer_id, customer_type: customer_type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#performance_summary_customer").html(resp.html);
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function change_product_detail(param){
    var product_code = $("#product_detail").val();
    var composition = $("#composition").val();
    var date = $("#date_filter").val();
    var product = $("#product_filter").val();
    var valuta = $("#valuta_filter").val();
    var growth_type = $("#growth_type").val();

    var amount_result = "";
    if(product_code == "fund"){
        amount_result = $("#amount_filter").val();
    }

    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"customer_group/change_product_detail",
        data: {product_code:product_code,type:"<?php echo $type?>",customer:"<?php echo $customer->customer?>",composition:composition,date:date,product:product,valuta:valuta, param:param, growth_type: growth_type, amount_result: amount_result},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                if(param == 'change_prod' || param == 'date_filter'){
                    $("#filter_page").html(resp.filter_page);
                }
                if(param != "change_growth_type"){
                    $("#composition_page").html(resp.composition_page);
                }
                $("#growth_page").html(resp.growth_page);
                $('#top_realization_page').html(resp.top_realization_page);

                $('.product_sub_title').html(resp.real_prod);
                $('.selectpicker').selectpicker('refresh');
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function see_all_top(type, code, product_code,date){
    var amount_result = "";
    if(!product_code && !date){
        var product_code = $("#product_detail").val();
        var date_filter = $("#date_filter").val();
        var valuta_filter = $("#valuta_filter").val();
        var product_filter = $("#product_filter").val();

        if(product_code == "fund"){
            amount_result = $("#amount_filter").val();
        }
    }else{
        var product_code = product_code;
        var date_filter = date;
        var valuta_filter = "";
        var product_filter = "";
    }
    
    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"portfolio/see_all_top",
        data: {prod: product_code, customer:"<?php echo $customer->customer?>", date: date_filter, valuta: valuta_filter, product: product_filter,type:type, code:code, grouping:'<?=$this->uri->segment(3)?>', amount_result: amount_result},
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

function show_growth_detail(product_code,date,marker){
    var amount_result = "";
    if(!product_code && !date){
        var product_code = $("#product_detail").val();
        var date_filter = $("#date_filter").val();
        var valuta_filter = $("#valuta_filter").val();
        var product_filter = $("#product_filter").val();

        if(product_code == "fund"){
            amount_result = $("#amount_filter").val();
        }

    }else{
        var product_code = product_code;
        var date_filter = date;
        var valuta_filter = "";
        var product_filter = "";
    }
    var growth_type = $("#growth_type").val();
    var type = $("#type").val();
    var start = "";
    var end = "";

    if(marker == "detail"){
        start = $("#start").val();
        end = $("#end").val();
    }


    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"portfolio/show_growth_detail",
        data: {prod: product_code, customer:"<?php echo $customer->customer?>", date: date_filter, valuta: valuta_filter, product: product_filter, growth_type: growth_type, grouping:'<?=$this->uri->segment(3)?>',marker: marker, start: start, end: end, type: type, amount_result: amount_result},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                if(marker == "detail"){
                    $('#div_growth_graph').html(resp.growth_graph);

                    //$('#div_growth_graph').html('as');
                }
                else{
                    show_popup_modal(resp.html);
                }
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function refresh_ncl_data(ncl_type){
    var date_filter = $("#"+ncl_type+"_date").val();
    //alert(date_filter);
    $.ajax({
        type: "POST",
        url: config.base+"customer_group/refresh_ncl_data",
        data: {date_filter:date_filter,grouping:'<?=$this->uri->segment(3)?>',customer:"<?php echo $customer->customer?>",ncl_type:ncl_type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                var page = 
                $("#"+ncl_type+"_page").html(resp.page);
            }else{}
        }
    });

}