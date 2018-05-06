function draw_special_rate(v_cbgroup, v_product, v_valuta, v_id_div){
    /**
    *   input 
    *   -   v_product : GIRO, DEPO, ALL
    *   -   V_valuta  : RP, VA, ALL
    *   -   v_cbgroup_id : 1 - 7, ALL
    *   -   v_sort    : DESC, ASC (DESC: highest growth, ASC: lowest growth)
    *   -   v_limit   : 20, 10, x (integer)
    *   -   v_id_div  : id div html
    *   process : get the highest and lowest growth
    *   output : group by customer_group, order by percentage, and filter by product, valuta
    */
    var v_rate_int = 0.075;
    $.getJSON(
        config.base+"api_fund/query_special_rate",
        {
            cbgroup: v_cbgroup,
            product: v_product,
            valuta: v_valuta,
            rate_int: v_rate_int
        },
        function(data, status, xhr){
            var data_provider = [];
            var total_amount = 0;
            var date_trx = "";
            var key_max = Object.keys(data.results).length-1;
            if(status=="success"){
                $.each( data.results, function( key, val ) {
                    if(date_trx == val.date){
                        total_amount = parseFloat(total_amount) + parseFloat(val.amount);
                    }else{
                        if(date_trx != ""){
							date = new Date(date_trx);
							newDate = date.toString('d MMM yy');
                            data_provider.push({
                                year: newDate, 
                                value: total_amount,
								show_val: get_show_number(total_amount).toFixed(get_bhd_comma_val(get_show_number(total_amount))),
								satuan: get_show_number_satuan(total_amount),
							});
                        }
                        date_trx = val.date;
                        total_amount = parseFloat(0) + parseFloat(val.amount);
                    }
                    if(key==key_max){
						date = new Date(val.date);
						newDate = date.toString('d MMM yy');
                        data_provider.push({
                            year: newDate, 
                            value: total_amount,
							show_val: get_show_number(total_amount).toFixed(get_bhd_comma_val(get_show_number(total_amount))),
							satuan: get_show_number_satuan(total_amount),
						});
                    }
                });
				percentage = parseFloat(total_amount / 45721000000000*100).toFixed(get_bhd_comma(total_amount / 45721000000000*100));
				$("#total_utilisati_sr_highlight").html(percentage+"%");
                
				console.log(JSON.stringify(data_provider));
                var chart = AmCharts.makeChart(v_id_div, {
                    "type": "serial",
                    "theme": "light",
                    "marginTop":0,
                    "marginRight": 80,
                    "dataProvider": data_provider,
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "labelsEnabled":false,
                        "guides": [{
                            "dashLength": 6,
                            "inside": false,
                            "label": "Plafond 45.7 T",
                            "lineAlpha": 1,
                            "value": 45721000000000,
                           
                        }],
                    }],
                    "startDuration": 0.2,
                    "startEffect":"easeOutSine",
                    "graphs": [{
                        "id":"g1",
                        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[show_val]] [[satuan]]</span></b>",
                        "bullet": "round",
                        "bulletSize": 8,         
                        "lineColor": fund_color,
                        "lineThickness": 2,
                        "negativeLineColor": "#637bb6",
                        "fillColorsField": "lineColor",
                        "fillAlphas": 0.8,
                        "type": "smoothedLine",
                        "labelText": "[[show_val]] [[satuan]]",
                        "valueField": "value"
                    }],
                    "chartCursor": {
                        "categoryBalloonDateFormat": "YYYY",
                        "cursorAlpha": 0,
                        "valueLineEnabled":true,
                        "valueLineBalloonEnabled":true,
                        "valueLineAlpha":0.5,
                        "fullWidth":true
                    },
                    "categoryField": "year",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 1,
                        "gridAlpha": 0,
                      },
                    "export": {
                        "enabled": true
                    }
                });

            }else{
                $(v_id_div).html("error");
            }
        }
    );  
}

function list_top_special_rate(v_cbgroup, v_product, v_valuta, v_id_div){
    var v_rate_int = 0.075;
    $.getJSON(
        config.base+"api_fund/get_top_special_rate",
        {
            cbgroup: v_cbgroup,
            product: v_product,
            valuta: v_valuta,
            rate_int: v_rate_int
        },
        function(data, status, xhr){
            var items = [];
            if(status=="success"){
                $.each( data.results, function( key, val ) {
                    var composition = parseFloat(val.composition*100).toFixed(2);
                    var rate = parseFloat(val.rate_int*100).toFixed(2);
                    items.push("<tr>"+
                    "<td style='text-align:left'>"+val.namacustomer+"</td>"+
                    "<td style='text-align:left'>"+val.groupcustomer+"</td>"+
                    "<td>"+val.buc+"</td>"+
                    "<td>"+addCommas((val.l_prn/1000000).toFixed(0))+"</td>"+
                    "<td>"+rate+"%</td>"+
                    
                    "<td>"+composition+"%</td></tr>");
                    //items.push("<td>"+val.percentage+"</td>");
                    //items.push("</tr>");
                    //console.log(val.cbgroup_id);
                });
                $(v_id_div).html(items);
            }else{
                $(v_id_div).html("error");
            }
        }
    );  
}



function load_performance_special_rate_summary(gv_cbgroup, gv_product, gv_valuta){
	draw_special_rate(gv_cbgroup, gv_product, gv_valuta, "chartdiv_special_rate_LPS");
    list_top_special_rate(gv_cbgroup, gv_product, gv_valuta, "#table_top_special_rate");
}

function load_performance_summary(gv_cbgroup, gv_product, gv_valuta){	
    load_performance_special_rate_summary(gv_cbgroup, gv_product, gv_valuta);
}