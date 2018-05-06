function get_summary_pipeline(v_cbgroup, v_product, v_valuta, v_id_div_summary, v_id_div_summary_highlight, v_id_div_detail, v_id_div_detail_highlight, v_id_table_rincian, v_id_customer_highlight){
	var result=[];
	var detail_type="cbgroup";
	if(v_cbgroup=="all"){
		detail_type="cbgroup";
	}else{
		detail_type="cbdept";
	}
	$.getJSON(
		config.base+"api_fund/query_pipeline_projection",
		{
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta
		},
		function(data,status,xhr){
			if(status=="success"){
				//console.log("success"+v_id_div_summary+v_id_div_summary_highlight);
				draw_pipeline_graph(data, v_id_div_summary, v_id_div_summary_highlight);			
	 		}else{
	 			console.log(status);
	 		}
		}
	);
}

function draw_pipeline_graph(v_data, v_id_div, v_id_div_highlight){
	// data_provider = [
	// 	{
	// 		"year": "Sep 2015",
	// 		"income": 23.5,
	// 		"expenses": 18.1
	// 	}
	// ];
	var data_provider=[];
	var total_target=0;
	var total_realization=0;
	var date = null;
	var newDate = "";
	var percentage=0;

	// Get Target
	$.each( v_data.targets, function( key, val ) {
		date = new Date(val.date);
		date_target = date.toString('MMM yy');
		total_target = parseFloat(total_target) + parseFloat(val.target);
	});

	// Get Realization
	$.each( v_data.realizations, function( key, val ) {
		date = new Date(val.date);
		date_realz = date.toString('MMM yy');
		total_realization = parseFloat(total_realization) + parseFloat(val.realization);
	});
	var pipe_per = 1; var date_pipe = []; var real_pipe = []; var last_pipe = parseFloat(total_realization); var gap_pipe = []; var open_pipe = []; var color_pipe = [];
	$.each( v_data.pipeline, function( key, each_pp ) {
		var tot_pipe_part = 0;
		$.each( each_pp, function( key, val ) {
			date = new Date(val.pipeline_date);
			//date_pipe[pipe_per] = date.toString('MMM yy');
			//real_pipe[pipe_per] = parseFloat(real_pipe[pipe_per]) + parseFloat(val.amount);
			tot_pipe_part = tot_pipe_part + parseFloat(val.amount)*1000000;
		});
		open_pipe[pipe_per] = last_pipe;
		gap_pipe[pipe_per] = tot_pipe_part;
		real_pipe[pipe_per] = last_pipe+tot_pipe_part;
		if(tot_pipe_part<0){
			color_pipe[pipe_per] = fund_negative_color;
		}else{color_pipe[pipe_per] = fund_color;}
		last_pipe = real_pipe[pipe_per];
		pipe_per=pipe_per+1;
	});

	// Draw Highlight
	percentage = parseFloat(last_pipe*100 / total_target).toFixed(get_bhd_comma(last_pipe*100 / total_target));
	$("#"+v_id_div_highlight).html(percentage+"%");

	var chart = AmCharts.makeChart(v_id_div, {
		"type": "serial",
		"theme": "light",
		  "dataProvider": [ {
			"name": date_realz,
			"open": 0,
			"close": total_realization,
			"show_val": get_show_number(total_realization).toFixed(get_bhd_comma_val(get_show_number(total_realization))),
			"satuan": get_show_number_satuan(total_realization),
			"color": fund_color,
		  }, {
			"name": "Mgu 1",
			"open": open_pipe[1],
			"close": real_pipe[1],
			"show_val": get_show_number(gap_pipe[1]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[1]))),
			"satuan": get_show_number_satuan(gap_pipe[1]),
			"color": color_pipe[1],
		  }, {
			"name": "Mgu 2",
			"open": open_pipe[2],
			"close": real_pipe[2],
			"show_val": get_show_number(gap_pipe[2]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[2]))),
			"satuan": get_show_number_satuan(gap_pipe[2]),
			"color": color_pipe[2],
		  }, {
			"name": "Mgu 3",
			"open": open_pipe[3],
			"close": real_pipe[3],
			"show_val": get_show_number(gap_pipe[3]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[3]))),
			"satuan": get_show_number_satuan(gap_pipe[3]),
			"color": color_pipe[3],
		  }, {
			"name": "Mgu 4",
			"open": open_pipe[4],
			"close": real_pipe[4],
			"show_val": get_show_number(gap_pipe[4]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[4]))),
			"satuan": get_show_number_satuan(gap_pipe[4]),
			"color": color_pipe[4],
		  }],
		  "valueAxes": [ {
			"axisAlpha": 0,
			"gridAlpha": 0,
			"position": "left",
			"labelsEnabled":false,
		  } ],
		  "startDuration": 1,
		  "graphs": [ {
			"balloonText": "<span style='color:[[color]]'>[[category]]</span><br><b>[[show_val]] [[satuan]]</b>",
			"colorField": "color",
			"fillAlphas": 0.8,
			"labelText": "[[show_val]] [[satuan]]",
			"lineColor": "#ffffff",
			"openField": "open",
			"type": "column",
			"valueField": "close"
		  } ],
	 
		  "columnWidth": 0.6,
		  "categoryField": "name",
		  "categoryAxis": {
			"gridPosition": "start",
			"axisAlpha": 1,
			"gridAlpha": 0,
		  },
		  "export": {
			"enabled": true
		  }
	});
}

function get_top_pipeline_fund(gv_cbgroup, gv_product, gv_valuta, gv_type){
	$.getJSON(
		config.base+"api_fund/get_top_pipeline_fund",
		{
			cbgroup: gv_cbgroup,
			product: gv_product,
			valuta: gv_valuta,
			type: gv_type
		},
		function(data,status,xhr){
			var items=[];
			if(status=="success"){
				$.each( data.results, function( key, val ) {
					items.push("<tr>"+
	    			"<td style='text-align:left;'>"+val.customer+"</td>"+
	    			"<td style='text-align:center'>"+val.buc+"</td>"+
	    			"<td style='text-align:center'>"+val.valuta+"</td>"+
	    			"<td style='text-align:center'>"+val.product+"</td>"+
	    			"<td style='text-align:center'>"+val.rate+"</td>"+
	    			"<td style='text-align:center'>"+val.pipeline_date+"</td>"+
	    			"<td style='text-align:center'>"+val.total_amount+"</td>"+
	    			"<td style='text-align:center'>"+val.period+"</td></tr>");
	  			});
	  			$("#top_pipeline_fund").html(items);
	 		}else{
	  			$("#top_pipeline_fund").html("data could not be loaded");
	 		}
		}
	);
}


function load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta, gv_type, div_graph){	
	get_summary_pipeline(gv_cbgroup, gv_product, gv_valuta, 
		div_graph, "total_projection_highlight",
		"detail_realization_graph", "detail_realization_highlight",
		"group_pipeline_detail","customer_realization_highlight");
	get_top_pipeline_fund(gv_cbgroup, gv_product, gv_valuta, gv_type);
	change_element_filter(gv_cbgroup, gv_product, gv_valuta);
}

function load_fund_summary(gv_cbgroup, gv_product, gv_valuta, gv_type){
	load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta, gv_type, "chartdiv_pipeline");
}