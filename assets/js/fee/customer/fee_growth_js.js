function get_fee_growth(v_report_type, v_cbgroup, v_product, v_valuta, v_sort, v_limit, v_id_div){
   	/**
	*	input 
	*   -	v_report_type : YoY, YtD, MtD, DtD
	*	-	v_product : GIRO, DEPO, ALL
	*	-	V_valuta  : RP, VA, ALL
	*	-	v_cbgroup_id : 1 - 7, ALL
	*	-	v_sort    : DESC, ASC (DESC: highest growth, ASC: lowest growth)
	*	-	v_limit   : 20, 10, x (integer)
	*	-	v_id_div  : id div html
	*	process : get the highest and lowest growth
	*	output : group by customer_group, order by percentage, and filter by product, valuta
	*/
	$.getJSON(
		config.base+"api_fee/query_growth_summary",
		{
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			sort: v_sort,
			limit: v_limit,
			cust_type: cust_type,
			cust_id: cust_id
		},
		function(data, status, xhr){
			var items = [];
			if(status=="success"){
				$.each( data.results, function( key, val ) {
					var pct = addCommas((val.percentage/1000000).toFixed(0));
					var a_amount = addCommas((val.a_amount/1000000).toFixed(0));
					var b_amount = addCommas((val.b_amount/1000000).toFixed(0));
					items.push("<tr>"+
	    			"<td style='padding-left:5px;'>"+val.customer+"</td>"+
	    			"<td style='text-align:center'>"+val.buc+"</td>"+
	    			"<td style=\"text-align:center\">"+a_amount+"</td>"+
	    			"<td style=\"text-align:center\">"+b_amount+"</td>"+
	    			"<td style=\"text-align:center\">"+pct+"</td></tr>");
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

function get_fee_summary(v_report_type, v_command_date, v_cbgroup, v_product, v_valuta, v_id_div){
	/**
	*	input 
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   v_command_date : BETWEEN, IN
	*	-	v_product : GIRO, DEPO, ALL
	*	-	v_valuta  : RP, VA, ALL
	*	-	v_cbgroup_id : 1 - 7, ALL
	*	process : get the screenshot fee for the certain date
	*	output : group by date, and filter by product, valuta
	*/

	//var result=[];
	$.getJSON(
		config.base+"api_fee/query_fee_summary",
		{
			command_date: v_command_date,
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			cust_type: cust_type,
			cust_id: cust_id
		},
		function(data,status,xhr){
			if(status=="success"){
				if(v_report_type=="YoY"){
					draw_YoY_graph(data, v_id_div);
				}else if(v_report_type=="YtD"){
					draw_YtD_graph(data, v_id_div);
				}else if(v_report_type=="MtD"){
					draw_MtD_graph(data, v_id_div);
				}
	 		}else{
	 			console.log(status);
	 		}
		}
	);

	// Since getJson only apply for async httpGetRequest , I use $.ajax even it's deprecated
	// $.ajax({
	//     type: 'GET',
	//     url: config.base+"api_fee/query_fee_summary",
	//     dataType: 'json',
	//     success: function(data,status,xhr) { 
	//     	result=data.results;
	//     },
	//     data: {
	//     	date: v_date,
	// 		command_date: v_command_date,
	// 		cbgroup_id: v_cbgroup_id,
	// 		product: v_product,
	// 		valuta: v_valuta
	//     },
	//     async: false
	// });
	//console.log(JSON.stringify(result));
	//console.log(JSON.stringify(result));
	//return result;
}

function draw_YoY_graph(v_data, v_id_div){
	var data_provider = [];
	$.each( v_data.results, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('MMM yyyy');
	 	data_provider.push(
		    {
			    date: newDate, 
			    amount: val.amount,
			    amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
			    color: fund_color,
			    satuan: get_show_number_satuan(val.amount),
			}
		);
	});
	//console.log(JSON.stringify(data_provider));

	var chart = AmCharts.makeChart( v_id_div, {
	  "type": "serial",
	   "theme": "light",
  		"marginRight": 70,

	  "dataProvider": data_provider,

	  "valueAxes": [ {
		"gridColor": "#FFFFFF",
		"gridAlpha": 0,
		"dashLength": 0,
		"gridAlpha": 0,
		"axisAlpha": 0,
		"labelsEnabled":false,
	  } ],
	  
	  
	  "gridAboveGraphs": true,
	  "startDuration": 1,
	  "graphs": [ {
		"balloonText": "[[category]]: <b>[[amount_show]] [[satuan]]</b>",
		"fillAlphas": 1,
		"lineAlpha": 0.2,
		"lineColor": "color",
		"labelText": "[[amount_show]] [[satuan]]",
		"type": "column",
		"fillColorsField": "color",
		"valueField": "amount",
	  } ],
	  "chartCursor": {
		"categoryBalloonEnabled": false,
		"cursorAlpha": 0,
		"zoomable": false
	  },
	  "categoryField": "date",
	  "categoryAxis": {
		"gridPosition": "start",
		"gridAlpha": 0,
		"tickPosition": "start",
		"tickLength": 20,
	  },
	  "export": {
		"enabled": true
	  }

	} );

}

function draw_MtD_graph(v_data, v_id_div){
	var chart_data = [];
	var key_max = Object.keys(v_data.results).length-1;
	$.each( v_data.results, function( key, val ) {
		var date = new Date(val.date);
		if(url_arr[3]!="summary"){
			date_c= date.toString('d');
		}else{
			date_c= "";
		}
		if(key==0 || key==key_max){
			var newDate = date.toString('dd MMM yyyy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount,
			    	amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
				    bulletClass: "lastBullet",
				    satuan: get_show_number_satuan(val.amount),
				}
			);
		}else{
			var newDate = date.toString('dd');
			chart_data.push(
			    {
				    date: date_c, 
				    amount: val.amount,
			    	amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
				   	satuan: get_show_number_satuan(val.amount),
				}
			);
		}
	});

	var chart = AmCharts.makeChart(v_id_div, {
	  type: "serial",
	  dataDateFormat: "YYYY-MM-DD",
	  dataProvider: chart_data,
	  addClassNames: true,
	  startthis_year: 0,
	  color: "black",
	  marginLeft: 0,
	  categoryField: "date",
	  categoryAxis: {
	        gridAlpha: 0
	    },
	  valueAxes: [{
	    gridAlpha: 0,
	    axisAlpha: 0,
	    labelsEnabled: false
	  }],
	  graphs: [
		{
	    id: "g3",
	    title: "2015 : ",
	    valueField: "amount",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: fund_color,
	    balloonText: "[[amount_show]] [[satuan]]",
	    lineThickness: 2,
	    legendValueText: "[[amount_show]] [[satuan]]",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.8,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[amount_show]] [[satuan]]",
	    bulletBorderColor: fund_color,
	    bulletBorderThickness: 2,
	    bulletBorderAlpha: 1,
	    dashLengthField: "dashLength",
	    
	  }],

	  chartCursor: {
	    zoomable: false,
	    categoryBalloonDateFormat: "DD",
	    cursorAlpha: 0,
	    valueBalloonsEnabled: false
	  },
	  "export": {
          "enabled": true
        }
	  /*legend: {
	    bulletType: "round",
	    equalWidths: false,
	    valueWidth: 120,
	    useGraphSettings: true,
	    color: "Black"
	  }*/
	});
}

function draw_YtD_graph(v_data, v_id_div){

	var chart_data = [];
	var key_max = Object.keys(v_data.results).length-1;
	$.each( v_data.results, function( key, val ) {
		var date = new Date(val.date);
		if(url_arr[3]!="summary"){
			var date_c= date.toString('d MMM yy');
		}else{
			var date_c= "";
		}
		if(key==0 || key==key_max){
			var newDate = date.toString('dd MMM yyyy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount,
			    	amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
				    bulletClass: "lastBullet",
				    satuan: get_show_number_satuan(val.amount),
				}
			);
		}else{
			var newDate = date.toString('MMM yyyy');
			chart_data.push(
			    {
				    date: date_c, 
				    amount: val.amount,
			    	amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
				    satuan: get_show_number_satuan(val.amount),
				}
			);
		}
	});


	var chart = AmCharts.makeChart(v_id_div, {
	  type: "serial",
	  dataDateFormat: "YYYY-MM-DD",
	  dataProvider: chart_data,
	  addClassNames: true,
	  startthis_year: 0,
	  color: "black",
	  marginLeft: 0,
	  categoryField: "date",
	  categoryAxis: {
	        gridAlpha: 0
	    },
	  valueAxes: [{
	    gridAlpha: 0,
	    axisAlpha: 0,
	    labelsEnabled: false
	  }],
	  graphs: [
		{
	    id: "g3",
	    title: "2015 : ",
	    valueField: "amount",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: fund_color,
	    balloonText: "[[amount_show]] [[satuan]]",
	    lineThickness: 2,
	    legendValueText: "[[amount_show]] [[satuan]]",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.8,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[amount_show]] [[satuan]]",
	    bulletBorderColor: fund_color,
	    bulletBorderThickness: 2,
	    bulletBorderAlpha: 1,
	    dashLengthField: "dashLength",
	    
	  }],

	  chartCursor: {
	    zoomable: false,
	    categoryBalloonDateFormat: "DD",
	    cursorAlpha: 0,
	    valueBalloonsEnabled: false
	  },
	  "export": {
          "enabled": true
        }
	  /*legend: {
	    bulletType: "round",
	    equalWidths: false,
	    valueWidth: 120,
	    useGraphSettings: true,
	    color: "Black"
	  }*/
	});

}

function get_highlight_summary(v_report_type, v_command_date, v_cbgroup, v_product, v_valuta, v_id_div){
	/**
	*	input
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   $command_date : BETWEEN, IN
	*	-	$product : GIRO, DEPO, ALL
	*	-	$valuta  : RP, VA, ALL
	*	-	$cbgroup_id : 1 - 7, ALL
	*	-   v_id_div : id_div_html 
	*	process : calculate growth
	*	output : group by date, and filter by product, valuta and draw graph
	*/

	var result=[];
	$.getJSON(
		config.base+"api_fee/query_fee_summary",
		{
			command_date: v_command_date,
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta
		},
		function(data,status,xhr){
			if(status=="success"){
				var items = [];
				var first_amount=0;
				var last_amount=0;
				var gap_amount=0;
				var percentage=0;
				var data_results = data.results;
				
				if (typeof data_results[0] != 'undefined') {
					first_amount=data_results[0].amount;
					last_amount=data_results[data_results.length-1].amount; 
					percentage=((last_amount/first_amount)-1)*100;
				}
				var bhd_cmma = get_bhd_comma(percentage);
				
				var pcr=addCommas((percentage*1).toFixed(bhd_cmma));
				items.push(pcr);
				$(v_id_div).html(items);
	 		}else{
	 			console.log(status);
	 		}
		}
	);
}

function load_fee_growth_summary(gv_cbgroup, gv_product, gv_valuta, growth_type, chart_div){
		/*** Initial Load Fund Growth ***/
		//var growth_arr =["YoY","YtD","MtD"];
		var index; var page_type = "chartdiv_"+growth_type+"_growth";
		//for(i = 0; i < growth_arr.length; ++i){
		if(page_type == chart_div){
			if(cust_type != "customer"){
				// Year on Year - Top 10 Customer Group with the highest growth
				get_fee_growth(growth_type, gv_cbgroup, gv_product, gv_valuta, "desc", 10, "#growth_plus_"+growth_type);
				// Year on Year - Top 10 Customer Group with the lowest growth
				get_fee_growth(growth_type, gv_cbgroup, gv_product, gv_valuta, "asc", 10, "#growth_min_"+growth_type);
			}
		}
			// /*** Initial Load Fund Summary ***/
			get_fee_summary(growth_type,"IN", gv_cbgroup, gv_product, gv_valuta, chart_div);
			
			get_highlight_summary(growth_type,"IN", gv_cbgroup, gv_product, gv_valuta, "."+growth_type+"_highlight");
		//}
		change_element_filter(gv_cbgroup, gv_product, gv_valuta);
}
