function get_credit_growth(v_report_type, v_cbgroup, v_product, v_valuta, v_sort, v_limit, v_id_div){
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
		"http://localhost/cbic/api_credit/query_growth_summary",
		{
			report_type: v_report_type,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			sort: v_sort,
			limit: v_limit
		},
		function(data,status,xhr){
			var items = [];
			if(status=="success"){
				$.each( data.results, function( key, val ) {
					var pct = addCommas((val.percentage*1).toFixed(1));
					var a_amount = addCommas((val.a_amount/1000000).toFixed(0));
					var b_amount = addCommas((val.b_amount/1000000).toFixed(0));
					items.push("<tr>");
	    			items.push("<td>"+val.customer_group+"</td>");
	    			items.push("<td style='text-align:center'>"+val.buc+"</td>");
	    			items.push("<td style=\"text-align:center\">"+a_amount+"</td>");
	    			items.push("<td style=\"text-align:center\">"+b_amount+"</td>");
	    			items.push("<td style=\"text-align:center\">"+pct+"</td>");
	    			items.push("</tr>");
	    			//console.log(val.cbgroup_id);
	  			});
	  			$(v_id_div).html(items);
  			}else{
	  			$(v_id_div).html("error");
	  		}
  		}
	);	
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}


function get_credit_summary(v_report_type, v_date, v_command_date, v_cbgroup, v_product, v_valuta, v_id_div){
	/**
	*	input 
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   v_command_date : BETWEEN, IN
	*	-	v_product : GIRO, DEPO, ALL
	*	-	v_valuta  : RP, VA, ALL
	*	-	v_cbgroup_id : 1 - 7, ALL
	*	process : get the screenshot credit for the certain date
	*	output : group by date, and filter by product, valuta
	*/

	var result=[];
	$.getJSON(
		"http://localhost/cbic/api_credit/query_credit_summary",
		{
			date: v_date,
			command_date: v_command_date,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta
		},
		function(data,status,xhr){
			if(status=="success"){
				if(v_report_type=="YoY"){
					draw_YoY_graph2(data, v_id_div);
				}else if(v_report_type=="YtD"){
					draw_YtD_graph2(data, v_id_div);
				}else if(v_report_type=="MtD"){
					draw_MtD_graph2(data, v_id_div);
				}
	 		}else{
	 			console.log(status);
	 		} 		
	 	}
	);

	// Since getJson only apply for async httpGetRequest , I use $.ajax even it's deprecated
	// $.ajax({
	//     type: 'GET',
	//     url: "http://localhost/cbic/api_credit/query_credit_summary",
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
	return result;
}

