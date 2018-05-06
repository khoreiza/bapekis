function get_summary_realization(v_cbgroup, v_product, v_valuta, v_id_div_graph, v_id_customer, v_id_customer_highlight){
	draw_customer_realization_graph(v_cbgroup, v_product, v_valuta, v_id_customer, v_id_customer_highlight, v_id_div_graph);
}

function draw_customer_realization_graph(v_cbgroup, v_product, v_valuta, v_id_div, v_id_div_highlights,v_id_div_pie){
   	/**
	*	input 
	*   -	v_data_target :
	*	- 	v_date 	  : date  
	*	-	v_product : GIRO, DEPO, ALL
	*	-	V_valuta  : RP, VA, ALL
	*	-	v_cbgroup_id : 1 - 7, ALL
	*	-	v_sort    : DESC, ASC (DESC: highest growth, ASC: lowest growth)
	*	-	v_limit   : 20, 10, x (integer)
	*	-	v_id_div  : id div html
	*	process : get the highest and lowest growth
	*	output : group by customer_group, order by percentage, and filter by product, valuta
	*/
	var total_target=0;
	var items=[];
	var total_percentage=0;
	$.getJSON(
		config.base+"api_fee/get_top_customer_realization",
		{
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			cust_type: cust_type,
			cust_id: cust_id
		},
		function(data,status,xhr){
			if(status=="success"){
				var i =1; var comp_par = 0; var pct_par = 0; var par_val = 0; var otr_val =0;
				$.each( data.results , function( key, val ) {
					var pct = parseFloat(val.composition).toFixed(2);
					total_percentage=parseFloat(total_percentage)+parseFloat(pct);
					var amount = addCommas((val.realization/1000000).toFixed(0));
					items.push("<tr>"+
	    			"<td style='text-align:left'>"+i+"</td>"+
	    			"<td style='text-align:left'>"+val.nasabah+"</td>"+
	    			"<td style='text-align:left'>"+val.customer_group+"</td>"+
	    			"<td>"+val.buc+"</td>"+
	    			"<td>"+amount+"</td>"+
	    			"<td>"+pct+"%</td></tr>");	 
	    			i++;
	    			if(pct_par<80){
	    				pct_par = pct_par+parseFloat(val.composition);
	    				comp_par = comp_par+1;
	    				par_val = par_val+parseFloat(val.realization);
	    			}else{
	    				otr_val = otr_val+parseFloat(val.realization);
	    			}			
				});
				$('#'+v_id_div).html(items);
				var bhd_cmma = get_bhd_comma(pct_par);
				var pcr=addCommas((pct_par*1).toFixed(bhd_cmma));
				$('#comp_par').html(comp_par);	
				$('#pct_par').html(pcr+"%");
				
				// Build the chart
				var chart = AmCharts.makeChart( v_id_div_pie, {
				  "type": "pie",
				  "theme": "light",
				  "dataProvider": [ {
					"title": comp_par+" Key Company",
					"value": par_val
				  }, {
					"title": "Others",
					"value": otr_val
				  }],
				  "titleField": "title",
				  "valueField": "value",
				  "labelRadius": 10,
				  "colors":["#007aff", "#ffcc00"],

				  "radius": "40%",
				  "labelText": "[[title]]: [[percents]]%",
				  "export": {
					"enabled": true
				  }
				});
	 		}else{
	 			$('#'+v_id_div).html("error");
	 			$('#'+v_id_div_highlights).html("0%");
	 		}
		}
	);
}


function load_fee_realization_summary(gv_cbgroup, gv_product, gv_valuta, div_graph){
	get_summary_realization(gv_cbgroup, gv_product, gv_valuta, div_graph,
		"customer_realization_table","customer_realization_highlight");
	change_element_filter(gv_cbgroup, gv_product, gv_valuta);
}

function load_fee_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fee_realization_summary(gv_cbgroup, gv_product, gv_valuta, "chartdiv_pareto");
}
