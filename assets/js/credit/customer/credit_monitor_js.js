function get_current_jammed_loan(v_cbgroup, v_product, v_valuta, v_npl_highlight){
    $.getJSON(config.base+"api_credit/get_current_jammed_loan", {
        cbgroup: v_cbgroup,
        product: v_product,
        valuta: v_valuta
    }, function(data, status, xhr) {
        if (status == "success") {
            $('#current_jammed_loan_table').html("");
			var tot_npl = 0; var tot_idr = 0; var tot_val = 0; var tot_tot = 0;
            $.each(data.result , function(key, val) {
                $('#current_jammed_loan_table').append("<tr>" +
                    "<td>" + val.bikole + "</td>" +
                    "<td>" + val.idr + "</td>" +
                    "<td>" + val.valas + "</td>" +
                    "<td>" + val.total + "</td>" +
                    "<td>" + val.percent + "</td></tr>");
				if(val.bikole != 1){
					tot_npl = tot_npl+parseFloat(val.percent);
				}
				tot_idr = tot_idr+parseFloat(val.idr);
				tot_val = tot_val+parseFloat(val.valas);
				tot_tot = tot_tot+parseFloat(val.total);
            });
            $('#current_jammed_loan_table').append("<tr style=\"font-weight:bold;\">" +
                    "<td> Total </td>" +
                    "<td>" + data.total['idr'] + "</td>" +
                    "<td>" + data.total['valas'] + "</td>" +
                    "<td>" + data.total['tot'] + "</td>" +
                    "<td> 100% </td></tr>");
			$("#"+v_npl_highlight).html(addCommas((tot_npl*1).toFixed(2))+"%");
			$("#total_credit").html("Rp "+get_show_number(data.total['tot_val']).toFixed(get_bhd_comma_val(get_show_number(data.total['tot_val'])))+" "+get_show_number_satuan_full(data.total['tot_val']));
        }
        else {
            console.log(status);
        }
    });
}

function get_customer_npl_loan(v_cbgroup, v_product, v_valuta) {
    $.getJSON(config.base+"api_credit/get_customer_npl_loan", {
        cbgroup: v_cbgroup,
        product: v_product,
        valuta: v_valuta
    }, function(data, status, xhr) {
        if (status == "success") {
            $('#customer_nlp_loan_table').html("");

            if (data.result.length === 0) {
                $('#customer_nlp_loan_table').append("<tr><td colspan='7'>Tidak ada data</td></tr>");
            }
            else {
                $.each(data.result , function(key, val) {
                    $('#customer_nlp_loan_table').append("<tr>" +
                        "<td style=\"text-align:left\">" + val.namadebitur + "</td>" +
                        "<td style=\"text-align:left\">" + val.groupdebitur + "</td>" +
                        "<td>" + val.buc + "</td>" +
                        "<td>" + val.bikole + "</td>" +
                        "<td>" + val.product + "</td>" +
                        "<td>" + val.valuta + "</td>" +
                        "<td>" + val.bakidebet + "</td></tr>");
                });
            }
        }
        else {
            console.log(status);
        }
    });
}

function get_customer_loan_ending(v_cbgroup, v_product, v_valuta, v_jtmp_highlight) {
    $.getJSON(config.base+"api_credit/get_customer_loan_ending", {
        cbgroup: v_cbgroup,
        product: v_product,
        valuta: v_valuta
    }, function(data, status, xhr) {
        if (status == "success") {
            $('#customer_loan_ending_table').html("");

            if (data.result.length === 0) {
                $('#customer_loan_ending_table').append("<tr><td colspan='5'>Tidak ada data</td></tr>");
            }
            else {
            	$('#'+v_jtmp_highlight).html(data.result.length);
                $.each(data.result , function(key, val) {
                    $('#customer_loan_ending_table').append("<tr>" +
                        "<td style=\"text-align:left\">" + val.namadebitur + "</td>" +
                        "<td style=\"text-align:left\">" + val.groupdebitur + "</td>" +
                        "<td>" + val.buc + "</td>" +
                        "<td>" + val.bakidebet + "</td>" +
                        "<td>" + val.matdate + "</td></tr>");
                });
            }
        }
        else {
            console.log(status);
        }
    });
}

function load_credit_monitoring_summary(gv_cbgroup, gv_product, gv_valuta, v_npl_highlight, v_jtmp_highlight){
    get_current_jammed_loan(gv_cbgroup, gv_product, gv_valuta, v_npl_highlight);
    get_customer_npl_loan(gv_cbgroup, gv_product, gv_valuta);
    get_customer_loan_ending(gv_cbgroup, gv_product, gv_valuta, v_jtmp_highlight);
    change_element_filter(gv_cbgroup, gv_product, gv_valuta);
}

function load_credit_summary(gv_cbgroup, gv_product, gv_valuta){
	load_credit_monitoring_summary(gv_cbgroup, gv_product, gv_valuta, "monitoring_highlight", "sum_jth_tmp");
}