function draw_YoY_graph2(v_data, v_id_div){
	var data_provider = [];
	$.each( v_data.results, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('MMM yyyy');
		//console.log(newDate);
	 	data_provider.push(
		    {
			    date: newDate, 
			    amount: Math.round(val.amount/1000000), 
			    color: "#5856d6"
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
		"balloonText": "[[category]]: <b>[[value]]</b>",
		"fillAlphas": 0.6,
		"lineAlpha": 0.2,
		"lineColor": "color",
		"labelText": "[[value]]",
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

function draw_YoY_graph(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta, v_id_div){
	/**
	*	input
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   $command_date : BETWEEN, IN
	*	-	$product : GIRO, DEPO, ALL
	*	-	$valuta  : RP, VA, ALL
	*	-	$cbgroup_id : 1 - 7, ALL
	*	-   v_id_div : id_div_html 
	*	process : get the screenshot credit for the certain date
	*	output : group by date, and filter by product, valuta and draw graph
	*/

	// OPEN
	var data_json = get_credit_summary(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta);

	// hardcoded for testing
	//var data_json = get_credit_summary('2015-08-01;2015-08-02;2015-08-03', v_command_date, v_cbgroup_id, v_product, v_valuta);
	var data_provider = [];
	$.each( data_json, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('MMM yyyy');
		//console.log(newDate);
	 	data_provider.push(
		    {
			    date: newDate, 
			    amount: val.amount, 
			    color: "#5ac8fa"
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
		"dashLength": 0
	  } ],
	  "gridAboveGraphs": true,
	  "startDuration": 1,
	  "graphs": [ {
		"balloonText": "[[category]]: <b>[[value]]</b>",
		"fillAlphas": 0.6,
		"lineAlpha": 0.2,
		"lineColor": "color",
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

function draw_MtD_graph2(v_data, v_id_div){
	var chart_data = [];
	var key_max = Object.keys(v_data.results).length-1;
	$.each( v_data.results, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('dd MMM yyyy');
		if(key==0 || key==key_max){
			var newDate = date.toString('dd MMM yyyy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: Math.round(val.amount/1000000), 
				    bulletClass: "lastBullet"
				}
			);
		}else{
			var newDate = date.toString('dd');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: Math.round(val.amount/1000000), 
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
	    axisAlpha: 0.2,
	    labelsEnabled: true
	  }],
	  graphs: [
		{
	    id: "g3",
	    title: "2015 : ",
	    valueField: "amount",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: "#5856d6",
	    balloonText: "[[value]]",
	    lineThickness: 2,
	    legendValueText: "[[value]] (Growth : [[description]]%)",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.6,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[value]]",
	    bulletBorderColor: "#5856d6",
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
	  legend: {
	    bulletType: "round",
	    equalWidths: false,
	    valueWidth: 120,
	    useGraphSettings: true,
	    color: "Black"
	  }
	});

}

function draw_MtD_graph(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta, v_id_div){
	/**
	*	input
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   $command_date : BETWEEN, IN
	*	-	$product : GIRO, DEPO, ALL
	*	-	$valuta  : RP, VA, ALL
	*	-	$cbgroup_id : 1 - 7, ALL
	*	-   v_id_div : id_div_html 
	*	process : get the screenshot credit for the certain date
	*	output : group by date, and filter by product, valuta and draw graph
	*/

	// OPEN
	var data_json = get_credit_summary(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta);
	// hardcoded for testing
	//var data_json = get_credit_summary('2015-08-01;2015-08-02;2015-08-03', v_command_date, v_cbgroup_id, v_product, v_valuta);
	
	var chart_data = [];
	var key_max = Object.keys(data_json).length-1;
	$.each( data_json, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('dd MMM yyyy');
		if(key==0 || key==key_max){
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount,
				    bulletClass: "lastBullet"
				}
			);
		}else{
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount
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
	    axisAlpha: 0.2,
	    labelsEnabled: true
	  }],
	  graphs: [
		{
	    id: "g3",
	    title: "2015 : ",
	    valueField: "amount",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: "#5ac8fa",
	    balloonText: "[[value]]",
	    lineThickness: 2,
	    legendValueText: "[[value]] (Growth : [[description]]%)",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.6,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[value]]",
	    bulletBorderColor: "#5ac8fa",
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
	  legend: {
	    bulletType: "round",
	    equalWidths: false,
	    valueWidth: 120,
	    useGraphSettings: true,
	    color: "Black"
	  }
	});
}

function draw_YtD_graph2(v_data, v_id_div){
	var chart_data = [];
	var key_max = Object.keys(v_data.results).length-1;
	$.each( v_data.results, function( key, val ) {
		var date = new Date(val.date);
		if(key==0 || key==key_max){
			var newDate = date.toString('dd MMM yyyy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: Math.round(val.amount/1000000), 
				    bulletClass: "lastBullet"
				}
			);
		}else{
			var newDate = date.toString('MMM yyyy');
			chart_data.push(
			    {
				    date: newDate, 
				    amount: Math.round(val.amount/1000000), 
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
	    axisAlpha: 0.2,
	    labelsEnabled: true
	  }],
	  graphs: [
		{
	    id: "g3",
	    title: "2015 : ",
	    valueField: "amount",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: "#5856d6",
	    balloonText: "[[value]]",
	    lineThickness: 2,
	    legendValueText: "[[value]] (Growth : [[description]]%)",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.6,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[value]]",
	    bulletBorderColor: "#5856d6",
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
	  legend: {
	    bulletType: "round",
	    equalWidths: false,
	    valueWidth: 120,
	    useGraphSettings: true,
	    color: "Black"
	  }
	});
}

function draw_YtD_graph(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta, v_id_div){
	/**
	*	input
	*   -	v_date : string 'Y-m-d';'Y-m-d';'Y-m-d', delimiter must be ';'
    *   -   $command_date : BETWEEN, IN
	*	-	$product : GIRO, DEPO, ALL
	*	-	$valuta  : RP, VA, ALL
	*	-	$cbgroup_id : 1 - 7, ALL
	*	-   v_id_div : id_div_html 
	*	process : get the screenshot credit for the certain date
	*	output : group by date, and filter by product, valuta and draw graph
	*/

	// OPEN
	var data_json = get_credit_summary(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta);

	// hardcoded for testing
	// var data_json = get_credit_summary('2015-08-01;2015-08-02;2015-08-03', v_command_date, v_cbgroup_id, v_product, v_valuta);
	var chart_data = [];
	var key_max = Object.keys(data_json).length-1;
	$.each( data_json, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('dd MMM yyyy');
		if(key==0 || key==key_max){
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount,
				    bulletClass: "lastBullet"
				}
			);
		}else{
			chart_data.push(
			    {
				    date: newDate, 
				    amount: val.amount
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
	    axisAlpha: 0.2,
	    labelsEnabled: true
	  }],
	  graphs: [
		{
	    id: "g3",
	    title: "2015 : ",
	    valueField: "amount",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: "#5ac8fa",
	    balloonText: "[[value]]",
	    lineThickness: 2,
	    legendValueText: "[[value]] (Growth : [[description]]%)",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.6,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[value]]",
	    bulletBorderColor: "#5ac8fa",
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
	  legend: {
	    bulletType: "round",
	    equalWidths: false,
	    valueWidth: 120,
	    useGraphSettings: true,
	    color: "Black"
	  }
	});
}

function get_highlight_summary(v_date, v_command_date, v_cbgroup, v_product, v_valuta, v_id_div){
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
		"http://localhost/cbic/api_credit/query_credit_summary",
		{
			date: v_date,
			command_date: v_command_date,
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta
		},
		function(data,status,xhr){
			if(status=="success"){
				var items = [];
				var first_amount=0;
				var gap_amount=0;
				var percentage=0;
				var data_results = data.results;
				$.each( data_results, function( key, val ) {
					gap_amount = val.amount - gap_amount;
				});

				if (typeof data_results[0] != 'undefined') {
					first_amount=data_results[0].amount;
					percentage=gap_amount*100/first_amount;
				}
				
				var bhd_cmmma = 0;
				if((Math.abs(percentage)<1) && (Math.abs(percentage)>0.1)){bhd_cmma = 1;}
				else if((Math.abs(percentage)>1) || Math.abs(percentage)==0){bhd_cmma = 0;}
				else if(Math.abs(percentage)<0.1){bhd_cmma = 2;}
				var pcr=addCommas((percentage*1).toFixed(bhd_cmma));
				items.push(pcr);

				$(v_id_div).html(items);
	 		}else{
	 			console.log(status);
	 		}
		}
	);
}