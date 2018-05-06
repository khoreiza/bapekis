function get_fund_growth(v_report_type, v_cbgroup_id, v_product, v_valuta, v_sort, v_limit, v_id_div){
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
		"http://localhost/cbic/growthfundsummary/query_growth_summary",
		{
			report_type: v_report_type,
			cbgroup_id: v_cbgroup_id,
			product: v_product,
			valuta: v_valuta,
			sort: v_sort,
			limit: v_limit
		},
		function(data,status,xhr){
			var items = [];
			$.each( data.results, function( key, val ) {
				items.push("<tr>");
    			items.push("<td>"+val.customer_group+"</td>");
    			items.push("<td>"+val.a_amount+"</td>");
    			items.push("<td>"+val.b_amount+"</td>");
    			items.push("<td>"+val.percentage+"</td>");
    			items.push("</tr>");
    			//console.log(val.cbgroup_id);
  			});
  			$(v_id_div).html(items);
  		}
	);	
}

function get_fund_summary(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta){
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

	var result=[];
	// $.getJSON(
	// 	"http://localhost/cbic/growthfundsummary/query_fund_summary",
	// 	{
	// 		date: v_date,
	// 		command_date: v_command_date,
	// 		cbgroup_id: v_cbgroup_id,
	// 		product: v_product,
	// 		valuta: v_valuta
	// 	},
	// 	function(data,status,xhr){
	// 		result=data.results;
	// 		$.each( data.results, function( key, val ) {
	// 			result="maul";
	//  			});
	//  			console.log("sfdksafjsak");
	//  		}
	// );

	// Since getJson only apply for async httpGetRequest , I use $.ajax even it's deprecated
	$.ajax({
	    type: 'GET',
	    url: "http://localhost/cbic/growthfundsummary/query_fund_summary",
	    dataType: 'json',
	    success: function(data,status,xhr) { 
	    	result=data.results;
	    },
	    data: {
	    	date: v_date,
			command_date: v_command_date,
			cbgroup_id: v_cbgroup_id,
			product: v_product,
			valuta: v_valuta
	    },
	    async: false
	});
	//console.log(JSON.stringify(result));
	//console.log(JSON.stringify(result));
	return result;
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
	*	process : get the screenshot fund for the certain date
	*	output : group by date, and filter by product, valuta
	*/

	// OPEN
	//var data = get_fund_summary(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta);

	// hardcoded for testing
	var data_json = get_fund_summary('2015-08-01;2015-08-02;2015-08-03', v_command_date, v_cbgroup_id, v_product, v_valuta);
	var data_provider = [];
	$.each( data_json, function( key, val ) {
		var date = new Date(val.date);
		var newDate = date.toString('MMM yyyy');
		console.log(newDate);
	 	data_provider.push(
		    {
		    date: newDate, 
		    amount: val.amount, 
		    color: "#ff9500"
			}
		);
	});
	console.log(JSON.stringify(data_provider));

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

function draw_MtD_graph(v_date, v_command_date, v_cbgroup_id, v_product, v_valuta, v_id_div){
	var chartData = [
	    {
	    	"month":"Aug 15",
	        "this_year": 90,
	        "bulletClass":'lastBullet',
	    },{
	    	"month":"1 Sep",
	        "this_year": 30,
	    },{
	    	"month":"2 Sep",
	        "this_year": 55,
	    },{
	    	"month":"3 Sep",
	        "this_year": 60,
	    },{
	    	"month":"4 Sep",
	        "this_year": 67,
	        "bulletClass":'lastBullet',
	    }  
	];

	var chart = AmCharts.makeChart(v_id_div, {
	  type: "serial",
	  dataDateFormat: "YYYY-MM-DD",
	  dataProvider: chartData,
	  addClassNames: true,
	  startthis_year: 0,
	  color: "black",
	  marginLeft: 0,
	  categoryField: "month",
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
	    valueField: "this_year",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: "#ff9500",
	    balloonText: "[[value]]",
	    lineThickness: 2,
	    legendValueText: "[[value]] (Growth : [[description]]%)",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.6,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[value]]",
	    bulletBorderColor: "#ff9500",
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
	var chartData = [
	    {
	    	"month":"2014",
	        "this_year": 68,
	        "bulletClass":'lastBullet',
	    },{
	    	"month":"Jan 15",
	        "this_year": 30,
	    },{
	    	"month":"Feb 15",
	        "this_year": 50,
	    },{
	    	"month":"Mar 15",
	        "this_year": 23,
	    },{
	    	"month":"Apr 15",
	        "this_year": 34,
	    },{
	    	"month":"Mei 15",
	        "this_year": 70,
	    },{
	    	"month":"Jun 15",
	        "this_year": 230,
	    },{
	    	"month":"Jul 15",
	        "this_year": 78,
	    },{
	    	"month":"Aug 15",
	        "this_year": 90,
	    },{
	    	"month":"4 Sep 15",
	        "this_year": 170,
	        "bulletClass":'lastBullet',
	    }	    
	];


	var chart = AmCharts.makeChart(v_id_div, {
	  type: "serial",
	  dataDateFormat: "YYYY-MM-DD",
	  dataProvider: chartData,
	  addClassNames: true,
	  startthis_year: 0,
	  color: "black",
	  marginLeft: 0,
	  categoryField: "month",
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
	    valueField: "this_year",
	    classNameField: "bulletClass",
	    type: "line",
	    valueAxis: "a2",
	    lineColor: "#ff9500",
	    balloonText: "[[value]]",
	    lineThickness: 2,
	    legendValueText: "[[value]] (Growth : [[description]]%)",
	    fillColorsField: "lineColor",
	    fillAlphas: 0.6,
	    descriptionField: "growth",
	    bullet: "round",
	    labelText: "[[value]]",
	    bulletBorderColor: "#ff9500",
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