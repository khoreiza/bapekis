function get_performance_growth(v_report_type, v_cbgroup, v_product, v_valuta, v_sort, v_limit, v_id_div, v_modul){
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
		config.base+"api_performance/query_growth_summary",
		{
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			sort: v_sort,
			limit: v_limit,
			dept: gv_dept,
			modul: gv_modul
		},
		function(data, status, xhr){
			var items = [];
			if(status=="success"){
				$.each( data.results, function( key, val ) {
					var a_amount = addCommas((val.a_amount/1000000).toFixed(0));
					var b_amount = addCommas((val.b_amount/1000000).toFixed(0));
					var gwt_amount = addCommas((val.percentage/1000000).toFixed(0));
					items.push("<tr>"+
	    			"<td style='padding-left:5px;'>"+val.customer+"</td>"+
	    			"<td style='text-align:center'>"+val.buc+"</td>"+
	    			"<td style=\"text-align:center\">"+a_amount+"</td>"+
	    			"<td style=\"text-align:center\">"+b_amount+"</td>"+
	    			"<td style=\"text-align:center\">"+gwt_amount+"</td></tr>");
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

function get_performance_summary(v_report_type, v_command_date, v_cbgroup, v_product, v_valuta, v_id_div, v_modul){
	/**
	*	input 
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   v_command_date : BETWEEN, IN
	*	-	v_product : GIRO, DEPO, ALL
	*	-	v_valuta  : RP, VA, ALL
	*	-	v_cbgroup_id : 1 - 7, ALL
	*	process : get the screenshot fund for the certain date
	*	output : group by date, and filter by product, valuta
	*/

	//var result=[];
	$.getJSON(
		config.base+"api_performance/query_performance_trend",
		{
			command_date: v_command_date,
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			dept: gv_dept,
			modul:v_modul
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
				amount_real: addCommas((val.amount/1000000).toFixed(0)),
			    amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
			    color: fund_color,
			    satuan: get_show_number_satuan(val.amount),
			}
		);
	});

	var chart = AmCharts.makeChart( v_id_div, {
	  
	  "type": "serial",
	  "fontFamily": 'Myriad Pro Light',
	  "fontSize": fontsize,
  		"marginRight": 70,
	  "dataProvider": data_provider,

	  "valueAxes": [ {
		"gridColor": "#FFFFFF",
		"gridAlpha": 0,
		"dashLength": 0,
		"gridAlpha": 0,
		"axisAlpha": 0,
		"labelsEnabled":false,
		"minimum":0,
	  } ],
	  
	  
	  "gridAboveGraphs": true,
	  "startDuration": 1,
	  "graphs": [ {
		"balloonText": "[[category]]: <b>[[amount_real]]</b>",
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
			var newDate = date.toString('dd MMM yy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount,
					amount_real: addCommas((val.amount/1000000).toFixed(0)),
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
					amount_real: addCommas((val.amount/1000000).toFixed(0)),
			    	amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
				   	satuan: get_show_number_satuan(val.amount),
				}
			);
		}
	});

	var chart = AmCharts.makeChart(v_id_div, {
	  type: "serial",
	  "fontFamily": 'Myriad Pro Light',
	  "fontSize": fontsize,
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
	    labelsEnabled: false,
	    "minimum":0,
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
	    balloonText: "[[category]]: <b>[[amount_real]]</b>",
	    lineThickness: 2,
	    legendValueText: "[[amount_show]] [[satuan]]",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.8,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[amount_show]] [[satuan]]",
		"fontSize": fontsize,
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
			var newDate = date.toString('dd MMM yy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount,
					amount_real: addCommas((val.amount/1000000).toFixed(0)),
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
					amount_real: addCommas((val.amount/1000000).toFixed(0)),
			    	amount_show : get_show_number(val.amount).toFixed(get_bhd_comma_val(get_show_number(val.amount))),
				    satuan: get_show_number_satuan(val.amount),
				}
			);
		}
	});


	var chart = AmCharts.makeChart(v_id_div, {
	  "fontFamily": 'Myriad Pro Light',
	  "fontSize": fontsize,
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
	    labelsEnabled: false,
	    "minimum":0,
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
	    balloonText: "[[category]]: <b>[[amount_real]]</b>",
	    lineThickness: 2,
	    legendValueText: "[[amount_show]] [[satuan]]",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.8,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[amount_show]] [[satuan]]",
		"fontSize": fontsize,
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
		config.base+"api_performance/query_performance_trend",
		{
			command_date: v_command_date,
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			dept: gv_dept,
			modul:gv_modul
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

function load_performance_growth_summary(cbgroup, product, valuta, page, modul){
		/*** Initial Load Fund Growth ***/
		var growth_arr =["YoY","YtD","MtD"];
		var index;
		for(i = 0; i < growth_arr.length; ++i){
			var growth_div = "chartdiv_"+growth_arr[i]+"_growth";
			if(gv_modul == "portfolio"){growth_div = "chartdiv_"+growth_arr[i]+"_"+modul+"_growth";}
			
			get_performance_summary(growth_arr[i],"IN", cbgroup, product, valuta, growth_div, modul);
			
			if(page == "detail"){
				// Top 10 Customer Group with the highest growth
				get_performance_growth(growth_arr[i], cbgroup, product, valuta, "desc", 10, "#growth_plus_"+growth_arr[i]);
				// Top 10 Customer Group with the lowest growth
				get_performance_growth(growth_arr[i], cbgroup, product, valuta, "asc", 10, "#growth_min_"+growth_arr[i]);
				get_highlight_summary(growth_arr[i],"IN", cbgroup, product, valuta, "."+growth_arr[i]+"_highlight");
			}
		}
		change_element_filter(gv_cbgroup, gv_product, gv_valuta);
}

function load_performance_summary(cbgroup, product, valuta, dept){
	if(gv_modul == "portfolio"){
		load_performance_growth_summary(gv_cbgroup, gv_product, gv_valuta, "summary","fund");
		load_performance_growth_summary(gv_cbgroup, gv_product, gv_valuta, "summary","credit");
		load_performance_growth_summary(gv_cbgroup, gv_product, gv_valuta, "summary","fee");
	}else{
		load_performance_growth_summary(cbgroup, product, valuta,"detail", gv_modul);
	}
}